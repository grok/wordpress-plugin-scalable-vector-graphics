<?php
/*
 * Plugin Name: Scalable Vector Graphics (SVG)
 * Plugin URI: http://sterlinghamilton.com/scalable-vector-graphics-plugin
 * Description: Scalable Vector Graphics are two-dimensional vector graphics, that can be both static and dynamic. This plugin allows your to easily use them on your site.
 * Version: 2.0.1
 * Author: Sterling Hamilton
 * Author URI: http://sterlinghamilton.com
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

	public function execute() {
		$this->_enable_svg_mime_type();
	}

	private function _enable_svg_mime_type() {
		add_filter( 'upload_mimes', array( &$this, 'allow_svg_uploads' ) );
	}

	private function _sanitize_input( $input ) {
		if( is_scalar( $input ) ) {
			return wp_kses( $input );
		} else {
			$this->_error( 'Unable to sanitize given input: Not scalar: integer, float, string or boolean.' );
		}

		return false;
	}

	private function _error( $message ) {
		return new WP_Error( __CLASS__, __METHOD__ . __( $message ) );
	}

	public function allow_svg_uploads( $existing_mime_types = array() ) {
		return $this->_add_mime_type( $existing_mime_types );
	}

	private function _add_mime_type( $mime_types ) {
		$mime_types[ 'svg' ] = 'image/svg+xml';

		return $mime_types;
	}

}

if ( class_exists( 'scalable_vector_graphics' ) and ! isset( $scalable_vector_graphics ) ) {
	$scalable_vector_graphics = new scalable_vector_graphics();
	$scalable_vector_graphics->execute();
}

?>
