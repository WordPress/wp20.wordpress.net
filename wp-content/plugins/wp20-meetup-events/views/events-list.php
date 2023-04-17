<?php

namespace WP20\Meetup_Events;
use WP20\Theme;

defined( 'WPINC' ) || die();

/**
 * @var array $events
 * @var array $strings
 */

?>

<h2 class="screen-reader-text"><?php esc_html_e( 'Events list', 'wp20' ); ?></h2>

<ul class="wp20-events-list">
	<?php foreach ( $events as $event ) : ?>
		<li
			data-name="<?php echo esc_attr( $event['name'] ); ?>"
			data-location="<?php echo esc_attr( $event['location'] ); ?>"
		>
			<h3 class="wp20-event-group">
				<?php echo Theme\prevent_widows_in_content( esc_html( $event['group'] ) ); ?>
			</h3>

			<p class="wp20-event-title">
				<a href="<?php echo esc_url( $event['eventUrl'] ); ?>">
					<?php echo esc_html( Theme\prevent_widows_in_content( $event['name'] ) ); ?>
				</a>
			</p>

			<p class="wp20-event-date-time">
				<?php echo esc_html( $event['time'] ); ?>
			</p>
		</li>
	<?php endforeach; ?>
</ul>

<p class="wp20-events-list-no-results">
	<?php echo esc_html( $strings['search_no_matches'] ); ?>
</p>
