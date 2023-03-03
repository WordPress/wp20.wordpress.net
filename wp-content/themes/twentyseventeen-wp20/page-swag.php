<?php
use WP20\Theme;
?>

<?php get_header(); ?>

	<div class="wrap">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<header class="entry-header">
						<h1 class="entry-title"><?php esc_html_e( 'Print your own swag', 'wp20' ); ?></h1>
					</header>
					
					<div class="entry-content">
						<p>
							<?php esc_html_e( 'These 20th anniversary logos and files are available for download for folks who want to print their own swag:', 'wp20' ); ?>
						</p>

						<ul class="entry-content-section downloads-wrapper">
							<?php foreach ( Theme\get_swag_download_items() as $item ) : ?>
								<li class="downloads-item">
									<div class="downloads-item-preview">
										<img src="<?php echo esc_attr( $item['preview_image_url'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" />
									</div>
									<div class="downloads-item-header">
										<strong><?php echo esc_html( $item['title'] ); ?></strong>
									</div>
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

						<p>
							<?php
							printf(
								wp_kses_post( __( 'Check out the <a href="%s">WordPress Store</a> if you\'d like to purchase WordPress 20th anniversary swag.', 'wp20' ) ),
								'https://mercantile.wordpress.org/product-category/wordpress-20/'
							);
							?>
						</p>

					</div>

				</article>
			</main>
		</div>
	</div>

<?php get_footer();
