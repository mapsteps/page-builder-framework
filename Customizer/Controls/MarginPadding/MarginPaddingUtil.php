<?php

namespace Mapsteps\Wpbf\Customizer\Controls\MarginPadding;

use Mapsteps\Wpbf\Customizer\Controls\Generic\NumberUtil;

class MarginPaddingUtil {

	/**
	 * Create values based on the allowed dimensions.
	 *
	 * @param string[] $dimensions The allowed dimensions.
	 * @param array    $value      The value to parse.
	 *
	 * @return array
	 */
	public function makeDimensionsValue( $dimensions, $value ) {

		$dimension_values = [];

		foreach ( $dimensions as $dimension ) {
			if ( isset( $value[ $dimension ] ) ) {
				$dimension_values[ $dimension ] = $value[ $dimension ];
			} else {
				$dimension_values[ $dimension ] = '';
			}
		}

		return $dimension_values;

	}

	/**
	 * Convert values to array with/without unit depending on the provided unit.
	 *
	 * If unit is explicitly set to `false`, then the returned array will be without unit.
	 *
	 * @param string[]     $dimensions The allowed dimensions.
	 * @param string|false $unit       The unit to use.
	 * @param string|array $value      The value to convert to array with unit.
	 *
	 * @return array
	 */
	public function toArrayValue( $dimensions, $unit, $value ) {

		if ( empty( $value ) ) {
			return [];
		}

		$array_values = is_array( $value ) ? $value : [];

		// Assuming this is a JSON string.
		if ( is_string( $value ) ) {
			$value          = sanitize_text_field( $value );
			$decoded_values = json_decode( $value, true );

			// If it can't be decoded.
			if ( ! $decoded_values ) {
				return [];
			}

			if ( ! is_array( $decoded_values ) ) {
				return [];
			}

			$array_values = $decoded_values;
		}

		$number_util = new NumberUtil();

		$parsed_values = [];

		foreach ( $array_values as $dimension => $dimension_value ) {
			if ( '' === $dimension_value || null === $dimension_value ) {
				$parsed_values[ $dimension ] = '';
				continue;
			}

			$number_and_unit = $number_util->makeNumberUnitPair( $dimension_value );

			$value_number = $number_and_unit['number'];
			$value_unit   = $number_and_unit['unit'];
			$value_unit   = empty( $value_unit ) && ! empty( $unit ) ? $unit : $value_unit;

			// We allow empty string.
			if ( '' === $value_number ) {
				$parsed_values[ $dimension ] = '';
				continue;
			}

			// If unit is explicitly set to `false`, then don't use unit.
			$formatted_value = false === $unit ? $value_number : $value_number . $value_unit;

			$parsed_values[ $dimension ] = $formatted_value;
		}

		return $this->makeDimensionsValue( $dimensions, $parsed_values );

	}

}
