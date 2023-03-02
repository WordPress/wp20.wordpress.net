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
					<?php echo do_shortcode( '[wp20_meetup_events]' ); ?>

					<p>
						<?php esc_html_e( 'Don&rsquo;t see your city? Get in touch with your local group, or organize a group in your town.', 'wp20' ); ?>
					</p>

					<img class="wp20-confetti-divider" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/confetti-divider.svg" alt="" />

					<p class="wp10-nostalgia">
						<?php printf(
							wp_kses_data( __( 'Check out <a href="%s">this post about the WordPress 10th anniversary</a>.', 'wp20' ) ),
							'https://wordpress.org/news/2013/05/ten-good-years/'
						); ?>
					</p>
				</div>

			</article>
		</main>
	</div>
</div>

<?php get_footer();
