<?php get_header(); ?>

<div class="wrap wrap-wide">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<h1 class="entry-title screen-reader-text">
					<?php the_title(); ?>
				</h1>
				
				<div class="entry-content">
					<p>
						<?php esc_html_e( 'Join the conversation by using #WP20 on your favorite social networks.', 'wp20' ); ?>
					</p>
					<div class="entry-content-section">
						<?php echo do_shortcode( '[tagregator hashtag="#WP20"]' ); ?>
					</div>
				</div>

			</article>
		</main>
	</div>
</div>

<?php get_footer();
