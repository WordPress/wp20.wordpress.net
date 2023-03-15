# wp20.wordpress.net
Celebrating 20 years of WordPress

## Installation (requires Docker)

```
npm i
npm run start
npm run setup:wp
```

Your local environment should be running at http://localhost:8888

## Configuration

1. Activate the Twenty Seventeen - WP20 child theme
1. Import the posts from wp20.wordpress.net
1. Add pages titled `What's on`, `News`, `Live` and `Swag`
1. In Appearance > Menus, add a navigation menu with the pages `What's on`, `News`, `Live` and `Swag` and set as `Top Menu`
1. In Appearance > Menus, add a social menu with items such as Facebook, Twitter, etc. and set as `Social Links Menu`
1. In Appearance > Widgets, remove everything.
1. In Customizer > Header Media, ensure no header image is set
1. In Settings > Reading, ensure your homepage is set to the `What's on` static page

## Other Documentation

* [wp20-meetup-events](./wp-content/plugins/wp20-meetup-events/README.md)
