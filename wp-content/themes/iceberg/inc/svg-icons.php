<?php
/**
 * Iceberg SVG Icon helper functions
 * Based on a solution in Twenty Twenty theme.
 *
 * @package WordPress
 * @subpackage Iceberg
 * @since 2.0
 */

if ( ! function_exists( 'iceberg_the_theme_svg' ) ) {
	/**
	 * Output and Get Theme SVG.
	 * Output and get the SVG markup for an icon in the Iceberg_SVG_Icons class.
	 *
	 * @param string $svg_name The name of the icon.
	 * @param string $group The group the icon belongs to.
	 * @param string $color Color code.
	 */
	function iceberg_the_theme_svg( $svg_name, $color = '' ) {
		echo iceberg_get_theme_svg( $svg_name, $color ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in iceberg_get_theme_svg();.
	}
}

if ( ! function_exists( 'iceberg_get_theme_svg' ) ) {

	/**
	 * Get information about the SVG icon.
	 *
	 * @param string $svg_name The name of the icon.
	 * @param string $group The group the icon belongs to.
	 * @param string $color Color code.
	 */
	function iceberg_get_theme_svg( $svg_name, $color = '' ) {

		// Make sure that only our allowed tags and attributes are included.
		$svg = wp_kses(
			Iceberg_SVG_Icons::get_svg( $svg_name, $color ),
			array(
				'svg'     => array(
					'class'       => true,
					'xmlns'       => true,
					'width'       => true,
					'height'      => true,
					'viewbox'     => true,
					'aria-hidden' => true,
					'role'        => true,
					'focusable'   => true
				),
				'path'    => array(
					'fill'      => true,
					'fill-rule' => true,
					'd'         => true,
					'transform' => true
				)
			)
		);

		if ( ! $svg ) {
			return false;
		}
		return $svg;
	}
}
