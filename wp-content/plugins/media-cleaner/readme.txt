=== Media Cleaner ===
Contributors: TigrouMeow
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=H2S7S3G4XMJ6J
Tags: management, admin, file, files, images, image, media, library, upload, clean, cleaning
Requires at least: 3.5
Tested up to: 4.5.3
Stable tag: 3.2.9

Clean your Media Library and Uploads directory from the files which are not used.

== Description ==

Clean your Media Library from the media which aren't used in any of your posts, gallery and so on. First, before using this plugin, make sure you have a proper backup of all your files and database. This is the most important step on the usage of this plugin, you can't trust any file deletion tools. The Pro version of this plugin brings also scanning to the /uploads folder and will detect which files aren't registered in the Media Library and not used in your content. Retina images are also detected and supported, shortcodes, HTML in sidebars and of course your posts, pages and all post types.

**UNIQUE PLUGIN**. Such a plugin is difficult to create and to maintain. If you understand WordPress, you probably know why. This plugin tries its best to help you. Get used to it and you will get awesome results. This is the only plugin to propose those functions and even a dashboard to cleanup your WordPress install from unused files.

**DASHBOARD**. Those file will be shown in a specific dashboard. At this point, it will be up to you to delete them. Files detected as un-used are added to a specific dashboard where you can choose to trash them. They will be then moved to a trash internal to the plugin. After more testing, you can trash them definitely.

**FREE / PRO**. The Free version of the plugin works with the media available in your Media Library. The Pro version adds file scanning to your physical /uploads directory.

**AGAIN, BE CAREFUL**. Again, this plugin deletes files so... be careful! Backup is not only important, it is **necessary**. Don't use this plugin if you don't understand how WordPress works.

It has been tested with WP Retina 2x and WPML.

Languages: English, French.

== Installation ==

1. Upload `media-file-cleaner` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go in the Settings -> Media Cleaner and check the appropriate options
3. Go in Media -> Media Cleaner

== Upgrade Notice ==

Replace all the files. Nothing else to do.

== Frequently Asked Questions ==

= Is it safe? =
No! :) How can a plugin that deletes files be 100% safe? ;) I did my best (and will improve it in every way I can) but it is impossible to cover all the cases. On a normal WordPress install it should work perfectly, however other themes and plugins can do whatever they want do and register files in their own way, not always going through the API. I ran it on a few big websites and it performed very well. Make a backup (database + uploads directory) then run it. Again, I insist: BACKUP, BACKUP, BACKUP! Don't come here to complain that it deleted your files, because, yes, it deletes files. The plugin tries its best to help you and it is the only plugin that does it well.

= How to clean WordPress =
Manu shared with me what he wrote to his development team in order to clean WordPress. Here it is:

How to restore the WordPress installation to full health:
1 - Do a manual full backup with the plugin BackupBuddy.
2 - Use the plugin WP Maintenance Mode to enable the maintenance mode. This will serve a static page to everyone, except administrators.
3 - Run the plugin WP Clean Up and delete all the drafts - Check if there is any draft that is not a RSS imported post (categorized as ‘imported-photo’).
4 - DELETE orphan attachments with the following query:

DELETE FROM [YOU_DATABASE_NAME].wp_posts
WHERE post_type = 'attachment'
AND post_parent NOT IN (
SELECT ID FROM (
SELECT ID FROM [YOU_DATABASE_NAME].wp_posts WHERE post_type <> 'attachment'
) as sub_query
);

5 - Use the plugin WP Clean Up to dispose the ‘Orphan Postmeta’.
5.1 - If the plugin times out, run the following query to delete the orphan postmeta.

DELETE FROM [YOU_DATABASE_NAME].wp_postmeta
WHERE post_id NOT IN (
SELECT ID FROM [YOU_DATABASE_NAME].wp_posts
);

6 - Run the plugin Media Cleaner to locate and erase the orphan files in the upload folder
7 - Disable the maintenance mode.
8 - Test everything in incognito mode or in a new browser (so nothing is cached).
9 - Double test everything with another computer.
10 - Do another manual full backup with BackupBuddy.

= What is 'Reset' doing exactly? =
It re-creates the Media Cleaner table in the database. You will need to re-run the scan after this.

= I donated, can I get rid of the donation button? =
Of course. I don't like to see too many of those buttons neither ;) You can disable the donation buttons from all my plugins by adding this to your wp-config.php: `define('WP_HIDE_DONATION_BUTTONS', true);`

== Screenshots ==

1. Media -> Media Cleaner

== Changelog ==

= 3.2.9 =
* Update: Tiny changes.
* Info: A big update will come to this plugin. In preparation for this, I would like to know what you love about this plugin and what you dislike about it here: https://wordpress.org/support/topic/what-do-you-like-and-dislike-about-the-media-cleaner/. Nice reviews are also very, very appreciated :) Thank you all.

= 3.2.8 =
* Add: New option to remove ads, flatter and message about Pro version.
* Update: Show a better edit media screen.
* Info: Please review Media Cleaner if you like it. The plugin needs reviews to live :) Here: https://wordpress.org/support/view/plugin-reviews/media-file-cleaner. And also let me know if you need any additional features. Thank you :)

= 3.2.4 =
* Update: Will show the same number of items as in the Media Library (before it was fixed to 15 items per page).
* Fix: Was displaying warning if the number of items per page in the Media page is not set.

= 3.2.0 =
* Fix: HTML adapted to WP 4.5.1.
* Fix: Doesn't break if there is an error on the server-side. Display an alert and continue.
* Update: Can select more than one file for non-Pro.
* Fix: Issue with PHP 7.

= 3.0.0 =
* Add: Option for resolving shortcode during analysis.
* Update: French translation. Big thanks to Guillaume (and also for all his testing!).
* Info: New name, fresh start. This plugin changed completely since it very first release :)

= 2.5.0 =
* Add: Delete the unused directories.
* Add: Doesn't break when there are too many files in the system.
* Add: Pro version with better support.
* Update: Improved detection of unused files.
* Fix: UTF8 filenames skipped by default but can be scanned through an option.
* Fix: Really many fixes :)
* Info: Contact me if you have been using the plugin for a long time and love it.

= 2.4.2 =
* Add: Inclusion of gallery post format images.
* Fix: Better gallery URL matching.
* Info: Thanks to syntax53 for those improvements via GitHub (https://github.com/tigroumeow/media-file-cleaner/pull/3). Please review Media Cleaner if you like it. The plugin needs reviews to live. Thank you :) (https://wordpress.org/support/view/plugin-reviews/media-file-cleaner)

= 2.4.0 =
* Fix: Cross site scripting vulnerability fixes.
* Change: Many enhancements and fixes made by Matt (http://www.twistedtek.net/). Please thanks him :)
* Info: Please perform a "Reset" in the plugin dashboard after installing this new version.

= 2.2.6 =
* Fix: Scan for multisite.
* Change: options are now all enabled by default.
* Fix: DB issue avoided trashed files from being deleted permanently.

= 2.0.2 =
* Works with WP 4.
* Gallery support.
* Fix: IGNORE function was... ignored by the scanning process.

= 1.9.0 =
* Add: thumbnails.
* Add: IGNORE function.
* Change: cosmetic changes.

= 1.8.0 =
* Add: now detects the custom header and custom background.
* Change: the CSS was updated to fit the new Admin theme.

= 1.7.0 =
* Change: the MEDIA files are now going to the trash but the MEDIA reference in the DB is still removed permanently.

= 1.6.0 =
* Stable release.
* Change: Readme.txt.

= 1.4.0 =
* Add: check the meta properties.
* Add: check the 'featured image' properties.
* Fix: keep the trash information when a new scan is started.
* Fix: remove the DB on uninstall, not on desactivate.

= 1.2.2 =
* Add: progress %.
* Fix: issues with apostrophes in filenames.
* Change: UI cleaning.

= 1.2.0 =
* Add: options (scan files / scan media).
* Fix: mkdir issues.
* Change: operations are buffered by 5 (faster).

= 0.1.0 =
* First release.
