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

		// Nothing to sanitize if we don't have fields.
		if ( empty( $fields ) || ! is_array( $fields ) ) {
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

				// Get the subfield-type.
				if ( ! isset( $fields[ $subfield_id ]['type'] ) ) {
					continue;
				}

				$subfield      = $fields[ $subfield_id ];
				$subfield_type = $subfield['type'];

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
						case 'select':
							if ( isset( $fields[ $subfield_id ]['multiple'] ) ) {
								if ( true === $fields[ $subfield_id ]['multiple'] ) {
									$multiple = 2;
								}
								$multiple = (int) $fields[ $subfield_id ]['multiple'];
								if ( 1 < $multiple ) {
									$subfield_value = (array) $subfield_value;
									foreach ( $subfield_value as $sub_subfield_key => $sub_subfield_value ) {
										$subfield_value[ $sub_subfield_key ] = sanitize_text_field( $sub_subfield_value );
									}
								} else {
									$subfield_value = sanitize_text_field( $subfield_value );
								}
							}
							break;
						case 'radio':
						case 'radio-image':
							$subfield_value = sanitize_text_field( $subfield_value );
							break;
						case 'textarea':
							$subfield_value = html_entity_decode( wp_kses_post( $subfield_value ) );

					}
				}

				$value[ $row_id ][ $subfield_id ] = $subfield_value;
			}
		}

		return $value;

	}

}
