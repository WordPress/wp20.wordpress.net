			<div class="wrap">
				<div class="wp20-confetti-divider">
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/wp20-logo-blue.svg" alt="" />
				</div>

				<p class="wp10-nostalgia">
					<?php printf(
						wp_kses_data( __( 'Check out <a href="%s">this post about the WordPress 10th anniversary</a>.', 'wp20' ) ),
						'https://wordpress.org/news/2013/05/ten-good-years/'
					); ?>
				</p>
			</div>	

		</div><!-- #content -->


		<footer id="colophon" class="site-footer">
			<div class="wrap">
				<?php
				get_template_part( 'template-parts/footer/footer', 'widgets' );

				if ( has_nav_menu( 'social' ) ) :
					?>
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
					<?php
				endif;

				get_template_part( 'template-parts/footer/site', 'info' );
				?>
			</div><!-- .wrap -->
		</footer><!-- #colophon -->
	</div><!-- .site-content-contain -->
</div><!-- #page -->
<?php wp_footer(); ?>

</body>
</html>
