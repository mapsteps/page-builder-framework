<?php

namespace Mapsteps\Wpbf\Customizer\Controls\MarginPadding;

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

		$parsed_values = [];

		foreach ( $array_values as $dimension => $dimension_value ) {
			if ( '' === $dimension_value || null === $dimension_value ) {
				$parsed_values[ $dimension ] = '';
				continue;
			}

			$value_unit    = preg_replace( '/\d+/', '', $dimension_value );
			$numeric_value = $value_unit ? str_ireplace( $value_unit, '', $dimension_value ) : $dimension_value;

			if ( empty( $value_unit ) ) {
				if ( ! empty( $unit ) ) {
					$value_unit = $unit;
				}
			}

			// We allow empty string.
			if ( '' === $numeric_value ) {
				$parsed_values[ $dimension ] = '';
				continue;
			}

			$numeric_value = $numeric_value && is_numeric( $numeric_value ) ? (float) $numeric_value : '';

			// If unit is explicitly set to `false`, then don't use unit.
			$the_value = '' === $numeric_value ? '' : ( false === $unit ? $numeric_value : $numeric_value . $value_unit );

			$parsed_values[ $dimension ] = $the_value;
		}

		return $this->makeDimensionsValue( $dimensions, $parsed_values );

	}

}
