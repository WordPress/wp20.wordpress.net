<?php

namespace WP20\Meetup_Events;
defined( 'WPINC' ) || die();

/** @var array $events */

?>

<form id="wp20-events-filter">
	<label>
		<span><?php esc_html_e( 'Search events:', 'wp20' ); ?></span>
		<?php // translators: Change this to a city in your locale that has a WP20 event planned. If none do, then choose a recognizable city in your locale. ?>
		<input id="wp20-events-query" type="text" value="" placeholder="<?php echo esc_attr_x( 'Seattle', 'Event query placeholder', 'wp20' ); ?>" />
	</label>
</form>

<ul class="wp20-events-list">
	<?php foreach ( $events as $event ) : ?>
		<li data-location="<?php echo esc_attr( $event['location'] ); ?>">
			<h3 class="wp20-event-group">
				<?php echo esc_html( $event['group'] ); ?>
			</h3>

			<p class="wp20-event-title">
				<a href="<?php echo esc_url( $event['eventUrl'] ); ?>">
					<?php echo esc_html( $event['name'] ); ?>
				</a>
			</p>

			<p class="wp20-event-date-time">
				<?php echo esc_html( $event['time'] ); ?>
			</p>
		</li>
	<?php endforeach; ?>
</ul>
