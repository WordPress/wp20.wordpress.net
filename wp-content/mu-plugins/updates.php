<?php

/*
Plugin Name: WP20 - Updates
Description: Automatically update Core, plugins, themes, and translations
Version:     0.1
Author:      WordPress Meta Team
Author URI:  https://make.wordpress.org/meta
*/

namespace WP20\Updates;
defined( 'WPINC' ) || die();

/*
 * Auto update everything, even major Core releases, to minimize the maintenance burden.
 */
add_filter( 'allow_minor_auto_core_updates', '__return_true' );
add_filter( 'allow_major_auto_core_updates', '__return_true' );
add_filter( 'auto_update_plugin',            '__return_true' );
add_filter( 'auto_update_theme',             '__return_true' );
add_filter( 'auto_update_translation',       '__return_true' );

