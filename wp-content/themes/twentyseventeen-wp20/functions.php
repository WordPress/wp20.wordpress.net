<?php

namespace WP20\Theme;

defined( 'WPINC' ) || die();

add_filter( 'template_include',      __NAMESPACE__ . '\get_front_page_template'          );
add_action( 'wp_enqueue_scripts',    __NAMESPACE__ . '\enqueue_scripts'                  );
add_filter( 'get_custom_logo',       __NAMESPACE__ . '\set_custom_logo'                  );
add_filter( 'body_class',            __NAMESPACE__ . '\add_body_classes'                 );
add_filter( 'the_title',             __NAMESPACE__ . '\internationalize_titles'          );
add_filter( 'document_title_parts',  __NAMESPACE__ . '\internationalize_document_titles' );
add_filter( 'wp_get_nav_menu_items', __NAMESPACE__ . '\internationalize_menu_items'      );
add_action( 'wp_head',               __NAMESPACE__ . '\render_social_meta_tags'          );


/**
 * Bypass TwentySeventeen's front-page template.
 *
 * When a static front page is configured, its corresponding template should be used to render the page, not
 * TwentySeventeen's generic front-page template.
 *
 * @param string $template
 *
 * @return string
 */
function get_front_page_template( $template ) {
	if ( false !== strpos( $template, 'twentyseventeen/front-page.php' ) ) {
		$template = get_page_template();
	}

	return $template;
}

/**
 * Register custom fonts.
 */
function get_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'cyrillic,cyrillic-ext,greek,greek-ext,latin,latin-ext,vietnamese';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Inter, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Inter font: on or off', 'wp20' ) ) {
		$fonts[] = 'Inter:200,400,400i,600,700';
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by EB Garamond, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'EB Garamond font: on or off', 'wp20' ) ) {
		$fonts[] = 'EB Garamond:400';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => rawurlencode( implode( '|', $fonts ) ),
			'subset' => rawurlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}

/**
 * Enqueue scripts and styles
 */
function enqueue_scripts() {
	wp_register_style(
		'twentyseventeen-wp20-fonts',
		get_fonts_url()
	);

	wp_register_style(
		'twentyseventeen-parent-style',
		get_template_directory_uri() . '/style.css'
	);

	wp_enqueue_style(
		'twentyseventeen-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'twentyseventeen-parent-style', 'twentyseventeen-wp20-fonts', 'dashicons' ),
		filemtime( __DIR__ . '/style.css' )
	);

	// Styles for locale switcher.
	wp_enqueue_style( 'select2' );

	wp_enqueue_script(
		'twentyseventeen-wp20-front-end',
		get_theme_file_uri( '/assets/js/front-end.js' ),
		array( 'jquery', 'twentyseventeen-global' ),
		1,
		true
	);
}

/**
 * Add the post's slug to the body tag
 *
 * For CSS developers, this is better than relying on the post ID, because that often changes between their local
 * development environment and production, and manually importing/exporting is inconvenient.
 *
 * @param array $body_classes
 *
 * @return array
 */
function add_body_classes( $body_classes ) {
	global $wp_query;
	$post = $wp_query->get_queried_object();

	if ( is_a( $post, 'WP_Post' ) ) {
		$body_classes[] = $post->post_type . '-slug-' . sanitize_html_class( $post->post_name, $post->ID );
	}

	return $body_classes;
}

/**
 * Set the custom logo.
 *
 * @return string
 */
function set_custom_logo() {
	ob_start();

	?>

	<a href="<?php echo esc_url( home_url() ); ?>" class="custom-logo-link" rel="home" itemprop="url">
		<img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/wp20-logo-white.svg" class="custom-logo" alt="<?php esc_html_e( 'WP20 logo', 'wp20' ); ?>" itemprop="logo" />
	</a>

	<?php

	return ob_get_clean();
};

/**
 * Internationalize the menu item titles.
 *
 * @param string $title
 *
 * @return string
 */
function internationalize_titles( $title ) {
	switch ( $title ) {
		case 'WP20':
			// translators: The title of the wp20.wordpress.net website.
			$title = esc_html__( 'WP20', 'wp20' );
			break;

		case 'WordPress turns 15 on May 27, 2018':
			// translators: The tagline for the wp20.wordpress.net website.
			$title = esc_html__( 'WordPress turns 15 on May 27, 2018', 'wp20' );
			break;

		case 'About':
			// translators: The name of the page that describes the WP20 celebrations.
			$title = esc_html__( 'About', 'wp20' );
			break;

		case 'Live':
			// translators: The name of the page that displays the #wp20 social media posts in real time.
			$title = esc_html_x( 'Live', 'adjective', 'wp20' );
			break;

		case 'Swag':
			// translators: "Swag" is a term for promotional items. This is the title of the page.
			$title = esc_html__( 'Swag', 'wp20' );
			break;
	}

	return $title;
}

/**
 * Internationalize the document's `<title>` element.
 *
 * @param array $title_parts
 *
 * @return array
 */
function internationalize_document_titles( $title_parts ) {
	$title_parts['title'] = internationalize_titles( $title_parts['title'] );

	if ( isset( $title_parts['site'] ) ) {
		$title_parts['site'] = internationalize_titles( $title_parts['site'] );
	}

	if ( isset( $title_parts['tagline'] ) ) {
		$title_parts['tagline'] = internationalize_titles( $title_parts['tagline'] );
	}

	return $title_parts;
}

/**
 * Internationalize the menu item titles.
 *
 * @param array $items
 *
 * @return array
 */
function internationalize_menu_items( $items ) {
	foreach ( $items as $item ) {
		$item->post_title = internationalize_titles( $item->post_title );
	}

	return $items;
}

/**
 * Data for the Swag page download items.
 *
 * @return array
 */
function get_swag_download_items() {
	return array(
		/*
		array(
			'title'             => __( '', 'wp20' ),
			'excerpt'           => __( '', 'wp20' ),
			'preview_image_url' => '',
			'files'             => array(
				array(
					'name' => __( '', 'wp20' ),
					'url'  => '',
				),
			),
		),
		*/
		array(
			'title'             => __( 'WP20 Logos', 'wp20' ),
			'content'           => __( 'Official anniversary logos in three signature colors: blueberry, black, and white.', 'wp20'	),
			'preview_image_url' => get_stylesheet_directory_uri() . '/images/wp20-logo-blue.svg',
			'files'             => array(
				array(
					'name' => __( 'WP20 Logos Pack (zip)', 'wp20' ),
					'url'  => '',
				),
			),
		),
		array(
			'title'             => __( 'Colored Logos', 'wp20' ),
			'content'           => __( 'A collection of anniversary logos in six wild color combinations. Made for fun.', 'wp20' ),
			'preview_image_url' => get_stylesheet_directory_uri() . '/images/wp20-logos-colored.svg',
			'files'             => array(
				array(
					'name' => __( 'Multicolor Logos Pack (zip)', 'wp20' ),
					'url'  => '',
				),
			),
		),
		array(
			'title'             => __( 'Sticker Sheet', 'wp20' ),
			'content'           => __( 'Stuck on WordPress? Bring the WP20 celebration to any surface.', 'wp20' ),
			'preview_image_url' => get_stylesheet_directory_uri() . '/images/stickers.svg',
			'files'             => array(
				array(
					'name' => __( 'Sticker Sheet (Ai)', 'wp20' ),
					'url'  => '',
				),
				array(
					'name' => __( 'Sticket Sheet (PDF)', 'wp20' ),
					'url'  => '',
				),
			),
		),
		array(
			'title'             => __( 'Mystery Pack', 'wp20' ),
			'content'           => __( 'Surprise designs you’ll want to keep. Print them and use them however you like.', 'wp20' ),
			'preview_image_url' => get_stylesheet_directory_uri() . '/images/mystery.svg',
			'files'             => array(
				array(
					'name' => __( 'Mystery Pack (zip)', 'wp20' ),
					'url'  => '',
				),
			),
		),
	);
}

/**
 * Output social media-related meta tags for the document header.
 */
function render_social_meta_tags() {
	?>
	<meta property="og:type" content="website" />
	<meta property="og:title" content="<?php echo wp_get_document_title(); ?>" />
	<meta property="og:description" content="<?php echo internationalize_titles( 'WordPress turns 15 on May 27, 2018' ); ?>" />
	<meta property="og:url" content="https://wp20.wordpress.net/" />
	<meta property="og:site_name" content="<?php echo internationalize_titles( 'WP20' ); ?>" />
	<meta property="og:image" content="https://wp20.wordpress.net/content/uploads/2018/03/wp20-logo-square.png" />
	<meta property="og:locale" content="<?php echo get_locale(); ?>" />
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:url" content="https://wp20.wordpress.net/" />
	<meta name="twitter:title" content="<?php echo wp_get_document_title(); ?>" />
	<meta name="twitter:description" content="<?php echo internationalize_titles( 'WordPress turns 15 on May 27, 2018' ); ?>" />
	<meta name="twitter:image" content="https://wp20.wordpress.net/content/uploads/2018/03/wp20-logo-square.png" />
	<?php
}
