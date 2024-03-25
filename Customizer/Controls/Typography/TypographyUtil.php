<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Typography;

class TypographyUtil {

	/**
	 * Generate font family choices for the typography field.
	 *
	 * @param string $default_value The default font-family value.
	 * @param array  $fonts_arg The fonts arguments.
	 *
	 * @return array
	 */
	public function makeFontFamilyChoices( $default_value, $fonts_arg ) {

		$default_value = empty( $default_value ) || is_string( $default_value ) ? $default_value : '';
		$default_label = __( 'Default', 'page-builder-framework' );
		$fonts_arg     = empty( $fonts_arg ) || ! is_array( $fonts_arg ) ? [] : $fonts_arg;

		$fonts_util = new FontsUtil();

		$standard_fonts_arg    = ! empty( $fonts_arg['standard'] ) ? $fonts_arg['standard'] : [];
		$standard_font_options = [];

		if ( is_array( $standard_fonts_arg ) && ! empty( $standard_fonts_arg ) ) {
			foreach ( $standard_fonts_arg as $maybe_index_or_font_name => $font_name_or_stack ) {
				$key = is_int( $maybe_index_or_font_name ) ? $font_name_or_stack : $maybe_index_or_font_name;

				$standard_font_options[ $key ] = $font_name_or_stack;
			}
		} else {
			foreach ( $fonts_util->getStandardFonts() as $font_family_type => $font_data ) {
				if ( empty( $font_data['stack'] ) || empty( $font_data['label'] ) ) {
					continue;
				}

				$standard_font_options[ $font_data['stack'] ] = $font_data['label'];
			}
		}

		$google_fonts_arg = ! empty( $fonts_arg['google'] ) ? $fonts_arg['google'] : [];

		/**
		 * The sorting mode.
		 *
		 * @var string|null $sort_by
		 */
		$sort_by = null;

		/**
		 * Maximum amount of fonts to get.
		 *
		 * @var int|null $max_fonts
		 */
		$max_fonts = null;

		$google_fonts_util = new GoogleFontsUtil();

		$google_font_names = [];

		if ( ! empty( $google_fonts_arg ) ) {
			// If the argument is formatted like `'google' => [ 'popularity', 30 ],`.
			if ( in_array( $google_fonts_arg[0], $google_fonts_util->available_sortby_modes, true ) ) {
				$sort_by = $google_fonts_arg[0];

				if ( isset( $google_fonts_arg[1] ) && is_int( $fonts_arg['google'][1] ) ) {
					$max_fonts = absint( $fonts_arg['google'][1] );
				}

				$google_font_names = $google_fonts_util->getFilteredFontNames( $sort_by, $max_fonts );
			} else {
				// Otherwise, we assume the argument is formatted like `'google' => [ 'Roboto', 'Open Sans', 'Lato' ]`.
				$google_font_names = $fonts_arg['google'];
			}
		} else {
			// If 'google' fonts arg not set, then use all Google Font's names.
			$google_font_names = FontsStore::$google_font_names;
		}

		$google_font_options = [];

		foreach ( $google_font_names as $font_family ) {
			$google_font_options[ $font_family ] = $font_family;
		}

		$families_arg        = isset( $fonts_arg['families'] ) && is_array( $fonts_arg['families'] ) ? $fonts_arg['families'] : [];
		$custom_font_options = [];

		if ( ! empty( $families_arg ) ) {
			// Implementing the custom font families.
			foreach ( $families_arg as $font_family_key => $font_family_value ) {
				if ( empty( $font_family_value['children'] ) || ! is_array( $font_family_value['children'] ) ) {
					continue;
				}

				if ( empty( $font_family_key ) || ! is_string( $font_family_key ) ) {
					continue;
				}

				$font_family_key = esc_attr( $font_family_key );

				if ( ! isset( $custom_font_options[ $font_family_key ] ) ) {
					$custom_font_options[ $font_family_key ] = [];
				}

				foreach ( $font_family_value['children'] as $font_family ) {
					if ( empty( $font_family['id'] ) || empty( $font_family['text'] ) ) {
						continue;
					}

					if ( ! is_string( $font_family['id'] ) || ! is_string( $font_family['text'] ) ) {
						continue;
					}

					$font_family_id   = esc_attr( $font_family['id'] );
					$font_family_text = esc_attr( $font_family['text'] );

					$custom_font_options[ $font_family_key ][ $font_family_id ] = $font_family_text;
				}
			}
		}

		$choices = [];

		$choices['default'] = [
			$default_label,
			[ $default_value => $default_value ],
		];

		if ( ! empty( $standard_font_options ) ) {
			$choices['standard'] = [
				__( 'Standard Fonts', 'page-builder-framework' ),
				$standard_font_options,
			];
		}

		if ( ! empty( $custom_font_options ) ) {
			$choices = array_merge( $choices, $custom_font_options );
		}

		if ( ! empty( $google_font_options ) ) {
			$choices['google'] = [
				__( 'Google Fonts', 'page-builder-framework' ),
				$google_font_options,
			];
		}

		return $choices;

	}

	/**
	 * Generate font variant choices for the typography field.
	 *
	 * @param array $fonts_arg The fonts arguments.
	 * @return array
	 */
	public function makeFontVariantChoices( $fonts_arg ) {

		$fonts_arg  = empty( $fonts_arg ) || ! is_array( $fonts_arg ) ? [] : $fonts_arg;
		$fonts_util = new FontsUtil();

		$variants_arg = ! empty( $fonts_arg['variants'] ) && is_array( $fonts_arg['variants'] ) ? $fonts_arg['variants'] : [];
		$families_arg = ! empty( $fonts_arg['families'] ) && is_array( $fonts_arg['families'] ) ? $fonts_arg['families'] : [];

		if ( empty( $families_arg ) ) {
			return $fonts_util->getStandardVariantOptions();
		}

		$choices = [];

		foreach ( $families_arg as $font_family_key => $font_family_value ) :
			if ( empty( $font_family_value['children'] ) || ! is_array( $font_family_value['children'] ) ) {
				continue;
			}

			foreach ( $font_family_value['children'] as $font_family ) {
				if ( empty( $font_family ) || ! is_array( $font_family ) ) {
					continue;
				}

				if ( empty( $font_family['id'] ) || ! is_string( $font_family['id'] ) ) {
					continue;
				}

				$font_family_id = esc_attr( $font_family['id'] );

				if ( ! isset( $variants_arg[ $font_family_id ] ) ) {
					continue;
				}

				// The $custom_variant here can be something like "400italic" or "italic".
				foreach ( $variants_arg[ $font_family_id ] as $custom_variant ) {
					if ( empty( $custom_variant ) || ! is_string( $custom_variant ) ) {
						continue;
					}

					// Check if $custom_variant doesn't exist in self::$complete_font_variants.
					if ( isset( FontsStore::$complete_font_variants[ $custom_variant ] ) ) {
						continue;
					}

					array_push(
						$choices,
						[
							'value' => $custom_variant,
							'label' => FontsStore::$complete_font_variants[ $custom_variant ],
						]
					);
				}
			}
		endforeach;

	}

}
