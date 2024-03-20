<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Responsive;

use Mapsteps\Wpbf\Customizer\Controls\Generic\NumberUtil;

class ResponsiveUtil {

	/**
	 * Make empty value based on devices.
	 *
	 * @param string[] $devices The allowed devices.
	 */
	public function makeEmptyValue( $devices ) {

		$values = [];

		foreach ( $devices as $device ) {
			$values[ $device ] = '';
		}

		return $values;

	}

	/**
	 * Make value based on devices.
	 *
	 * @param string[]       $devices The allowed devices.
	 * @param string         $type The data type. Accepts one of this values:
	 *                             "number", "number-unit", "text", "textarea", "email", "url", and "content".
	 * @param array          $value The value to parse.
	 * @param int|float|null $min The minimum value.
	 * @param int|float|null $max The maximum value.
	 *
	 * @return array The value based on devices and limited by min and max.
	 */
	public function makeDevicesValue( $devices, $type, $value, $min = null, $max = null ) {

		$values = [];

		$number_util = new NumberUtil();

		foreach ( $devices as $device ) {
			if ( ! isset( $value[ $device ] ) ) {
				// We allow empty string.
				$values[ $device ] = '';
			} else {
				$values[ $device ] = $value[ $device ];
			}

			$values[ $device ] = $this->sanitizeSingleValue( $type, $values[ $device ], $min, $max );
		}

		return $values;

	}

	/**
	 * Sanitize a single value based on the 'type' parameter.
	 *
	 * @param string         $type The data type. Accepts one of this values:
	 *                             "number", "number-unit", "text", "textarea", "email", "url", and "content".
	 * @param mixed          $value The value to sanitize.
	 * @param int|float|null $min The minimum value. Used by "number" and "number-unit" data type.
	 * @param int|float|null $max The maximum value. Used by "number" and "number-unit" data type.
	 *
	 * @return string|int|float
	 */
	public function sanitizeSingleValue( $type, $value, $min, $max ) {

		if ( 'text' === $type ) {
			return sanitize_text_field( $value );
		} elseif ( 'textarea' === $type ) {
			return sanitize_textarea_field( $value );
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
		}

		return wp_kses_post( $value );

	}

	/**
	 * Convert the value to an array value.
	 *
	 * @param string[]       $devices The allowed devices.
	 * @param string         $type The data type. Accepts one of this values:
	 *                             "number", "number-unit", "text", "textarea", "email", "url", and "content".
	 * @param mixed          $raw_value The raw value.
	 * @param int|float|null $min The minimum value.
	 * @param int|float|null $max The maximum value.
	 *
	 * @return array The array value.
	 */
	public function toArrayValue( $devices, $type, $raw_value, $min, $max ) {

		$first_device = ! empty( $devices ) ? $devices[0] : null;
		$array_value  = [];

		// Assuming $raw_value is not an array, not a JSON encoded string.
		if ( ! is_array( $raw_value ) && ! is_string( $raw_value ) ) {
			$array_value = $this->makeEmptyValue( $devices );

			if ( ! empty( $first_device ) && is_numeric( $raw_value ) ) {
				$array_value[ $first_device ] = (float) $raw_value;
			}
		} else {
			$array_value = $raw_value;

			// Assuming $raw_value is a JSON encoded string.
			if ( is_string( $raw_value ) ) {
				$array_value = json_decode( $raw_value, true );

				// If can't be decoded, then the result is not an array.
				if ( is_null( $array_value ) || ! is_array( $array_value ) ) {
					$array_value = $this->makeEmptyValue( $devices );

					if ( ! empty( $first_device ) && is_numeric( $raw_value ) ) {
						$array_value[ $first_device ] = (float) $raw_value;
					}
				}
			}
		}

		return $this->makeDevicesValue( $devices, $type, $array_value, $min, $max );

	}

}
