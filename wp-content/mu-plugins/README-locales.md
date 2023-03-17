# Locales

`locales.php` downloads PO/MO files from translate.wordpress.org and loads them into WordPress. It also displays a UI widget on the front end so that users can choose their locale. It works with `locale-detection/`.

There are three parts to the process:

1. Strings from this repository are imported into translate.wordpress.org.
1. Translators from the Polyglots team use GlotPress to translate the strings.
1. The translated strings are downloaded from GlotPress and loaded into WordPress.


## wp20 -> GlotPress

The strings in this repo are imported into translate.wordpress.org regularly via a cron job that runs `generate-pot.sh` on the Translate site. It downloads a copy of this repository and generates a `.pot` file with strings in certain directories with the `wp20` text domain. Then that gets imported into GlotPress so that the strings can be translated.

The details can be seen in `r20131-dotorg`.


## GlotPress -> wp20

The cron job in `update_pomo_files()` downloads PO/MO files from GlotPress, and loads them as into the WP.

### Local setup

1. import `wporg_locales.sql`
1. Run `wp cron event run wp20_update_pomo_files` to download localization files. This will take about 5 minutes the first time.
