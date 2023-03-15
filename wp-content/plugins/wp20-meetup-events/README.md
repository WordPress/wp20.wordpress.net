# WP20 Meetup Events

This plugins creates the `[wp20-meetup-events]` shortcode, which displays a map and list of WP20 events.

This was forked from the [wp15-meetup-events](https://meta.trac.wordpress.org/browser/sites/trunk/wp15.wordpress.net/public_html/content/plugins/wp15-meetup-events?rev=9923) and updated to work with the latest `Meetup_Client`. `Meetup_Client` and it's related classes were forked from `wporg-mu-plugins`. In the future it may be desirable to setup a Composer dependency to keep the code current, but that's not a priority right now, and it could break the plugin when the API changes.


## Setup

1. Add the constants for the Meetup.com API to `wp-config.php`. You can get the live values from your wordpress.org sandbox.
	```php
	define( 'MEETUP_API_KEY', '' );
	define( 'MEETUP_OAUTH_CONSUMER_KEY', '' );
	define( 'MEETUP_OAUTH_CONSUMER_SECRET', '' );
	define( 'MEETUP_USER_PASSWORD', '' );
	define( 'MEETUP_OAUTH_CONSUMER_REDIRECT_URI', 'https://central.wordcamp.org/wp-admin/' ); // Do not change this, the oAuth app only works with the WordCamp URL.
	define( 'MEETUP_USER_EMAIL', 'meetups@wordcamp.org' );
	```
1. Add the constant for the Google Maps API to `wp-config.php`. It's a public key, so make sure it's [configured](https://console.cloud.google.com/projectselector2/google/maps-apis/credentials) to only allow requests from `wp20.wordpress.net`, and only has access to the `Maps JavaScript API`.
	```php
	define( 'GOOGLE_MAPS_PUBLIC_KEY', '' ); // Restricted to wp20.wordpress.net.
	```
1. Update the date range in `prime_events_cache()`.
1. Activate the plugin.
1. SSH to the server and run `wp cron event run wp20_prime_events_cache`. It will output an error with instructions to authenticate via oAuth. The `code` parameter will appear in the redirect URL after a successful authentication.
1. After saving the authorization token, run that command again to import events. Look at each title, and add any false positives to `$false_positives` in `is_wp20_event()`. If any WP20 events were ignored, add a keyword from the title to `$keywords`. Run the command after those changes and make sure it's correct now.
