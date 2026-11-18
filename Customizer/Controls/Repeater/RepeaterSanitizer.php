<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Repeater;

use Mapsteps\Wpbf\Customizer\Controls\Color\ColorSanitizer;
use Mapsteps\Wpbf\Customizer\Controls\Media\ImageUtil;
use Mapsteps\Wpbf\Customizer\Controls\Media\MediaSanitizer;
use Mapsteps\Wpbf\Customizer\Controls\Media\UploadUtil;

class RepeaterSanitizer {

	/**
	 * Sanitize the repeater value.
	 *
	 * @param mixed $value The value to sanitize.
	 * @param array $fields The provided fields.
	 *
	 * @return array
	 */
	public function sanitize( $value, $fields = [] ) {

		// is the value formatted as a string?
		if ( is_string( $value ) && ! is_numeric( $value ) ) {
			$value = rawurldecode( $value );
			$value = json_decode( $value, true );
		}

		// Nothing to sanitize if we don't have fields or rows.
		if ( empty( $fields ) || ! is_array( $fields ) || ! is_array( $value ) ) {
			return [];
		}

		foreach ( $value as $row_id => $row_value ) {
			// Make sure the row is formatted as an array.
			if ( ! is_array( $row_value ) ) {
				$value[ $row_id ] = [];
				continue;
			}

			// Start parsing sub-fields in rows.
			foreach ( $row_value as $subfield_id => $subfield_value ) {

				// Make sure this is a valid subfield.
				// If it's not, then unset it.
				if ( ! isset( $fields[ $subfield_id ] ) ) {
					unset( $value[ $row_id ][ $subfield_id ] );
				}

				if ( ! isset( $fields[ $subfield_id ] ) ) {
					continue;
				}

				$subfield      = $fields[ $subfield_id ];
				$subfield_type = isset( $subfield['type'] ) ? $subfield['type'] : '';

				// Allow using a sanitize-callback on a per-field basis.
				if ( isset( $fields[ $subfield_id ]['sanitize_callback'] ) ) {
					$subfield_value = call_user_func( $fields[ $subfield_id ]['sanitize_callback'], $subfield_value );
				} else {

					switch ( $subfield_type ) {
						case 'image':
						case 'cropped_image':
						case 'upload':
							$save_as = isset( $subfield['properties'] ) && isset( $subfield['properties']['save_as'] ) ? $subfield['properties']['save_as'] : 'url';

							$media_util = 'upload' === $subfield_type ? new UploadUtil() : new ImageUtil();

							$subfield_value = ( new MediaSanitizer() )->sanitize( $subfield_value, $media_util, $save_as );

							break;
						case 'dropdown-pages':
							$subfield_value = (int) $subfield_value;
							break;
						case 'color':
							if ( $subfield_value ) {
								$subfield_value = ( new ColorSanitizer() )->sanitize( $subfield_value );
							}
							break;
						case 'text':
							$subfield_value = sanitize_text_field( $subfield_value );
							break;
						case 'url':
						case 'link':
							$subfield_value = esc_url_raw( $subfield_value );
							break;
						case 'email':
							$subfield_value = filter_var( $subfield_value, FILTER_SANITIZE_EMAIL );
							break;
						case 'tel':
							$subfield_value = sanitize_text_field( $subfield_value );
							break;
						case 'checkbox':
							$subfield_value = (bool) $subfield_value;
							break;
						case 'textarea':
							$subfield_value = wp_kses_post( $subfield_value );
							break;
						case 'number':
							$subfield_value = is_numeric( $subfield_value ) ? $subfield_value + 0 : '';
							break;
						default:
							// Select (single or multiple), radio and any other type: plain text, also inside arrays.
							$subfield_value = is_array( $subfield_value ) ? array_map( 'sanitize_text_field', array_filter( $subfield_value, 'is_scalar' ) ) : sanitize_text_field( $subfield_value );
					}
				}

				$value[ $row_id ][ $subfield_id ] = $subfield_value;
			}
		}

		return $value;

	}

}
