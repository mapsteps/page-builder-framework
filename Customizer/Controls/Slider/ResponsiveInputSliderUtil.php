<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Slider;

use Mapsteps\Wpbf\Customizer\Controls\Generic\NumberUtil;

class ResponsiveInputSliderUtil {

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
	 * @param string[] $devices The allowed devices.
	 * @param array    $value The value to parse.
	 * @param int      $min The minimum value.
	 * @param int      $max The maximum value.
	 *
	 * @return array The value based on devices and limited by min and max.
	 */
	public function makeDevicesValue( $devices, $value, $min, $max ) {

		$values = [];

		$number_util = new NumberUtil();

		foreach ( $devices as $device ) {
			if ( ! isset( $value[ $device ] ) ) {
				// We allow empty string.
				$values[ $device ] = '';
			} else {
				$values[ $device ] = $value[ $device ];
			}

			$values[ $device ] = $number_util->limitNumberWithUnit( $values[ $device ], $min, $max );
		}

		return $values;

	}

	/**
	 * Convert the value to an array value.
	 *
	 * @param string[] $devices The allowed devices.
	 * @param mixed    $raw_value The raw value.
	 * @param int      $min The minimum value.
	 * @param int      $max The maximum value.
	 *
	 * @return array The array value.
	 */
	public function toArrayValue( $devices, $raw_value, $min, $max ) {

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

		return $this->makeDevicesValue( $devices, $array_value, $min, $max );

	}

}
