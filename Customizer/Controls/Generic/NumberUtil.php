<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Generic;

class NumberUtil {

	/**
	 * Limit number based on the min and max values.
	 *
	 * @param mixed          $value The value to parse.
	 * @param null|int|float $min   The minimum value. Null if not set.
	 * @param null|int|float $max   The maximum value. Null if not set.
	 *
	 * @return int|float
	 */
	public function limitNumber( $value, $min = null, $max = null ) {

		if ( '' === $value ) {
			return '';
		}

		if ( ! is_string( $value ) && ! is_numeric( $value ) ) {
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

			return $value;
		}

		if ( ! is_null( $min ) ) {
			if ( $value < $min ) {
				$value = $min;
			}
		} elseif ( ! is_null( $max ) ) {
			if ( $value > $max ) {
				$value = $max;
			}
		}

		return $value;

	}

	/**
	 * Limit number with unit based on the min and max values.
	 *
	 * @param mixed          $value The value to parse.
	 * @param null|int|float $min   The minimum value. Null if not set.
	 * @param null|int|float $max   The maximum value. Null if not set.
	 *
	 * @return string|int|float
	 */
	public function limitNumberWithUnit( $value, $min = null, $max = null ) {

		if ( '' === $value ) {
			return '';
		}

		if ( ! is_string( $value ) && ! is_numeric( $value ) ) {
			return '';
		}

		$number_and_unit = $this->separateNumberAndUnit( $value );

		$number = $number_and_unit['number'];
		$number = $this->limitNumber( $number, $min, $max );
		$unit   = $number_and_unit['unit'];

		if ( '' === $number ) {
			return '';
		}

		if ( ! $unit ) {
			return $number;
		}

		return $number . $unit;

	}

	/**
	 * Separate number and unit.
	 * The returned value will be a pair of `unit` and `number`.
	 *
	 * @param mixed $value The value to separate.
	 *
	 * @return array
	 */
	public function separateNumberAndUnit( $value ) {

		// We support empty string.
		if ( '' === $value ) {
			return array(
				'number' => '',
				'unit'   => '',
			);
		}

		if ( ! is_string( $value ) && ! is_numeric( $value ) ) {
			return [
				'number' => '',
				'unit'   => '',
			];
		}

		$str_value = ! is_string( $value ) ? (string) $value : $value;

		$unit   = preg_replace( '/\d+/', '', $str_value );
		$unit   = $unit ?: '';
		$number = $unit ? str_ireplace( $unit, '', $str_value ) : $str_value;
		$number = $number && is_numeric( $number ) ? (float) $number : '';

		return array(
			'number' => $number,
			'unit'   => $unit,
		);

	}

	/**
	 * Parse a value and make sure it's properly formatted either with or without unit.
	 *
	 * If without unit, it should be formatted as `float` or `int`.
	 * Otherwise, it should be string.
	 *
	 * @param mixed $value The value to parse.
	 *
	 * @return string|float|int
	 */
	public function makeSureValueWithOrWithoutUnit( $value ) {

		$number_and_unit = $this->separateNumberAndUnit( $value );

		$number = $number_and_unit['number'];
		$unit   = $number_and_unit['unit'];

		if ( ! $unit ) {
			return $number;
		}

		return $number . $unit;

	}

}
