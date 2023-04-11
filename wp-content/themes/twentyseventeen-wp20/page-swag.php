<?php
use WP20\Theme;
?>

<?php get_header(); ?>

	<div class="wrap wrap-wide">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<h1 class="entry-title screen-reader-text"><?php the_title(); ?></h1>
					
					<div class="entry-content">
						<p>
							<?php esc_html_e( 'Print your own swag! These 20th anniversary logos and files are available for download for folks who want to print their own swag:', 'wp20' ); ?>
						</p>

						<ul class="downloads-wrapper">
							<?php foreach ( Theme\get_swag_download_items() as $item ) : ?>
								<li class="downloads-item">
									<div class="downloads-item-preview">
										<img src="<?php echo esc_attr( $item['preview_image_url'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" />
									</div>
									<h2 class="downloads-item-header">
										<?php echo esc_html( $item['title'] ); ?>
									</h2>
									<p class="downloads-item-content"><?php echo esc_html( $item['content'] ); ?></p>
									<?php if ( ! empty( $item['files'] ) ) : ?>
										<ul class="downloads-item-files">
											<?php foreach ( $item['files'] as $file ) : ?>
												<li>
													<a href="<?php echo esc_attr( $file['url'] ); ?>"><?php echo esc_html( $file['name'] ); ?></a>
												</li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>

					</div>

				</article>
			</main>
		</div>
	</div>

<?php get_footer();
