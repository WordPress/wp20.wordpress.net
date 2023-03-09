#!/bin/bash

wp rewrite structure '/%postname%/'
wp rewrite flush

# Set the layout to One Column
theme mod set page_layout one-column

# Run all cron tasks (Including Handbook imports from GitHub)
wp cron event run --all