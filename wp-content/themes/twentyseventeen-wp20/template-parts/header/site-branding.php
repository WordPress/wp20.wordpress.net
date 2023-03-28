<div class="site-branding">

	<a class="wp20-wordpress-mark" href="https://wordpress.org/">
		<img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/wordpress-mark.svg" alt="<?php esc_html_e( 'WordPress mark', 'wp20' ); ?>">
	</a>

	<?php the_custom_logo(); ?>

	<?php if ( is_page( 'whats-on' ) ): ?>
	<div class="site-branding-text">
		<em><?php esc_html_e( 'WordPress celebrates twenty years', 'twentyseventeen' ) ?></em>
	</div><!-- .site-branding-text -->
	<?php endif; ?>
</div><!-- .site-branding -->
