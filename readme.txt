=== Scalable Vector Graphics (SVG) ===
Contributors: sterlo
Donate link: http://sterlinghamilton.com/
Tags: svg, scalable, vector, graphics, mime, type, images, uploads
Requires at least: 3.0
Tested up to: 4.0-beta1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

SVG files are two-dimensional vector graphics, that can be both static and dynamic. This plugin allows your to easily use them on your site.

== Description ==

SVG files are two-dimensional vector graphics, that can be both static and dynamic. This plugin allows you to easily use them on your site.

The main project page is located here: [http://sterlinghamilton.com/projects/scalable-vector-graphics-svg/](http://sterlinghamilton.com/projects/scalable-vector-graphics-svg/ "Scalable Vector Graphics (SVG) | Sterling Hamilton")

Warning: Understanding that uploading any file to the system is a potential security risk, it is strongly recommended to only let trusted users to have upload privileges.

Resources for understanding security risks:

* http://security.stackexchange.com/questions/11384/exploits-or-other-security-risks-with-svg-upload
* https://www.youtube.com/watch?v=v-a77QdoK2I

== Installation ==

1. Upload `scalable-vector-graphics.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Use SVG files just like you would use a normal image file.

== Changelog ==

= 1.0 =
* I N C E P T I O N
= 1.1 =
* Fixing a typo. This typo caused ONLY SVG files to be allowed to upload via the media uploader.
= 1.2 =
* One less required parameter and a graceful fail over to a valid implementation type. Props @Phil
= 2.0 =
* I broke everything. I'm sorry, but it had to be done.
* Basically how I had approached the problem before was wrong. It is now being done properly using the correct mime/type.
* Shortcodes are no longer needed, you can now use SVG files as you would any other image.
* Previews now show up in the media area for SVG files.
* IMPORTANT: Anyone using the version prior to 2.0 were using shortcodes to display SVG files. You will have to go back and replace those shortcodes with actual image tags. If you're not familiar with HTML, you can just delete the shortcode out of the page/post and then insert the SVG file as you would any other image.
* Thanks to the guys over at mozilla.org for kicking me in the butt to actually fix this thing: https://bugzilla.mozilla.org/show_bug.cgi?id=721830
= 2.2.1 =
* Added a security library to scan all uploaded SVG files. It has a list of "expected" elements and attributes, if the file contains thing it does not expect, it removes them. This will include things like Javascript.
* The security cannot be perfect and it is recommended to only provide upload privileges to trusted users.
* Props to thedwards for bringing this to my attention.
= 2.3.1 =
* Added inline styling to tha administration area so SVG attachments will show up in list/grid views.
* Props to shield-9 (Daisuke Takahashi) for the code.
