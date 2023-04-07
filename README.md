# wp20.wordpress.net
Celebrating 20 years of WordPress

## Installation (requires Docker)

```
npm i
npm run start
```

Your local environment should be running at http://localhost:8888

## Configuration

1. Import `env/wporg_locales.sql` into your database
1. `npm run setup:wp`
1. Activate the Twenty Seventeen - WP20 child theme
1. Import the posts from wp20.wordpress.net
1. Add the Surge constants to your `wp-config.php`:
	```php
	define( 'WP_CACHE', true ); # This may already be existent below, so no need to add if it is.
	define( 'WP_CACHE_CONFIG', __DIR__ . '/surge-config.php' );
	```
1. Add pages titled `What's on`, `News`, `＃WP20 Live (slug: "live")` and `Swag`
1. In Appearance > Menus, add a navigation menu with the pages `What's on`, `News`, `＃WP20 Live` and `Swag` and set as `Top Menu`
1. In Appearance > Menus, add a social menu with items such as Facebook, Twitter, etc. and set as `Social Links Menu`
1. In Appearance > Widgets, remove everything.
1. In Customizer > Header Media, ensure no header image is set
1. In Settings > Reading, ensure your homepage is set to the `What's on` static page
1. Follow setup instructions for the individual plugins below.


## Other Documentation

* [Localization](./wp-content/mu-plugins/README-locales.md)
* [wp20-meetup-events](./wp-content/plugins/wp20-meetup-events/README.md) - If the task you're working on doesn't involve this plugin, you can skip setting it up locally as the setup process can be time-consuming. Would be easier to work on the staging site instead.

## Deploying

1. SSH to server
1. `git pull`
