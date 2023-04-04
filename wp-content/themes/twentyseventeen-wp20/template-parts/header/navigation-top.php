<?php
/**
 * Displays top navigation
 */


?>	<button class="menu-toggle" aria-controls="top-menu" aria-expanded="false">
		<img class="icon-bars" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/menu-icon.svg" aria-hidden="true"  />
		<img class="icon-close" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/close-icon.svg" aria-hidden="true" />
		<span><?php esc_html_e( get_the_title() ); ?></span>
</button>

<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'wp20' ); ?>">

	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'top',
			'menu_id'        => 'top-menu',
		)
	);
	?>

</nav><!-- #site-navigation -->
