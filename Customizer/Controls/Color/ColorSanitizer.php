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

		$value = strtolower( trim( $value ) );

		if ( 'transparent' === $value || 'currentcolor' === $value ) {
			return $value;
		}

		// Hex: #rgb, #rgba, #rrggbb, #rrggbbaa.
		if ( preg_match( '/^#([\da-f]{3}|[\da-f]{4}|[\da-f]{6}|[\da-f]{8})$/', $value ) ) {
			return $value;
		}

		// CSS variable, e.g. var(--accent).
		if ( preg_match( '/^var\(\s*--[a-z0-9_-]+\s*\)$/', $value ) ) {
			return $value;
		}

		// rgb(a), hsl(a), hsv(a): comma or space separated, optional alpha (also after a slash).
		if ( ! preg_match( '/^(rgba?|hsla?|hsva?)\(\s*([\d.%\s,\/deg]*?)\s*\)$/', $value, $matches ) ) {
			return '';
		}

		$parts = preg_split( '/\s*[,\/]\s*|\s+/', $matches[2] );

		if ( 3 !== count( $parts ) && 4 !== count( $parts ) ) {
			return '';
		}

		$is_rgb = 0 === strpos( $matches[1], 'rgb' );

		foreach ( $parts as $index => $part ) {
			if ( 3 === $index ) {
				$max = '%' === substr( $part, -1 ) ? 100 : 1;
			} elseif ( $is_rgb ) {
				$max = '%' === substr( $part, -1 ) ? 100 : 255;
			} else {
				$max = 0 === $index ? 360 : 100;
			}

			$number = 0 === $index && ! $is_rgb ? preg_replace( '/deg$/', '', $part ) : $part;
			$number = '%' === substr( $number, -1 ) ? substr( $number, 0, -1 ) : $number;

			if ( ! preg_match( '/^(\d+(\.\d+)?|\.\d+)$/', $number ) || (float) $number > $max ) {
				return '';
			}
		}

		return $value;

	}

}
