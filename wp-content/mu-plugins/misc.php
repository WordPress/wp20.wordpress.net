<?php

/*
Plugin Name: WP20 - Miscellaneous
Description: Miscellaneous Tweaks
Version:     0.1
Author:      WordPress Meta Team
Author URI:  https://make.wordpress.org/meta
*/

namespace WP20\Misc;

defined( 'WPINC' ) || die();

add_filter( 'map_meta_cap', __NAMESPACE__ . '\allow_css_editing', 10, 2 );
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\register_assets', 1 );
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\register_assets', 1 );
add_action( 'template_redirect', __NAMESPACE__ . '\redirect_old_content', 9 ); // Before redirect_canonical();


/**
 * Allow admins to use Additional CSS, despite `DISALLOW_UNFILTERED_HTML`.
 *
 * The admins on this site are trusted, so `DISALLOW_UNFILTERED_HTML` is mostly in place to enforce best practices,
 * -- like placing JavaScript in a plugin instead of `post_content` -- rather than to prevent malicious code. CSS
 * is an exception to that rule, though; it's perfectly acceptable to store minor tweaks in Additional CSS, that's
 * what it's for.
 *
 * @param array  $required_capabilities The primitive capabilities that are required to perform the requested meta
 *                                      capability.
 * @param string $requested_capability  The requested meta capability.
 *
 * @return array
 */
function allow_css_editing( $required_capabilities, $requested_capability ) {
	if ( 'edit_css' === $requested_capability ) {
		$required_capabilities = array( 'edit_theme_options' );
	}

	return $required_capabilities;
}

/**
 * Register style and script assets for later enqueueing.
 */
function register_assets() {
	wp_register_style(
		'accessible-autocomplete',
		WP_CONTENT_URL . '/mu-plugins/assets/accessible-autocomplete/accessible-autocomplete.min.css',
		array(),
		filemtime( WP_CONTENT_DIR . '/mu-plugins/assets/accessible-autocomplete/accessible-autocomplete.min.css' )
	);

	wp_register_script(
		'accessible-autocomplete',
		WP_CONTENT_URL . '/mu-plugins/assets/accessible-autocomplete/accessible-autocomplete.min.js',
		array(),
		filemtime( WP_CONTENT_DIR . '/mu-plugins/assets/accessible-autocomplete/accessible-autocomplete.min.js' ),
		true
	);
}

/**
 * Redirects old URLs to new ones.
 */
function redirect_old_content() {
	$path_redirects = [
		'/wp20-celebrations/' => '/whats-on/',
	];

	foreach ( $path_redirects as $old_path => $new_url ) {
		if ( str_starts_with( $_SERVER['REQUEST_URI'], $old_path ) ) {
			do_redirect_and_exit( $new_url );
		}
	}
}

/**
 * Do the 301 redirect and exit the script.
 */
function do_redirect_and_exit( $location ) {
	header_remove( 'expires' );
	header_remove( 'cache-control' );

	wp_safe_redirect( $location, 301 );
	exit;
}
