<?php get_header(); ?>

	<div class="wrap wp20-news">
		
		<div id="secondary">
			<header class="page-header">
				<h1 class="page-title">
					<?php echo wp_kses_post( __( 'Latest #WP20 <br>News', 'wp20' ) ); ?>
				</h1>
			</header>
		</div>

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

				<?php
				$query = new WP_Query( array(
					'posts_per_page' => 8,
					'paged'          => is_front_page() ? get_query_var( 'page', 1 ) : get_query_var( 'paged', 1 ),
				) );

				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) : 
						$query->the_post();

						get_template_part( 'template-parts/post/content-excerpt', $query->get_post_format() );

					endwhile;

					$paginate_links_args = array(
						'total'              => $query->max_num_pages,
						'prev_text'          => __( '<span class="nav-subtitle">Previous</span>', 'wp20' ),
						'next_text'          => __( '<span class="nav-subtitle">Next</span>', 'wp20' ),
						'before_page_number' => '<span class="screen-reader-text">' . __( 'Page', 'wp20' ) . ' </span><span class="nav-subtitle">',
						'after_page_number'  => '</span>',
					);

					if ( is_front_page() ) {
						$paginate_links_args['current'] = $query->get( 'paged', 1 );
					}

					$links = paginate_links( $paginate_links_args );

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
