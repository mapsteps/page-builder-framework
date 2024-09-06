<?php
/**
 * Color field's default settings.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Color;

/**
 * Default settings for the color field.
 */
class MulticolorField extends ColorField {

	/**
	 * Setting's sanitize callback.
	 *
	 * @param array $values The multicolor values.
	 *
	 * @return array
	 */
	public function sanitizeCallback( $values ) {

		if ( empty( $values ) || ! is_array( $values ) ) {
			return [];
		}

		$sanitized_values = [];

		foreach ( $values as $key => $value ) {
			$sanitized_values[ $key ] = ( new ColorSanitizer() )->sanitize( $value );
		}

		return ( new ColorSanitizer() )->sanitize( $sanitized_values );

	}

}
