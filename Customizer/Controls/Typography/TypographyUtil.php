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

		$google_fonts_arg = ! empty( $fonts_arg['google'] ) ? $fonts_arg['google'] : [];

		$sorting   = 'alpha';
		$max_fonts = 9999;

		if ( ! empty( $google_fonts_arg ) ) {
			if ( in_array( $fonts_arg['google'][0], [ 'alpha', 'popularity', 'trending' ], true ) ) {
				$sorting = $fonts_arg['google'][0];

				if ( isset( $fonts_arg['google'][1] ) && is_int( $fonts_arg['google'][1] ) ) {
					$max_fonts = absint( $fonts_arg['google'][1] );
				}

				$raw_google_fonts = ( new GoogleFontsUtil() )->getFontNamesByArgs( [
					'sort'  => $sorting,
					'count' => $max_fonts,
				] );
			} else {
				$raw_google_fonts = $fonts_arg['google'];
			}
		} else {
			$raw_google_fonts = ( new GoogleFontsUtil() )->getFontNamesByArgs( [
				'sort'  => $sorting,
				'count' => $max_fonts,
			] );
		}

		$std_fonts = [];

		if ( ! isset( $fonts_arg['standard'] ) ) {
			$standard_fonts = ( new FontsUtil() )->getStandardFonts();

			foreach ( $standard_fonts as $font ) {
				$std_fonts[ $font['stack'] ] = $font['label'];
			}
		} elseif ( is_array( $fonts_arg['standard'] ) ) {
			foreach ( $fonts_arg['standard'] as $key => $val ) {
				$key = ( is_int( $key ) ) ? $val : $key;

				$std_fonts[ $key ] = $val;
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

		$choices['standard'] = [
			esc_html__( 'Standard Fonts', 'page-builder-framework' ),
			$std_fonts,
		];

		$choices['google'] = [
			esc_html__( 'Google Fonts', 'page-builder-framework' ),
			array_combine( array_values( $raw_google_fonts ), array_values( $raw_google_fonts ) ),
		];

		if ( empty( $choices['standard'][1] ) ) {
			$choices = array_combine( array_values( $raw_google_fonts ), array_values( $raw_google_fonts ) );
		} elseif ( empty( $choices['google'][1] ) ) {
			$choices = $std_fonts;
		}

		return $choices;

	}

}
