<?php
/**
 * Displays top navigation
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since Twenty Seventeen 1.0
 * @version 1.2
 */

?>	<button class="menu-toggle" aria-controls="top-menu" aria-expanded="false">
		<img class="icon-bars" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/menu-icon.svg" aria-hidden="true"  />
		<img class="icon-close" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/close-icon.svg" aria-hidden="true" />
		<span><?php _e( 'Menu', 'wp20' ); ?></span>
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
