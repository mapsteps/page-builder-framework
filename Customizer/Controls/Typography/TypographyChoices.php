<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Typography;

class TypographyChoices {

	/**
	 * Generate font family 'choices' args for the typography field.
	 *
	 * The format follows Select2's format.
	 *
	 * @see https://select2.org/data-sources/formats
	 *
	 * @param array $fonts_arg The fonts arguments.
	 * @return array
	 */
	public function makeFontFamilyChoices( $fonts_arg ) {

		$fonts_arg = empty( $fonts_arg ) || ! is_array( $fonts_arg ) ? [] : $fonts_arg;

		$fonts_util = new FontsUtil();

		$standard_fonts_arg    = ! empty( $fonts_arg['standard'] ) ? $fonts_arg['standard'] : [];
		$standard_font_options = [];

		if ( is_array( $standard_fonts_arg ) && ! empty( $standard_fonts_arg ) ) {
			foreach ( $standard_fonts_arg as $maybe_index_or_font_name => $font_name_or_stack ) {
				$font_family_value = is_int( $maybe_index_or_font_name ) ? $font_name_or_stack : $maybe_index_or_font_name;

				$standard_font_options[] = [
					'text' => $font_name_or_stack,
					'id'   => $font_family_value,
				];
			}
		} else {
			foreach ( $fonts_util->getStandardFonts() as $font_family_group_key => $font_data ) {
				if ( empty( $font_data['stack'] ) || empty( $font_data['label'] ) ) {
					continue;
				}

				$standard_font_options[] = [
					'text' => $font_data['label'],
					'id'   => $font_data['stack'],
				];
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
			$google_font_options[] = [
				'text' => $font_family,
				'id'   => $font_family,
			];
		}

		$families_arg        = isset( $fonts_arg['families'] ) && is_array( $fonts_arg['families'] ) ? $fonts_arg['families'] : [];
		$custom_font_choices = [];

		if ( ! empty( $families_arg ) ) {
			// Implementing the custom font families.
			foreach ( $families_arg as $font_family_key => $font_family_data ) {
				if ( empty( $font_family_data['children'] ) || ! is_array( $font_family_data['children'] ) ) {
					continue;
				}

				if ( empty( $font_family_key ) || ! is_string( $font_family_key ) ) {
					continue;
				}

				$font_family_key = $font_family_key;

				$options = [];

				foreach ( $font_family_data['children'] as $font_family ) {
					$font_family_value = ! empty( $font_family['value'] ) ? $font_family['value'] : '';
					$font_family_value = empty( $font_family_value ) && isset( $font_family['id'] ) ? $font_family['id'] : '';
					$font_family_value = $font_family_value;

					if ( empty( $font_family_value ) ) {
						continue;
					}

					$font_family_label = ! empty( $font_family['label'] ) ? $font_family['label'] : '';
					$font_family_label = empty( $font_family_label ) && isset( $font_family['text'] ) ? $font_family['text'] : '';
					$font_family_label = esc_attr( $font_family_label );

					if ( empty( $font_family_label ) ) {
						continue;
					}

					$options[] = [
						'text' => $font_family_label,
						'id'   => $font_family_value,
					];
				}

				$group_label = ! empty( $font_family_data['label'] ) ? $font_family_data['label'] : '';
				$group_label = empty( $group_label ) && ! empty( $font_family_data['text'] ) ? $font_family_data['text'] : '';
				$group_label = esc_attr( $group_label );

				$custom_font_choices[] = [
					'text'     => $group_label,
					'children' => $options,
				];
			}
		}

		$choices = array();

		if ( ! empty( $standard_font_options ) ) {
			$choices[] = [
				'text'     => __( 'Standard Fonts', 'page-builder-framework' ),
				'children' => $standard_font_options,
			];
		}

		if ( ! empty( $custom_font_choices ) ) {
			$choices = array_merge( $choices, $custom_font_choices );
		}

		if ( ! empty( $google_font_options ) ) {
			$choices[] = [
				'text'     => __( 'Google Fonts', 'page-builder-framework' ),
				'children' => $google_font_options,
			];
		}

		return $choices;

	}

	/**
	 * Generate font variant 'choices' args for the typography field.
	 *
	 * The format follows Select2's format.
	 *
	 * @see https://select2.org/data-sources/formats
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
			return $fonts_util->getStandardVariants();
		}

		$choices = [];

		foreach ( $families_arg as $font_family_key => $font_family_data ) :
			if ( empty( $font_family_data['children'] ) || ! is_array( $font_family_data['children'] ) ) {
				continue;
			}

			foreach ( $font_family_data['children'] as $font_family ) {
				if ( empty( $font_family ) || ! is_array( $font_family ) ) {
					continue;
				}

				$font_family_value = ! empty( $font_family['value'] ) ? $font_family['value'] : '';
				$font_family_value = empty( $font_family_value ) && ! empty( $font_family['id'] ) ? $font_family['id'] : '';

				if ( empty( $font_family_value ) ) {
					continue;
				}

				if ( ! isset( $variants_arg[ $font_family_value ] ) ) {
					continue;
				}

				// The $custom_variant here can be something like "400italic" or "italic".
				foreach ( $variants_arg[ $font_family_value ] as $custom_variant ) {
					if ( empty( $custom_variant ) ) {
						continue;
					}

					$custom_variant = is_numeric( $custom_variant ) ? (string) $custom_variant : $custom_variant;

					if ( ! is_string( $custom_variant ) ) {
						continue;
					}

					// Check if $custom_variant doesn't match any value in self::$complete_font_variants.
					if ( ! isset( FontsStore::$complete_font_variants[ $custom_variant ] ) ) {
						continue;
					}

					$choices[] = [
						'text' => FontsStore::$complete_font_variants[ $custom_variant ],
						'id'   => $custom_variant,
					];
				}
			}
			endforeach;

		return $choices;

	}

	/**
	 * Generate custom font variant options for a typography field.
	 *
	 * It will be printed as a property's value of global `wpbfFieldsFontVariants` JS object.
	 *
	 * @param array $fonts_arg The fonts arguments.
	 * @return array Array of 'id' and 'text' pairs (like Select2 format).
	 */
	public function makeCustomFontVariantOptions( $fonts_arg ) {

		$fonts_util = new FontsUtil();

		$standard_fonts_arg = ! empty( $fonts_arg['standard'] ) ? $fonts_arg['standard'] : [];

		$standard_font_variants = [];

		if ( is_array( $standard_fonts_arg ) && ! empty( $standard_fonts_arg ) ) {
			foreach ( $standard_fonts_arg as $maybe_index_or_font_name => $font_name_or_stack_or_data ) {
				if ( is_int( $maybe_index_or_font_name ) || ! is_array( $font_name_or_stack_or_data ) ) {
					continue;
				}

				if ( ! isset( $font_name_or_stack_or_data['variants'] ) ) {
					continue;
				}

				$font_name = $maybe_index_or_font_name;

				if ( ! isset( $standard_font_variants[ $font_name ] ) ) {
					$standard_font_variants[ $font_name ] = [];
				}

				foreach ( $font_name_or_stack_or_data['variants'] as $font_variant ) {
					if ( is_numeric( $font_variant ) ) {
						$font_variant = (string) $font_variant;
					}

					if ( ! isset( FontsStore::$standard_font_variants[ $font_variant ] ) ) {
						continue;
					}

					$standard_font_variants[ $font_name ][] = [
						'value' => $font_variant,
						'label' => FontsStore::$standard_font_variants[ $font_variant ],
					];
				}
			}
		} else {
			foreach ( $fonts_util->getStandardFonts() as $font_family_type => $font_data ) {
				if ( empty( $font_data['variants'] ) || ! is_array( $font_data['variants'] ) ) {
					continue;
				}

				if ( empty( $font_data['stack'] ) || empty( $font_data['label'] ) ) {
					continue;
				}

				if ( ! isset( $standard_font_variants[ $font_data['stack'] ] ) ) {
					$standard_font_variants[ $font_data['stack'] ] = [];
				}

				foreach ( $font_data['variants'] as $standard_variant ) {
					if ( ! isset( FontsStore::$standard_font_variants[ $standard_variant ] ) ) {
						continue;
					}

					$standard_font_variants[ $font_data['stack'] ][] = [
						'value' => $standard_variant,
						'label' => FontsStore::$standard_font_variants[ $standard_variant ],
					];
				}
			}
		}

		$families_arg = isset( $fonts_arg['families'] ) && is_array( $fonts_arg['families'] ) ? $fonts_arg['families'] : [];

		$custom_font_variants = [];

		if ( ! empty( $families_arg ) && isset( $fonts_arg['variants'] ) && is_array( $fonts_arg['variants'] ) ) {
			// Implementing the custom font families.
			foreach ( $families_arg as $font_family_key => $font_family_data ) {
				if ( empty( $font_family_data['children'] ) || ! is_array( $font_family_data['children'] ) ) {
					continue;
				}

				foreach ( $font_family_data['children'] as $font_family ) {
					if ( empty( $font_family ) || ! is_array( $font_family ) ) {
						continue;
					}

					if ( empty( $font_family['id'] ) || ! is_string( $font_family['id'] ) ) {
						continue;
					}

					if ( ! isset( $fonts_arg['variants'][ $font_family['id'] ] ) ) {
						continue;
					}

					if ( ! isset( $custom_font_variants[ $font_family['id'] ] ) ) {
						$custom_font_variants[ $font_family['id'] ] = [];
					}

					foreach ( $fonts_arg['variants'][ $font_family['id'] ] as $custom_variant ) {
						if ( is_numeric( $custom_variant ) ) {
							$custom_variant = (string) $custom_variant;
						}

						if ( ! isset( FontsStore::$complete_font_variants[ $custom_variant ] ) ) {
							continue;
						}

						$custom_font_variants[ $font_family['id'] ][] = [
							'value' => $custom_variant,
							'label' => FontsStore::$complete_font_variants[ $custom_variant ],
						];
					}
				}
			}
		}

		return array_merge( $standard_font_variants, $custom_font_variants );

	}

}
