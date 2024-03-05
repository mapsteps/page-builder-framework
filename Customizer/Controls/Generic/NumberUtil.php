<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Generic;

class NumberUtil {

	/**
	 * Parse number based on the min and max values.
	 *
	 * @param string|int|float $value The value to sanitize.
	 * @param null|int|float   $min   The minimum value. Null if not set.
	 * @param null|int|float   $max   The maximum value. Null if not set.
	 *
	 * @return int|float
	 */
	public function parse_number( $value, $min = null, $max = null ) {
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

	/**
	 * Sanitize number with unit.
	 *
	 * @param string|int|float $value The value to sanitize.
	 * @param null|int|float   $min   The minimum value. Null if not set.
	 * @param null|int|float   $max   The maximum value. Null if not set.
	 *
	 * @return string|int|float
	 */
	public function parse_number_with_unit( $value, $min = null, $max = null ) {

		$number_and_unit = $this->separate_number_and_unit( $value );

		$number = $number_and_unit['number'];
		$number = $this->parse_number( $number, $min, $max );
		$unit   = $number_and_unit['unit'];

		if ( ! $unit ) {
			return $number;
		}

		return $number . $unit;

	}

	/**
	 * Separate number and unit.
	 * The returned value will be a pair of `unit` and `number`.
	 *
	 * @param string|float|int $value The value to separate.
	 *
	 * @return array
	 */
	public function separate_number_and_unit( $value ) {

		// We support empty string.
		if ( '' === $value ) {
			return array(
				'number' => '',
				'unit'   => '',
			);
		}

		$unit   = preg_replace( '/\d+/', '', $value );
		$unit   = $unit ?: '';
		$number = $unit ? str_ireplace( $unit, '', $value ) : $value;
		$number = $number && is_numeric( $number ) ? (float) $number : '';

		return array(
			'number' => $number,
			'unit'   => $unit,
		);

	}

}