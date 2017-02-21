<?php
/*
 * Plugin Name: Scalable Vector Graphics (SVG)
 * Plugin URI: http://www.sterlinghamilton.com/projects/scalable-vector-graphics/
 * Description: Scalable Vector Graphics are two-dimensional vector graphics, that can be both static and dynamic. This plugin allows your to easily use them on your site.
 * Version: 3.3
 * Author: Sterling Hamilton
 * Author URI: http://www.sterlinghamilton.com/
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

require_once __DIR__ . '/vendor/autoload.php';

\PressBits\MediaLibrary\ScalableVectorGraphicsDisplay::enable();

$wordpress_version = get_bloginfo('version');

// Return the accepted value for SVG mime-types in compliance with the RFC 3023.
// RFC 3023: https://www.ietf.org/rfc/rfc3023.txt 8.19, A.1, A.2, A.3, A.5, and A.7
// Expects to interface with https://codex.wordpress.org/Plugin_API/Filter_Reference/upload_mimes
function allow_svg_uploads( $existing_mime_types = array() ) {
	return $existing_mime_types + array( 'svg' => 'image/svg+xml' );
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
