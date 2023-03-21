<?php

/*
Plugin Name: WP20 - Locales
Description: Manage front-end locale switching.
Version:     0.1
Author:      WordPress Meta Team
Author URI:  https://make.wordpress.org/meta
*/


namespace WP20\Locales;
use GP_Locales, WP_CLI, cli\progress\Bar;

defined( 'WPINC' ) || die();

if ( ! wp_next_scheduled( 'wp20_update_pomo_files' ) ) {
	wp_schedule_event( time(), 'hourly', 'wp20_update_pomo_files' );
}

add_action( 'plugins_loaded', __NAMESPACE__ . '\load_locale_detection' );
add_filter( 'wp20_update_pomo_files', __NAMESPACE__ . '\update_pomo_files' );
add_action( 'plugins_loaded', __NAMESPACE__ . '\textdomain' );
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\register_assets' );


/**
 * Load the Locale Detection plugin.
 */
function load_locale_detection() : void {
	require_once trailingslashit( dirname( __FILE__ ) ) . 'locale-detection/locale-detection.php';
}

/**
 * Update the PO/MO files for the wp20 text domain.
 */
function update_pomo_files() {
	/*
	 * The content will probably not need to be updated after the event is over. Updating it anyway would use up API
	 * resources needlessly, and introduce the risk of overwriting the valid data with invalid data if something breaks.
	 */
	if ( time() >= strtotime( 'June 15, 2023' ) ) {
		return;
	}

	$gp_api            = 'https://translate.wordpress.org';
	$gp_project        = 'meta/wp20';
	$localizations_dir = WP_CONTENT_DIR . '/languages/wp20';
	$set_response      = wp_remote_get( "$gp_api/api/projects/$gp_project" );
	$body              = json_decode( wp_remote_retrieve_body( $set_response ) );
	$translation_sets  = isset( $body->translation_sets ) ? $body->translation_sets : false;
	$in_wpcli          = defined( 'WP_CLI' ) && WP_CLI;

	if ( ! $translation_sets ) {
		log( 'Translation sets missing from response body.' );
		return;
	}

	update_option( 'wp20_locale_data', $translation_sets );
	wp_mkdir_p( $localizations_dir );

	if ( $in_wpcli ) {
		$progress = new Bar( 'Importing PO/MO files', count( $translation_sets ) );
	}

	foreach ( $translation_sets as $set ) {
		if ( empty( $set->locale ) || empty( $set->wp_locale ) ) {
			continue;
		}

		$po_response = wp_remote_get( "$gp_api/projects/$gp_project/{$set->locale}/default/export-translations?filters[status]=current&format=po" );
		$mo_response = wp_remote_get( "$gp_api/projects/$gp_project/{$set->locale}/default/export-translations?filters[status]=current&format=mo" );
		$po_content  = wp_remote_retrieve_body( $po_response );
		$mo_content  = wp_remote_retrieve_body( $mo_response );

		if ( ! $po_content || ! $mo_content || false === strpos( $po_content, 'Project-Id-Version: Meta - wp20.wordpress.net' ) ) {
			log( "Invalid PO/MO content for {$set->wp_locale}." );
			continue;
		}


		$wrote_po = file_put_contents( "$localizations_dir/wp20-{$set->wp_locale}.po", $po_content );
		$wrote_mo = file_put_contents( "$localizations_dir/wp20-{$set->wp_locale}.mo", $mo_content );

		if ( ! $wrote_po || ! $wrote_mo ) {
			log( "Failed to write PO and/or MO files for {$set->wp_locale}." );
		}

		if ( $in_wpcli ) {
			$progress->tick();
		}
	}


	if ( $in_wpcli ) {
		$progress->finish();
	}
}



/**
 * Load the wp20 textdomain.
 */
function textdomain() {
	$path   = WP_LANG_DIR . '/wp20';
	$mofile = 'wp20-' . get_locale() . '.mo';

	load_textdomain( 'wp20', $path . '/' . $mofile);
}

/**
 * Register style and script assets for later enqueueing.
 */
function register_assets() {
	// Locale switcher script.
	wp_register_script(
		'locale-switcher',
		WP_CONTENT_URL . '/mu-plugins/assets/locale-switcher.js',
		array( 'jquery', 'selectWoo', 'utils' ),
		filemtime( __DIR__ . '/assets/locale-switcher.js' ),
		true
	);

	wp_localize_script(
		'locale-switcher',
		'WP20LocaleSwitcher',
		array(
			'locale' => get_locale(),
			'dir'    => is_rtl() ? 'rtl' : 'ltr',
			'cookie' => array(
				'expires' => YEAR_IN_SECONDS,
				'cpath'   => SITECOOKIEPATH,
				'domain'  => '',
				'secure'  => true,
			)
		)
	);
}

/**
 * Retrieves all available locales with their native names.
 *
 * See https://meta.trac.wordpress.org/browser/sites/trunk/wordpress.org/public_html/wp-content/themes/pub/wporg-login/functions.php?rev=6679#L150
 *
 * @return array Locales with their native names.
 */
function get_locales() {
	wp_cache_add_global_groups( [ 'locale-associations' ] );

	$wp_locales = wp_cache_get( 'locale-list', 'locale-associations' );
	if ( false === $wp_locales ) {
		$wp_locales = (array) $GLOBALS['wpdb']->get_col( 'SELECT locale FROM wporg_locales' );
		wp_cache_set( 'locale-list', $wp_locales, 'locale-associations' );
	}

	$wp_locales[] = 'en_US';

	require_once trailingslashit( dirname( __FILE__ ) ) . 'locales/locales.php';

	$locales = [];

	foreach ( $wp_locales as $locale ) {
		$gp_locale = GP_Locales::by_field( 'wp_locale', $locale );
		if ( ! $gp_locale ) {
			continue;
		}

		$locales[ $locale ] = $gp_locale->native_name;
	}

	natsort( $locales );

	return $locales;
}

/**
 * Prints markup for a simple language switcher.
 *
 * See https://meta.trac.wordpress.org/browser/sites/trunk/wordpress.org/public_html/wp-content/themes/pub/wporg-login/functions.php?rev=6679#L184
 */
function locale_switcher() : void {
	$current_locale = get_locale();

	?>

	<div class="wp20-locale-switcher-container">
		<form id="wp20-locale-switcher-form" action="" method="GET">
			<label for="wp20-locale-switcher">
				<span class="screen-reader-text"><?php esc_html_e( 'Select the language:', 'wp20' ); ?></span>
			</label>

			<select id="wp20-locale-switcher" name="locale">
				<?php

				foreach ( get_locales() as $locale => $locale_name ) {
					printf(
						'<option value="%s"%s>%s</option>',
						esc_attr( $locale ),
						selected( $locale, $current_locale, false ),
						esc_html( $locale_name )
					);
				}

				?>
			</select>
		</form>
	</div>

	<?php

	wp_enqueue_script( 'locale-switcher' );
}

/**
 * Prints markup for a notice when a locale isn't fully translated.
 */
function locale_notice() : void {
	$locale_data = get_option( 'wp20_locale_data', array() );

	if ( empty( $locale_data ) ) {
		return;
	}

	$current_locale = get_locale();
	$statuses       = wp_list_pluck( $locale_data, 'percent_translated', 'wp_locale' );
	$mapped_locales = wp_list_pluck( $locale_data, 'locale', 'wp_locale' );
	$threshold      = 90;
	$is_dismissed   = ! empty( $_COOKIE['wp20-locale-notice-dismissed'] );

	if ( isset( $statuses[ $current_locale ] ) && absint( $statuses[ $current_locale ] ) <= $threshold && ! $is_dismissed ) :
		$contribute_url = 'https://translate.wordpress.org/projects/meta/wp20/';

		if ( isset( $mapped_locales[ $current_locale ] ) ) {
			$contribute_url .= $mapped_locales[ $current_locale ] . '/default';
		}
	?>
		<div class="wp20-locale-notice">
			<p>
				<?php
				printf(
					/* translators: %s placeholder is a URL. */
					wp_kses_post( __( 'The translation for this locale is incomplete. Help us get to 100 percent by <a href="%s">contributing a translation</a>.', 'wp20' ) ),
					esc_url( $contribute_url )
				);
				?>
			</p>
			<button type="button" class="wp20-locale-notice-dismiss">
				<span class="screen-reader-text"><?php _e( 'Dismiss this notice.' ); ?></span>
			</button>
		</div>
	<?php endif;
}

/**
 * Send a message to the error log and WP-CLI output.
 */
function log( string $message ) : void {
	trigger_error( $message, E_USER_WARNING );

	if ( defined( 'WP_CLI' ) && WP_CLI ) {
		WP_CLI::warning( $message );
	}
}
