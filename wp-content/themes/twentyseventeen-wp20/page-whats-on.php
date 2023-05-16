<?php get_header(); ?>

<div class="wrap wrap-wide">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<header class="entry-header">
					<div class="wp20-events-header">
						<h1 class="entry-title">
							<?php esc_html_e( 'People all over the world are celebrating the WordPress 20th Anniversary on May 27, 2023.', 'wp20' ); ?>
						</h1>
						<h2>
							<?php printf(
								wp_kses_post( __( 'Below are listed all of the <a href="%s">WordPress Chapter meetups</a> that are hosting events. Don’t see one in your area? <a href="%s">Apply to start one today!</a>', 'wp20' ) ),
									'https://make.wordpress.org/community/handbook/meetup-organizer/meetup-program-basics/',
									'https://make.wordpress.org/community/handbook/meetup-organizer/getting-started/interest-form/'
							); ?>
						</h2>
					</div>

					<?php echo do_shortcode( '[wp20_meetup_events_filter]' ); ?>
				</header>

				<div class="entry-content">
					<?php
						echo do_shortcode( '[wp20_meetup_events_map]' );
						echo do_shortcode( '[wp20_meetup_events_list]' );
					?>
				</div>

			</article>
		</main>
	</div>
</div>

<?php get_footer();
