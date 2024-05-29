<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Generic;

class NumberUtil {

	/**
	 * Normalize max value
	 *
	 * @param int|float|null $min Minimum value.
	 * @param int|float|null $max Maximum value.
	 *
	 * @return int|float|null
	 */
	public function normalizeMaxValue( $min, $max ) {

		if ( is_null( $min ) || is_null( $max ) ) {
			return $max;
		}

		if ( $min > $max ) {
			return $min;
		}

		return $max;

	}

	/**
	 * Limit number based on the min and max values.
	 *
	 * @param mixed          $value The value to parse.
	 * @param null|int|float $min   The minimum value. Null if not set.
	 * @param null|int|float $max   The maximum value. Null if not set.
	 *
	 * @return int|float|string The returned value can be either `int`, `float`, or empty string.
	 */
	public function limitNumber( $value, $min = null, $max = null ) {

		if ( '' === $value ) {
			return '';
		}

		if ( ! is_string( $value ) && ! is_numeric( $value ) ) {
			return '';
		}

		$value = (float) $value;

		if ( ! is_null( $min ) ) {
			if ( $value < $min ) {
				$value = $min;
			}
		}

		if ( ! is_null( $max ) ) {
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
	 * @return string|int|float The returned value can be either `int`, `float`, empty string, or concatenation between value and unit.
	 */
	public function limitNumberWithUnit( $value, $min = null, $max = null ) {

		if ( '' === $value ) {
			return '';
		}

		if ( ! is_string( $value ) && ! is_numeric( $value ) ) {
			return '';
		}

		$number_and_unit = $this->makeNumberUnitPair( $value );

		$number = $number_and_unit['number'];
		$unit   = $number_and_unit['unit'];

		if ( '' === $number ) {
			return '';
		}

		$number = $this->limitNumber( $number, $min, $max );

		if ( ! $unit ) {
			return $number;
		}

		return $number . $unit;

	}

	/**
	 * Get unit from a value.
	 *
	 * @param mixed $value The value to get unit from.
	 *
	 * @return string The unit or empty string if there's no unit.
	 */
	public function getUnit( $value ) {

		$str_value    = (string) $value;
		$unit_pattern = '/[a-z%]+$/i';

		if ( preg_match( $unit_pattern, $str_value, $matches ) ) {
			return $matches[0];
		}

		return '';

	}

	/**
	 * Separate number and unit.
	 *
	 * @param mixed $value The value to separate.
	 *
	 * @return array The returned value will be a pair of `unit` and `number`.
	 */
	public function makeNumberUnitPair( $value ) {

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

		$unit    = $this->getUnit( $str_value );
		$numeric = $unit ? str_ireplace( $unit, '', $str_value ) : $str_value;

		if ( '' === $numeric ) {
			return [
				'number' => '',
				'unit'   => $unit,
			];
		}

		$number = is_numeric( $numeric ) ? (float) $numeric : '';

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
	 * @return string|float|int The returned value can be either `int`, `float`, empty string, or concatenation between value and unit.
	 */
	public function makeSureValueWithOrWithoutUnit( $value ) {

		$number_and_unit = $this->makeNumberUnitPair( $value );

		$number = $number_and_unit['number'];
		$unit   = $number_and_unit['unit'];

		if ( ! $unit || '' === $number ) {
			return $number;
		}

		return $number . $unit;

	}

	/**
	 * Parse a value and make sure it's without unit.
	 *
	 * @param mixed $value The value to parse.
	 *
	 * @return float|int|string The returned value can be either `int`, `float` or empty string.
	 */
	public function makeSureValueWithoutUnit( $value ) {

		$number_and_unit = $this->makeNumberUnitPair( $value );

		return $number_and_unit['number'];

	}

	/**
	 * Parse a value and make sure it's a number.
	 *
	 * @param mixed $value The value to parse.
	 *
	 * @return float|int
	 */
	public function makeSureValueIsNumber( $value ) {

		$number_and_unit = $this->makeNumberUnitPair( $value );

		$number = $number_and_unit['number'];

		return '' !== $number ? $number : 0;

	}

}
