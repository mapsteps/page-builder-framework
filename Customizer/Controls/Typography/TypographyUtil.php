<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Typography;

class TypographyUtil {

	/**
	 * Generate font family choices for the typography field.
	 *
	 * @param array $fonts_arg The fonts arguments.
	 * @return array
	 */
	public function makeFontFamilyChoices( $fonts_arg = array() ) {

		$google_fonts_util = new GoogleFontsUtil();
		$fonts_util        = new FontsUtil();

		$google_fonts_arg   = ! empty( $fonts_arg['google'] ) ? $fonts_arg['google'] : [];
		$standard_fonts_arg = ! empty( $fonts_arg['standard'] ) ? $fonts_arg['standard'] : [];

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

		$google_font_names = [];

		if ( ! empty( $google_fonts_arg ) ) {
			// If the argument is formatted like `'google' => [ 'popularity', 30 ],`.
			if ( in_array( $google_fonts_arg[0], $google_fonts_util->available_sorting_modes, true ) ) {
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
			$google_font_names = TypographyStore::$google_font_names;
		}

		$standard_fonts = [];

		if ( is_array( $standard_fonts_arg ) && ! empty( $standard_fonts_arg ) ) {
			foreach ( $standard_fonts_arg as $maybe_index_or_font_name => $font_name_or_stack ) {
				$key = is_int( $maybe_index_or_font_name ) ? $font_name_or_stack : $maybe_index_or_font_name;

				$standard_fonts[ $key ] = $font_name_or_stack;
			}
		} else {
			foreach ( $fonts_util->getStandardFonts() as $font_family_type => $font_data ) {
				if ( empty( $font_data['stack'] ) || empty( $font_data['label'] ) ) {
					continue;
				}

				$standard_fonts[ $font_data['stack'] ] = $font_data['label'];
			}
		}

		$choices = [];

		$choices['default'] = array(
			__( 'Defaults', 'page-builder-framework' ),
			[
				'' => __( 'Default', 'page-builder-framework' ),
			],
		);

		if ( isset( $fonts_arg['families'] ) ) {
			// Implementing the custom font families.
			foreach ( $fonts_arg['families'] as $font_family_key => $font_family_value ) {
				if ( ! isset( $choices[ $font_family_key ] ) ) {
					$choices[ $font_family_key ] = [];
				}

				$family_opts = [];

				foreach ( $font_family_value['children'] as $font_family ) {
					$family_opts[ $font_family['id'] ] = $font_family['text'];
				}

				$choices[ $font_family_key ] = array(
					$font_family_value['text'],
					$family_opts,
				);
			}
		}

		$choices = [];

		if ( ! empty( $standard_fonts ) && ! empty( $google_font_names ) ) {
			if ( ! empty( $standard_fonts ) ) {
				$choices['standard'] = [
					__( 'Standard Fonts', 'page-builder-framework' ),
					$standard_fonts,
				];
			}

			if ( ! empty( $google_font_names ) ) {
				$choices['google'] = [
					__( 'Google Fonts', 'page-builder-framework' ),
					$google_font_names,
				];
			}
		} elseif ( empty( $standard_fonts ) ) {
			$choices = $google_font_names;
		} else {
			$choices = $standard_fonts;
		}

		return $choices;

	}

}
