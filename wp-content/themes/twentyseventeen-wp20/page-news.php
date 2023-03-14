<?php get_header(); ?>

	<div class="wrap wrap-unconstrained wp20-news">
		<div id="secondary">
			<h1 class="entry-title">
				<?php
				printf(
					wp_kses_post( __( 'Latest <a href="%s">#WP20</a> <br>Updates', 'wp20' ) ),
					''
				);
				?>
			</h1>
		</div>
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

				<?php
				$query = new WP_Query( array(
					'posts_per_page' => 8,
					'paged'          => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
				) );

				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) : 
						$query->the_post();

						get_template_part( 'template-parts/post/content-excerpt', $query->get_post_format() );

					endwhile;

					$links = paginate_links(
						array(
							'total'     => $query->max_num_pages,
							'prev_text' => __( 'Previous', 'wp20' ),
							'next_text' => __( 'Next', 'wp20' ),
							'before_page_number' => '<span class="screen-reader-text">' . __( 'Page', 'wp20' ) . ' </span>'
						)
					);

					if ( $links ) {
						echo _navigation_markup( $links );
					}

				} else { ?>

					<p><?php esc_html_e( 'Sorry, no news yet. Please check again soon', 'wp20' ); ?></p>

				<?php } ?>

			</main>
		</div>
	</div>

<?php get_footer();
