<?php get_header(); ?>

<div class="wrap wrap-wide">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<header class="entry-header">
					<h1 class="entry-title">
						<?php esc_html_e( 'People all over the world are celebrating the WordPress 20th Anniversary on May 27, 2023. Join the meetups throughout the whole year!', 'wp20' ); ?>
					</h1>
				</header>

				<div class="entry-content">
					<?php echo do_shortcode( '[wp20_meetup_events]' ); ?> 
				</div>

			</article>
		</main>
	</div>
</div>

<?php get_footer();
