<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Generic;

class NumberUtil {

	/**
	 * Sanitize number.
	 *
	 * @param string|int|float $value The value to sanitize.
	 * @param null|int|float   $min   The minimum value. Null if not set.
	 * @param null|int|float   $max   The maximum value. Null if not set.
	 *
	 * @return int|float
	 */
	public function sanitize_number( $value, $min, $max ) {
		// We allow empty string.
		if ( '' === $value ) {
			return '';
		}

		if ( ! is_numeric( $value ) ) {
			return '';
		}

		$value = (float) $value;

		if ( ! is_null( $min ) && ! is_null( $max ) ) {
			if ( $value < $min ) {
				$value = $min;
			}

			if ( $value > $max ) {
				$value = $max;
			}
		} else {
			if ( ! is_null( $min ) ) {
				if ( $value < $min ) {
					$value = $min;
				}
			} elseif ( ! is_null( $max ) ) {
				if ( $value > $max ) {
					$value = $max;
				}
			}
		}

		return $value;
	}

}