			<div class="wrap">

			<?php if ( has_nav_menu( 'social' ) && ( is_page('news') || is_single() ) ) :
			?>
				<div class="wp20-social">
					<p>Follow WordPress for upcoming details</p>
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

				<div class="wp20-confetti-divider">
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/wp20-logo-blue-ext.svg" alt="<?php esc_html_e( 'WP20 logo', 'wp20' ); ?>" itemprop="logo" />
				</div>

				<p class="wp10-nostalgia">
					<?php printf(
						wp_kses_data( __( 'Feeling nostalgic? Check out <a href="%s">this post about the WordPress 15th anniversary</a>.', 'wp20' ) ),
						'https://wordpress.org/news/2018/04/celebrate-the-wordpress-15th-anniversary-on-may-27/'
					); ?>
				</p>
			</div>
		</div><!-- #content -->


		<footer id="colophon" class="site-footer">
			<div class="wrap">
				<?php
				get_template_part( 'template-parts/footer/footer', 'widgets' );

				get_template_part( 'template-parts/footer/site', 'info' );
				?>
			</div><!-- .wrap -->
		</footer><!-- #colophon -->
	</div><!-- .site-content-contain -->
</div><!-- #page -->
<?php wp_footer(); ?>

</body>
</html>
