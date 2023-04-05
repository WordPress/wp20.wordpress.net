<?php

use WP20\Locales;

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#content">
			<?php esc_html_e( 'Skip to content', 'twentyseventeen' ); ?>
		</a>

		<header id="masthead" class="site-header" role="banner">
			<?php get_template_part( 'template-parts/header/header', 'image' ); ?>

			<?php if ( has_nav_menu( 'top' ) ) : ?>
				<div class="navigation-top-container">
					<div class="navigation-top">
						<div class="wrap wrap-wide">
							<?php get_template_part( 'template-parts/header/navigation', 'top' ); ?>
							<?php Locales\locale_switcher(); ?>
							<div class="navigation-top-menu-container" data-placeholder="<?php esc_attr_e( 'Search languages...', 'wp20' ); ?>"></div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</header>

		<?php Locales\locale_notice(); ?>

		<div class="site-content-contain">
			<div id="content" class="site-content">
