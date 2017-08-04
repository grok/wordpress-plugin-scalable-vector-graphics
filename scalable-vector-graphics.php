<?php
/*
 * Plugin Name: Scalable Vector Graphics (SVG)
 * Plugin URI: https://sterlinghamilton.com/projects/scalable-vector-graphics/
 * Description: Scalable Vector Graphics are two-dimensional vector graphics, that can be both static and dynamic. This plugin allows your to easily use them on your site.
 * Version: 3.4
 * Author: Sterling Hamilton
 * Author URI: https://sterlinghamilton.com/
 * License: GPLv2 or later

 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.	See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA	02110-1301, USA.
*/

namespace SterlingHamilton\Plugins\ScalableVectorGraphics;

$wordpress_version = get_bloginfo('version');

// Return the accepted value for SVG mime-types in compliance with the RFC 3023.
// RFC 3023: https://www.ietf.org/rfc/rfc3023.txt 8.19, A.1, A.2, A.3, A.5, and A.7
// Expects to interface with https://codex.wordpress.org/Plugin_API/Filter_Reference/upload_mimes
function allow_svg_uploads( $existing_mime_types = array() ) {
	return $existing_mime_types + array( 'svg' => 'image/svg+xml' );
}

// This is a decent way of grabbing the dimensions of SVG files.
// Depends on http://php.net/manual/en/function.simplexml-load-file.php
// I believe this to be a reasonable dependency and should be common enough to
// not cause problems.
function get_dimensions( $svg ) {
	// Sometimes, for whatever reason, we still cannot get the attributes.
	// If that happens, we will just go back to not knowing the dimensions,
	// rather than breaking the site.
	$fail = (object) array( 'width' => 0, 'height' => 0 );

	// Welp, nothing we can do here...
	if ( ! function_exists( 'simplexml_load_file' ) ) {
		return $fail;
	}

	$svg = simplexml_load_file( $svg );
	$attributes = $svg ? $svg->attributes() : false;

	// Probably an invalid XML file?
	if( ! $attributes ) {
		return $fail;
	}

	$width = (string) $attributes->width;
	$height = (string) $attributes->height;

	return (object) array( 'width' => $width, 'height' => $height );
}

// Browsers may or may not show SVG files properly without a height/width.
// WordPress specifically defines width/height as "0" if it cannot figure it out.
// Thus the below is needed.
//
// Consider this the "server side" fix for dimensions.
// Which is needed for the Media Grid within the Administration area.
function set_dimensions( $response, $attachment, $meta ) {
	if( $response['mime'] == 'image/svg+xml' && empty( $response['sizes'] ) ) {
		$svg_file_path = get_attached_file( $attachment->ID );
		$dimensions = get_dimensions( $svg_file_path );

		$response[ 'sizes' ] = array(
				'full' => array(
					'url' => $response[ 'url' ],
					'width' => $dimensions->width,
					'height' => $dimensions->height,
					'orientation' => $dimensions->width > $dimensions->height ? 'landscape' : 'portrait'
			)
		);
	}

	return $response;
}

// Browsers may or may not show SVG files properly without a height/width.
// WordPress specifically defines width/height as "0" if it cannot figure it out.
// Thus the below is needed.
//
// Consider this the "client side" fix for dimensions. But only for the Administration.
//
// WordPress requires inline administration styles to be wrapped in an actionable function.
// These styles specifically address the Media Listing styling and Featured Image
// styling so that the images show up in the Administration area.
function administration_styles() {
	// Media Listing Fix
	wp_add_inline_style( 'wp-admin', ".media .media-icon img[src$='.svg'] { width: auto; height: auto; }" );
	// Featured Image Fix
	wp_add_inline_style( 'wp-admin', "#postimagediv .inside img[src$='.svg'] { width: 100%; height: auto; }" );
}

// Browsers may or may not show SVG files properly without a height/width.
// WordPress specifically defines width/height as "0" if it cannot figure it out.
// Thus the below is needed.
//
// Consider this the "client side" fix for dimensions. But only for the End User.
function public_styles() {
	// Featured Image Fix
	echo "<style>.post-thumbnail img[src$='.svg'] { width: 100%; height: auto; }</style>";
}

// Restores the ability to upload non-image files in WordPress 4.7.1 and 4.7.2.
// Related Trac Ticket: https://core.trac.wordpress.org/ticket/39550
// Credit: @sergeybiryukov
// @TODO: Remove the plugin once WordPress 4.7.3 is available!
function disable_real_mime_check( $data, $file, $filename, $mimes ) {
	$wp_filetype = wp_check_filetype( $filename, $mimes );

	$ext = $wp_filetype['ext'];
	$type = $wp_filetype['type'];
	$proper_filename = $data['proper_filename'];

	return compact( 'ext', 'type', 'proper_filename' );
}

if($wordpress_version < "4.7.3") {
	add_filter( 'wp_check_filetype_and_ext', __NAMESPACE__ . '\\disable_real_mime_check', 10, 4 );
}
add_filter( 'upload_mimes', __NAMESPACE__ . '\\allow_svg_uploads' );
add_filter( 'wp_prepare_attachment_for_js', __NAMESPACE__ . '\\set_dimensions', 10, 3 );
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\administration_styles' );
add_action( 'wp_head', __NAMESPACE__ . '\\public_styles' );

?>
