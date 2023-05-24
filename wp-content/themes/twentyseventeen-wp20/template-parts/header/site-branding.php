<?php
use WP20\Theme;
?>

<div class="site-branding">

	<a class="wp20-wordpress-mark" href="https://wordpress.org/">
		<img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/wordpress-mark.svg" alt="<?php esc_html_e( 'WordPress mark', 'wp20' ); ?>">
	</a>

	<?php the_custom_logo(); ?>

	<?php if ( is_front_page() ): ?>
	<div class="site-branding-text">
		<em>
			<?php echo esc_html( Theme\prevent_widows_in_content( __( 'WordPress celebrates twenty years', 'wp20' ) ) ) ?>
		</em>
	</div><!-- .site-branding-text -->
	<?php endif; ?>
</div><!-- .site-branding -->
