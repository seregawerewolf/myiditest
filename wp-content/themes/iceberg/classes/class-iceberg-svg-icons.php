<?php
/**
 * Custom icons for this theme.
 * Based on a solution in Twenty Twenty. Removed Social Icons.
 *
 * @package WordPress
 * @subpackage Iceberg
 * @since 2.0
 */

if ( ! class_exists( 'Iceberg_SVG_Icons' ) ) {
	/**
	 * SVG ICONS CLASS
	 * Retrieve the SVG code for the specified icon. Based on a solution in Twenty Nineteen.
	 */
	class Iceberg_SVG_Icons {
		/**
		 * GET SVG CODE
		 * Get the SVG code for the specified icon
		 *
		 * @param string $icon Icon name.
		 * @param string $group Icon group.
		 * @param string $color Color.
		 */
		public static function get_svg( $icon, $color = '#1A1A1B' ) {
			$arr = self::$ui_icons;

			if ( array_key_exists( $icon, $arr ) ) {
				$repl = '<svg class="svg-icon" aria-hidden="true" role="img" focusable="false" ';
				$svg  = preg_replace( '/^<svg /', $repl, trim( $arr[ $icon ] ) ); // Add extra attributes to SVG code.
				$svg  = str_replace( '#1A1A1B', $color, $svg ); // Replace the color.
				$svg  = str_replace( '#', '%23', $svg ); // Urlencode hashes.
				$svg  = preg_replace( "/([\n\t]+)/", ' ', $svg ); // Remove newlines & tabs.
				$svg  = preg_replace( '/>\s*</', '><', $svg ); // Remove white space between SVG tags.
				return $svg;
			}
			return null;
		}

		/**
		 * ICON STORAGE
		 * Store the code for all SVGs in an array.
		 *
		 * @var array
		 */
		public static $ui_icons = array(
			'search' => '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 768 768"><path d="M513.312 507.392c-1.088 0.832-2.144 1.76-3.168 2.784s-1.92 2.048-2.784 3.168c-40.256 38.816-95.008 62.656-155.36 62.656-61.856 0-117.824-25.024-158.4-65.6s-65.6-96.544-65.6-158.4 25.024-117.824 65.6-158.4 96.544-65.6 158.4-65.6 117.824 25.024 158.4 65.6 65.6 96.544 65.6 158.4c0 60.352-23.84 115.104-62.688 155.392zM694.624 649.376l-117.6-117.6c39.392-49.28 62.976-111.776 62.976-179.776 0-79.52-32.256-151.552-84.352-203.648s-124.128-84.352-203.648-84.352-151.552 32.256-203.648 84.352-84.352 124.128-84.352 203.648 32.256 151.552 84.352 203.648 124.128 84.352 203.648 84.352c68 0 130.496-23.584 179.776-62.976l117.6 117.6c12.512 12.512 32.768 12.512 45.248 0s12.512-32.768 0-45.248z"></path></svg>',
			'menu' => '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 768 768"><path d="M96 416h576c17.664 0 32-14.336 32-32s-14.336-32-32-32h-576c-17.664 0-32 14.336-32 32s14.336 32 32 32zM96 224h576c17.664 0 32-14.336 32-32s-14.336-32-32-32h-576c-17.664 0-32 14.336-32 32s14.336 32 32 32zM96 608h576c17.664 0 32-14.336 32-32s-14.336-32-32-32h-576c-17.664 0-32 14.336-32 32s14.336 32 32 32z"></path></svg>',
			'cross' => '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 768 768"><path d="M169.376 214.624l169.376 169.376-169.376 169.376c-12.512 12.512-12.512 32.768 0 45.248s32.768 12.512 45.248 0l169.376-169.376 169.376 169.376c12.512 12.512 32.768 12.512 45.248 0s12.512-32.768 0-45.248l-169.376-169.376 169.376-169.376c12.512-12.512 12.512-32.768 0-45.248s-32.768-12.512-45.248 0l-169.376 169.376-169.376-169.376c-12.512-12.512-32.768-12.512-45.248 0s-12.512 32.768 0 45.248z"></path></svg>',
			'chevron-down' => '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 768 768"><path d="M169.376 310.624l192 192c12.512 12.512 32.768 12.512 45.248 0l192-192c12.512-12.512 12.512-32.768 0-45.248s-32.768-12.512-45.248 0l-169.376 169.376-169.376-169.376c-12.512-12.512-32.768-12.512-45.248 0s-12.512 32.768 0 45.248z"></path></svg>',
			'chevron-right' => '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 768 768"><path d="M310.624 598.624l192-192c12.512-12.512 12.512-32.768 0-45.248l-192-192c-12.512-12.512-32.768-12.512-45.248 0s-12.512 32.768 0 45.248l169.376 169.376-169.376 169.376c-12.512 12.512-12.512 32.768 0 45.248s32.768 12.512 45.248 0z"></path></svg>',
			'chevron-left' => '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 768 768"><path d="M502.624 553.376l-169.376-169.376 169.376-169.376c12.512-12.512 12.512-32.768 0-45.248s-32.768-12.512-45.248 0l-192 192c-12.512 12.512-12.512 32.768 0 45.248l192 192c12.512 12.512 32.768 12.512 45.248 0s12.512-32.768 0-45.248z"></path></svg>',
			'star' => '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 768 768"><path d="M412.704 49.824c-2.944-6.048-7.936-11.264-14.528-14.528-15.84-7.808-35.040-1.312-42.848 14.528l-91.456 185.248-204.512 29.92c-6.656 0.928-13.152 4.064-18.272 9.312-12.352 12.672-12.064 32.928 0.576 45.248l147.936 144.096-34.912 203.584c-1.152 6.624-0.192 13.792 3.232 20.288 8.224 15.648 27.584 21.664 43.232 13.44l182.848-96.16 182.88 96.16c5.952 3.168 13.056 4.448 20.288 3.232 17.408-2.976 29.12-19.52 26.144-36.96l-34.912-203.584 147.936-144.096c4.832-4.672 8.288-11.008 9.344-18.304 2.56-17.472-9.536-33.728-27.040-36.288l-204.48-29.888zM384 136.288l70.176 142.208c4.832 9.76 13.952 15.968 24.064 17.504l156.992 22.944-113.568 110.624c-7.808 7.616-10.912 18.208-9.216 28.32l26.784 156.256-140.352-73.824c-9.632-5.056-20.704-4.736-29.792 0l-140.352 73.824 26.784-156.256c1.856-10.752-1.888-21.152-9.216-28.32l-113.568-110.624 157.024-22.976c10.752-1.568 19.488-8.32 24.064-17.472z"></path></svg>'
		);
	}
}