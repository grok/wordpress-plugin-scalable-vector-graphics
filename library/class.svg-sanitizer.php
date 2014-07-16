<?php
/**
 *  SVGSantiizer
 *
 *  Whitelist-based PHP SVG sanitizer.
 *
 *  @link https://github.com/alister-/SVG-Sanitizer}
 *  @author Alister Norris
 *  @copyright Copyright (c) 2013 Alister Norris
 *  @license http://opensource.org/licenses/mit-license.php The MIT License
 *  @package svgsanitizer
 */

class SvgSanitizer {

	private $document;
	private static $whitelist = array();

	function __construct() {
		global $whitelist;
		$this->document = new DOMDocument();
		$this->document->preserveWhiteSpace = FALSE;

		// Load in the external whitelist data.
		require_once 'data.svg-whitelist.php';
		self::$whitelist = $whitelist;
	}

	function load($file) {
		$this->document->load($file);
	}

	function sanitize() {
		$elements = $this->document->getElementsByTagName("*");

		for($i = 0; $i < $elements->length; $i++) {
			$currentNode = $elements->item($i);

			$whitelist_node_attributes = self::$whitelist[$currentNode->tagName];

			// Is this element within the whitelist?
			if(isset($whitelist_node_attributes)) {
				for($x = 0; $x < $currentNode->attributes->length; $x++) {
					$attribute_name = $currentNode->attributes->item($x)->name;
					// Is this attribute within the whitelist?
					if(!in_array($attribute_name, $whitelist_node_attributes)) {
						// If not within the whitelist, remove the attribute.
						$currentNode->removeAttribute($attribute_name);
					}
				}
			} else {
				// If not within the whitelist, remove the element.
				$currentNode->parentNode->removeChild($currentNode);
			}
		}
	}

	function saveSVG() {
		$this->document->formatOutput = TRUE;

		return $this->document->saveXML();
	}
}

?>
