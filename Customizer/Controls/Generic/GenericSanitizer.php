<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Generic;

class GenericSanitizer {

	/**
	 * Sanitize a single value based on the 'type' parameter.
	 *
	 * @param string         $type The data type. Accepts one of this values:
	 *                             "text", "hidden", "number", "number-unit", "textarea", "email", "url", and "content".
	 * @param mixed          $value The value to sanitize.
	 * @param int|float|null $min The minimum value. Used by "number" and "number-unit" data type.
	 * @param int|float|null $max The maximum value. Used by "number" and "number-unit" data type.
	 *
	 * @return string|int|float
	 */
	public function sanitize( $type, $value, $min = null, $max = null ) {

		if ( 'textarea' === $type ) {
			return wp_kses_post( $value );
		} elseif ( 'url' === $type ) {
			return esc_url_raw( $value );
		} elseif ( 'number' === $type || 'number-unit' === $type ) {
			$number_util = new NumberUtil();

			$max = $number_util->normalizeMaxValue( $min, $max );

			if ( 'number' === $type ) {
				return $number_util->limitNumber( $value, $min, $max );
			}

			return $number_util->limitNumberWithUnit( $value, $min, $max );
		} elseif ( 'email' === $type ) {
			return sanitize_email( $value );
		} elseif ( 'content' === $type ) {
			return wp_kses_post( $value );
		}

		return sanitize_text_field( $value );

	}

}
