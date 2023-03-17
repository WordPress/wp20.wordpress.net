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
		'selectWoo',
		WP_CONTENT_URL . '/mu-plugins/assets/selectWoo/css/selectWoo.min.css',
		array(),
		'1.0.10'
	);

	wp_register_script(
		'selectWoo',
		WP_CONTENT_URL . '/mu-plugins/assets/selectWoo/js/selectWoo.min.js',
		array(),
		'1.0.10',
		true
	);
}
