<?php get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<header class="entry-header">
					<h1 class="entry-title">
						<?php esc_html_e( 'People all over the world are celebrating the WordPress 20th Anniversary on May 27, 2022. Join us!', 'wp20' ); ?>
					</h1>
				</header>

				<div class="entry-content">
					<div class="entry-content-section">
						<?php echo do_shortcode( '[wp20_meetup_events]' ); ?>
					</div>

					<p>
						<?php
							printf(
								wp_kses_post( __( 'Don&rsquo;t see your city? Get in touch with <a href="%1$s">your local group</a> or <a href="%2$s">organize a group in your town</a>.', 'wp20' ) ),
								'',
								''
							);
						?>
					</p>
				</div>

			</article>
		</main>
	</div>
</div>

<?php get_footer();
