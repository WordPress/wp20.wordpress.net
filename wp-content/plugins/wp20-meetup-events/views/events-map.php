<?php

namespace WP20\Meetup_Events;
defined( 'WPINC' ) || die();

?>

<h2 class="screen-reader-text"><?php echo esc_html( 'Events map', 'wp20' ); ?></h2>

<div id="wp20-events-map">
	<div class="wp20-spinner spinner spinner-visible"></div>
</div>

<script id="tmpl-wp20-map-marker" type="text/html">
	<div id="wp20-map-marker-{{event.id}}" class="wp20-map-marker">
		<h3 class="wp20-event-group">
			{{event.group}}
		</h3>

		<p class="wp20-event-title">
			<a href="{{event.url}}">
				{{event.name}}
			</a>
		</p>

		<p class="wp20-event-date-time">
			{{event.time}}
		</p>
	</div>
</script>
