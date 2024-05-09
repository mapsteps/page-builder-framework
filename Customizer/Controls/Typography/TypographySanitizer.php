<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Typography;

use Mapsteps\Wpbf\Customizer\Controls\Color\ColorSanitizer;

class TypographySanitizer {

	/**
	 * Sanitize the typography value.
	 *
	 * @param mixed $value The value to sanitize.
	 * @return array
	 */
	public function sanitize( $value ) {

		if ( ! is_array( $value ) ) {
			return [];
		}

		foreach ( $value as $key => $val ) {
			switch ( $key ) {
				case 'font-family':
					$value['font-family'] = sanitize_text_field( html_entity_decode( $val ) );
					break;

				case 'variant':
					// Use 'regular' instead of 400 for font-variant.
					$value['variant'] = ( 400 === $val || '400' === $val ) ? 'regular' : $val;

					// Get font-weight from variant.
					$value['font-weight'] = filter_var( $value['variant'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
					$value['font-weight'] = ( 'regular' === $value['variant'] || 'italic' === $value['variant'] ) ? '400' : (string) absint( $value['font-weight'] );

					// Get font-style from variant.
					if ( ! isset( $value['font-style'] ) ) {
						$value['font-style'] = ( false === strpos( $value['variant'], 'italic' ) ) ? 'normal' : 'italic';
					}

					break;

				case 'text-align':
					if ( ! in_array( $val, [ '', 'inherit', 'left', 'center', 'right', 'justify' ], true ) ) {
						$value['text-align'] = '';
					}

					break;

				case 'text-transform':
					if ( ! in_array( $val, [ '', 'none', 'capitalize', 'uppercase', 'lowercase', 'initial', 'inherit' ], true ) ) {
						$value['text-transform'] = '';
					}

					break;

				case 'text-decoration':
					if ( ! in_array( $val, [ '', 'none', 'underline', 'overline', 'line-through', 'solid', 'wavy', 'initial', 'inherit' ], true ) ) {
						$value['text-transform'] = '';
					}

					break;

				case 'color':
					$value['color'] = '' === $val ? '' : ( new ColorSanitizer() )->sanitize( $val );
					break;

				default:
					$value[ $key ] = sanitize_text_field( $value[ $key ] );
			}
		}

		return $value;

	}

}
