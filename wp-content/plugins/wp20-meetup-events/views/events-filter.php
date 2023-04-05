<form id="wp20-events-filter">
	<label for="wp20-events-query">
		<span>
			<?php esc_html_e( 'Search events:', 'wp20' ); ?>
		</span>
	</label>

	<!-- The design calls for the input placeholder to take the place of the label on mobile, but `::placeholder`
		 doesn't support the `content` attribute, so we need two inputs. Only one will be shown at a time.
	-->
	<input
		id="wp20-events-query-mobile"
		class="wp20-events-query"
		type="text"
		value=""
		placeholder="<?php echo esc_attr__( 'Search events', 'wp20' ); ?>"
		aria-label="<?php esc_html_e( 'Search events:', 'wp20' ); ?>"
	/>

	<input
		id="wp20-events-query-desktop"
		class="wp20-events-query"
		type="text"
		value=""
		<?php // translators: Change this to a city in your locale that has a WP20 event planned. If none do, then choose a recognizable city in your locale. ?>
		placeholder="<?php echo esc_attr_x( 'Seattle', 'Event query placeholder', 'wp20' ); ?>"
		aria-label="<?php esc_html_e( 'Search events:', 'wp20' ); ?>"
	/>

	<button type="submit">
		<img src="<?php echo esc_url( plugins_url( '/images/search.svg', __DIR__ ) ); ?>" alt="Search" />
	</button>
</form>
