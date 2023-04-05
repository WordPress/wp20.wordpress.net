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
add_filter( 'upload_mimes' ,         __NAMESPACE__ . '\custom_upload_mimes'              );

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
	wp_enqueue_style( 'selectWoo' );

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

		case 'WordPress turns 20 on May 27, 2023':
			// translators: The tagline for the wp20.wordpress.net website.
			$title = esc_html__( 'WordPress turns 20 on May 27, 2023', 'wp20' );
			break;

		case "What's On":
		case "What’s On":
		case 'What&#8217;s On':
			// translators: The name of the page that lists the global WP20 meetup events. "What's on" means something similar to "what's going on" or "what's happening".
			$title = esc_html__( "What's On", 'wp20' );
			break;

		case 'News':
			// translators: The name of the page that list recent posts.
			$title = esc_html__( 'News', 'wp20' );
			break;

		case '#WP Live':
			// translators: The name of the page that displays the #wp20 social media posts in real time.
			$title = esc_html_x( '#WP Live', 'adjective', 'wp20' );
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
 * Allow extra mime types for the upload of swag files.
 *
 * @return array
 */
function custom_upload_mimes ( $mimes = [] ) {
	$mimes['ai'] = 'application/pdf';

	return $mimes;
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
					'url'  => 'https://wp20.wordpress.net/wp-content/uploads/WP20-logos-pack.zip',
				),
			),
		),
		array(
			'title'             => __( 'Multicolor Logos', 'wp20' ),
			'content'           => __( 'A collection of anniversary logos in six wild color combinations. Made for fun.', 'wp20' ),
			'preview_image_url' => get_stylesheet_directory_uri() . '/images/wp20-logos-colored.svg',
			'files'             => array(
				array(
					'name' => __( 'Multicolor Logos Pack (zip)', 'wp20' ),
					'url'  => 'https://wp20.wordpress.net/wp-content/uploads/WP20-multicolor-logos-pack.zip',
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
					'url'  => 'https://wp20.wordpress.net/wp-content/uploads/wp20-sticker-sheet-1.ai',
				),
				array(
					'name' => __( 'Sticket Sheet (PDF)', 'wp20' ),
					'url'  => 'https://wp20.wordpress.net/wp-content/uploads/wp20-sticker-sheet.pdf',
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
					'url'  => 'https://wp20.wordpress.net/wp-content/uploads/WP20-mystery-pack-1.zip',
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
	<meta property="og:description" content="<?php echo internationalize_titles( 'WordPress turns 20 on May 27, 2023' ); ?>" />
	<meta property="og:url" content="https://wp20.wordpress.net/" />
	<meta property="og:site_name" content="<?php echo internationalize_titles( 'WP20' ); ?>" />
	<meta property="og:image" content="https://wp20.wordpress.net/wp-content/uploads/wp20-logo-anniversary-blueberry@3x.jpeg" />
	<meta property="og:locale" content="<?php echo get_locale(); ?>" />
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:url" content="https://wp20.wordpress.net/" />
	<meta name="twitter:title" content="<?php echo wp_get_document_title(); ?>" />
	<meta name="twitter:description" content="<?php echo internationalize_titles( 'WordPress turns 20 on May 27, 2023' ); ?>" />
	<meta name="twitter:image" content="https://wp20.wordpress.net/wp-content/uploads/wp20-logo-anniversary-blueberry@3x.jpeg" />
	<?php
}

/**
 * Gets a nicely formatted string for the published date.
 */
function posted_datetime() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf(
		$time_string,
		get_the_date( DATE_W3C ),
		get_the_date(),
		get_the_modified_date( DATE_W3C ),
		get_the_modified_date()
	);

	return sprintf(
		/* translators: %s: Post date. */
		__( '<span class="screen-reader-text">Posted on</span> %s', 'twentyseventeen' ),
		$time_string
	);
}

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function render_news_posted_on() {
	// Get the author name; wrap it in a link.
	$byline = sprintf(
		/* translators: %s: Post author. */
		__( '%s', 'wp20' ),
		'<span class="author vcard"><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author_meta( 'display_name' ) . '</a></span>'
	);

	echo '<span class="byline"> ' . $byline . '</span>·<span class="posted-on">' . posted_datetime() . '</span>';
}
