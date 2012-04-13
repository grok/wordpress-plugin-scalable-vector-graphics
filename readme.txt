=== Scalable Vector Graphics (SVG) ===
Contributors: sterlo
Donate link: http://sterlinghamilton.com/
Tags: svg, scalable vector graphics, shortcode
Requires at least: 2.5
Tested up to: 3.2
Stable tag: trunk

SVG files are two-dimensional vector graphics, that can be both static and dynamic. This plugin allows your to easily use them on your site.

== Installation ==

1. Upload `scalable-vector-graphics.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `[svg]` in your content.

The short code takes the following attributes:

* src: The location of your SVG file.
* style: Any CSS you wish to use.
* type: Valid values are iframe or embed.
* width: The width of the SVG.
* height: The height of the SVG.

An example of using all attributes:
`[svg src="/wp-content/uploads/1900/1/example.svg" width="300" height="300" style="display:block; margin:auto;" type="embed"]`

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
