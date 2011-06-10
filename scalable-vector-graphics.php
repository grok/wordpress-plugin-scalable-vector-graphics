<?php
/*
 * Plugin Name: Scalable Vector Graphics (SVG)
 * Plugin URI: http://sterlinghamilton.com/scalable-vector-graphics-plugin
 * Description: Scalable Vector Graphics are two-dimensional vector graphics, that can be both static and dynamic. This plugin allows your to easily use them on your site.
 * Version: 1.0
 * Author: Sterling Hamilton
 * Author URI: http://www.sterlinghamilton.com
 * License: GPLv2 or later

 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

class scalable_vector_graphics {

	function __construct() {
		add_filter( 'upload_mimes' , array( &$this , 'allow_svg_uploads' ) );
		add_shortcode( 'svg' , array( &$this , 'process_shortcode' ) );
	}

	function allow_svg_uploads( $existing_mime_types = array() ) {
		$new_mime_types = $existing_mime_typess;
		$new_mime_types[ 'svg' ] = 'mime/type';

		return $new_mime_types;
	}

	function process_shortcode( $atts ) {
		$valid_attributes = array( 'src' , 'style' , 'type' , 'width' , 'height' );

		$content = NULL;

		foreach( $atts as $attribute => $value ) {
			if( ! in_array( $attribute , $valid_attributes ) ) {
				$content .= "\n" . '<!-- Invalid attribute ignored: ' . $attribute . ' -->' . "\n";
			}
		}

		switch( $atts[ 'type' ] ) {
			case 'iframe':
				$content .= '<iframe src="' . $atts[ 'src' ] . '" width="' . $atts[ 'width' ] . '" height="' . $atts[ 'height' ] . '" style="' . $atts[ 'style' ] . '">';
				$content .= '</iframe>';
			break;
			case 'embed':
				$content .= '<embed src="' . $atts[ 'src' ] . '" width="' . $atts[ 'width' ] . '" height="' . $atts[ 'height' ] . '" ';
				$content .= 'type="image/svg+xml" pluginspage="http://www.adobe.com/svg/viewer/install/" style="' . $atts[ 'style' ] . '" /> ';
			break;
			default:
				$content .= "\n" . '<!-- Invalid value ignored: ' . $atts[ 'type' ] . ' -->' . "\n";
			break;
		}

		return $content;
	}

}

if ( class_exists( 'scalable_vector_graphics' ) and !isset( $scalable_vector_graphics ) ) {
	$scalable_vector_graphics = new scalable_vector_graphics();
}

?>
