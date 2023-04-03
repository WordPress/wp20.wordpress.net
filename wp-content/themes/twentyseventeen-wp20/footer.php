			<div class="wp20-footer">
				<div class="wrap wrap-wide">
					<p>
						<?php 
							if ( is_page( 'swag' ) ) {
								printf(
									wp_kses_data( __( 'Check out the <a href="%s">WordPress Swag Store</a> to get your hands on new, limited edition WP20 swag.', 'wp20' ) ),
									'https://mercantile.wordpress.org/product-category/wp20/'
								);
							} elseif ( is_page( 'whats-on' )) {
								printf(
									wp_kses_post( __( '<strong>Don’t see your city?</strong><br> Get in touch with <a href="%s">your local group</a>, or <a href="%s">organize a group in your town</a>.', 'wp20' ) ),
									'https://www.meetup.com/pro/wordpress/',
									'https://make.wordpress.org/community/handbook/meetup-organizer/welcome/'
								);
							} else {
								echo wp_kses_post( __( 'Follow <strong>#WP20</strong> on social for latest updates, or be part of celebration by posting.', 'wp20' ) );
							}
						?>
					</p>

					<p class="wp20-nostalgia">
						<?php printf(
							wp_kses_post( __( '<strong>Feeling nostalgic?</strong><br> Check out <a href="%s">this post about the WordPress 15th anniversary</a>.', 'wp20' ) ),
							'https://wordpress.org/news/2018/04/celebrate-the-wordpress-15th-anniversary-on-may-27/'
						); ?>
					</p>

					<div class="wp20-confetti-divider">
						<img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/wp20-logo-blue-ext.svg" alt="<?php esc_html_e( 'WP20 logo', 'wp20' ); ?>" itemprop="logo" />
					</div>
				</div>
			</div>
		</div><!-- #content -->


		<footer id="colophon" class="site-footer">
			<div class="wrap wrap-wide">
				<a class="wp20-wordpress-logo" href="https://wordpress.org/">
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/wordpress-logo.svg" alt="<?php esc_html_e( 'WordPress logo', 'wp20' ); ?>">
				</a>

				<a class="wp20-wordpress-mark" href="https://wordpress.org/">
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/wordpress-mark.svg" alt="<?php esc_html_e( 'WordPress mark', 'wp20' ); ?>">
				</a>
				
				<div class="wp20-poetry">
					<img src="https://s.w.org/style/images/code-is-poetry-for-dark-bg.svg" alt="Code is Poetry" width="188" height="13">
				</div>

				<?php if ( has_nav_menu( 'social' ) ) :
				?>
					<div class="wp20-social">
						<nav class="social-navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'twentyseventeen' ); ?>">
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'social',
									'menu_class'     => 'social-links-menu',
									'depth'          => 1,
									'link_before'    => '<span class="screen-reader-text">',
									'link_after'     => '</span>' . twentyseventeen_get_svg( array( 'icon' => 'chain' ) ),
								)
							);
							?>
						</nav><!-- .social-navigation -->
					</div>
					<?php
				endif;
				?>
			</div><!-- .wrap -->
		</footer><!-- #colophon -->
	</div><!-- .site-content-contain -->
</div><!-- #page -->
<?php wp_footer(); ?>

</body>
</html>
