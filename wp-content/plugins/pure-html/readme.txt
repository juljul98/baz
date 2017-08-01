=== PureHTML ===
Contributors: Hit Reach, JamieFraser
Donate link: 
Tags: html, iframe, embed, form action, code, markup, mark-up, pure html, javascript
Requires at least: 2.5
Tested up to: 3.5
Stable tag: 2.0.1
License: GPLv2

Pure HTML allows you to add standard HTML markup that is normally removed by the visual editor using a bbcode format or code snippets

== Description ==

Pure HTML is a plugin for WordPress which allows you to easily insert HTML markup which is normally removed by the TinyMCE visual editor.

The plugin allows for your markup to be saved as code snippets, which can be re-used on multiple pages and updated in one place.

Your markup can be inserted in 2 ways;

1. As a code snippet which can be reused on multiple pages and updated in one place
1. As inline BBCode which is then converted on page load to standard HTML

The end result is an easy solution to insert Google Maps, Youtube Videos and other rich content which may normally be removed by the TinyMCE editor when switching between WYSIWYG and Text modes.

Your markup is added via a shortcode `[purehtml][/purehtml]` which supports 2 attributes

* debug=[0/1] - When set to 1, the content is appended with a pre tag showing exactly what is being outputted, to allow you to pin point the cause of an error
* id=[int] - When set, it will use the corresponding snippet id from the database, if the snippet is not found in the database then a default fallback snippet is shown.

You can customize the Snippet Not Found message in the plugins options page.

== Installation ==

* Download the plugin
* Create a "pure-html" folder within your WordPress install's plugin directory (usually wp-content/plugins)
* Add the plugin files to the folder
* Activate the plugin from the plugins page inside the admin dashboard. 

== Frequently Asked Questions ==

= Q. What Tags Are Automatically Removed? =
Currently all &lt;br /&gt; and &lt;p&gt; (and its closing counterpart) tags are removed from the input code because these are the tags that Wordpress automatically add.

= Q. How Do I Add Tags Without Them Being Stripped? =
If you want to echo a paragraph tag or a line break, or any other tag (strong, em etc) instead of enclosing them in &lt; and &gt; tags, enclose them in [ ] brackets for example [p] instead of &lt;p&gt; The square brackets are converted after the inital tags are stripped and function as normal tags.

= Q. How Do I Include a [ or ] In My Output Without It Being Removed =
To prevent [ or ] being changed to the &lt; or &gt; (respectively) you will need to `escape` it using a \, so ] will become \] and [ will become \[.

= Q. What Happens To The Output If I Delete The Snippet It Uses? =
If you delete a snippet that is being used in a page then the output generates a 404 error that displays in its place.

= My Question Is Not Answered Here! =
If your question is not listed here please look on: [http://www.hitreach.co.uk/wordpress-plugins/pure-html/](http://www.hitreach.co.uk/wordpress-plugins/pure-html/ "Web Design Arbroath") and if the answer is not listed there, just leave a comment!


== Change Log ==
= 0.0.1 =

* Initial Release

= 1.0.0 =

* Addition of custom 404 message
* Ability to hide 404 message completely
* Beta release of the Allow PHP and Allow JS integration

= 1.1.0 =

* Security Updates

= 1.2.0 =

* bug fix

= 1.2.1 =

* Fixed issue with adding long snippets

= 2.0.0 =

* Major issues addressed in adding and using code snippets
* Function for saving options rebuilt
* Code moved to a single class to prevent function conflicts
* Plugin interface updated to be simplier
* Compatibility with WP 3.5 Provided
* Slight Performance Increase
* Complete uninstall option added
* Security improvements
* Improved Debug

= 2.0.1 =
* Fixed issue with table generation on new installs

== Screenshots ==

1. The new user interface

2. The new debug changes

== Upgrade Notice ==

= 2.0.0 =

The plugin has been completely rebuilt to be more secure, easier to use and nicer to use.  The update addresses serious issues with adding and updating code snippets.
