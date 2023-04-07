#!/bin/bash

wp rewrite structure '/%postname%/'
wp rewrite flush

# Set the layout to One Column
wp theme mod set page_layout one-column

# Plugin setup
wp plugin install surge custom-twitter-feeds --activate
wp plugin deactivate wp20-meetup-events

# Run all cron tasks (Including Handbook imports from GitHub)
wp cron event run --all
