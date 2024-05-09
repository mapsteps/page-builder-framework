<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Color;

class ColorSanitizer {

	/**
	 * Sanitize color value.
	 *
	 * @param string|array $value The color value.
	 *
	 * @return string|int[]
	 */
	public function sanitize( $value ) {

		$sanitized_value = '';

		if ( is_string( $value ) ) {
			$sanitized_value = $this->sanitizeColorString( $value );
		} elseif ( is_array( $value ) ) {
			if ( isset( $value['r'] ) || isset( $value['g'] ) || isset( $value['b'] ) ) {
				$sanitized_value = $this->sanitizeColorArray( $value, 'rgb' );
			} elseif ( isset( $value['h'] ) || isset( $value['s'] ) ) {
				if ( isset( $value['l'] ) ) {
					$sanitized_value = $this->sanitizeColorArray( $value, 'hsl' );
				} elseif ( isset( $value['v'] ) ) {
					$sanitized_value = $this->sanitizeColorArray( $value, 'hsv' );
				}
			}
		}

		return $sanitized_value;

	}

	/**
	 * Sanitize single array-formatted color value.
	 *
	 * @param array  $color The provided color in array format.
	 * @param string $color_type The color type. Accepts: 'rgb', 'hsl', or 'hsv'.
	 *
	 * @return int[] The sanitized color value.
	 */
	private function sanitizeColorArray( $color, $color_type = 'rgb' ) {

		$keys = array( 'r', 'g', 'b' );
		$mins = array( 0, 0, 0 );
		$maxs = array( 255, 255, 255 );

		if ( 'hsl' === $color_type || 'hsv' === $color_type ) {
			$keys    = array( 'h', 's', '' );
			$keys[2] = isset( $color['v'] ) ? 'v' : 'l';

			$mins = array( 0, 0, 0 );
			$maxs = array( 360, 100, 100 );
		}

		$sanitized_color = array(
			$keys[0] => isset( $color[ $keys[0] ] ) ? absint( $color[ $keys[0] ] ) : $mins[0],
			$keys[1] => isset( $color[ $keys[1] ] ) ? absint( $color[ $keys[1] ] ) : $mins[1],
			$keys[2] => isset( $color[ $keys[2] ] ) ? absint( $color[ $keys[2] ] ) : $mins[2],
		);

		$sanitized_color[ $keys[0] ] = max( $sanitized_color[ $keys[0] ], $mins[0] );
		$sanitized_color[ $keys[0] ] = min( $sanitized_color[ $keys[0] ], $maxs[0] );

		$sanitized_color[ $keys[1] ] = max( $sanitized_color[ $keys[1] ], $mins[1] );
		$sanitized_color[ $keys[1] ] = min( $sanitized_color[ $keys[1] ], $maxs[1] );

		$sanitized_color[ $keys[2] ] = max( $sanitized_color[ $keys[2] ], $mins[2] );
		$sanitized_color[ $keys[2] ] = min( $sanitized_color[ $keys[2] ], $maxs[2] );

		if ( isset( $color['a'] ) ) {
			$sanitized_color['a'] = filter_var( $color['a'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
			$sanitized_color['a'] = max( $sanitized_color['a'], 0 );
			$sanitized_color['a'] = min( $sanitized_color['a'], 1 );
		}

		return $sanitized_color;

	}

	/**
	 * Sanitize string-formatted color.
	 *
	 * @param string $value The color.
	 *
	 * @return string
	 */
	private function sanitizeColorString( $value ) {

		$value = strtolower( $value );

		/**
		 * This pattern will check and match 3/6/8-character hex, rgb, rgba, hsl, hsla, hsv, and hsva colors.
		 *
		 * RGB regex:
		 *
		 * @link https://stackoverflow.com/questions/9585973/javascript-regular-expression-for-rgb-values#answer-9586045
		 *
		 * For testing it, you can use these links:
		 *
		 * @link https://regex101.com/
		 * @link https://regexr.com/
		 * @link https://www.regextester.com/
		 *
		 * How to test it?
		 *
		 * Paste the following code to the test field (of course without the asterisks and spaces in front of them):
		 * rgba(255, 255, 0, 0.9)
		 * rgb(255, 255, 0)
		 * #ff0
		 * #ffff00
		 * hsl(150, 25%, 25%)
		 * hsla(250, 25%, 25%, 0.7)
		 * hsv(125, 15%, 30%)
		 * hsva(125, 15%, 30%, 0.5)
		 *
		 * And then paste the regex `$pattern` below (without the single quote's start and end) to the regular expression box.
		 * Set the flag to use "global" and "multiline".
		 */
		$pattern = '/^(#[\da-f]{3}|#[\da-f]{6}|#[\da-f]{8}|rgba\(((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*,\s*){2}((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*)(,\s*(0\.\d+|1))\)|rgb\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*\)|hsla\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)(,\s*(0\.\d+|1))\)|hsl\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)\)|hsva\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)(,\s*(0\.\d+|1))\)|hsv\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)\))$/';

		preg_match( $pattern, $value, $matches );

		// Return the 1st match found.
		if ( isset( $matches[0] ) ) {
			if ( is_string( $matches[0] ) ) {
				return $matches[0];
			}

			if ( is_array( $matches[0] ) && isset( $matches[0][0] ) ) {
				return $matches[0][0];
			}
		}

		// If no match was found, return an empty string.
		return '';
	}

}
