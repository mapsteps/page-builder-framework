<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Typography;

final class FontsUtil {

	/**
	 * Get array of standard websafe fonts.
	 *
	 * @return array Standard websafe fonts.
	 */
	public function getStandardFonts() {

		$standard_fonts = [
			'serif'      => [
				'label' => 'Serif',
				'stack' => 'Georgia, Times, "Times New Roman", serif',
			],
			'sans-serif' => [
				'label' => 'Sans Serif',
				'stack' => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif',
			],
			'monospace'  => [
				'label' => 'Monospace',
				'stack' => 'Monaco, "Lucida Sans Typewriter", "Lucida Typewriter", "Courier New", Courier, monospace',
			],
		];

		return apply_filters( 'wpbf_fonts_standard_fonts', $standard_fonts );

	}

	/**
	 * Get array of all available Google Fonts.
	 *
	 * @return array All Google Fonts.
	 */
	public function getGoogleFonts() {

		if ( ! empty( FontsStore::$google_fonts ) ) {
			return FontsStore::$google_fonts;
		}

		return FontsStore::$google_fonts;

	}

	/**
	 * Get all fonts.
	 *
	 * @return array Merged array of standard fonts and Google Fonts.
	 */
	public function getAllFonts() {

		$all_fonts = array_merge( $this->getStandardFonts(), $this->getGoogleFonts() );

		return apply_filters( 'wpbf_all_fonts', $all_fonts );

	}

	/**
	 * Check if a font family is a Google Font.
	 *
	 * @param string $font_family Font family to check.
	 * @return bool
	 */
	public function isGoogleFont( $font_family ) {

		if ( ! is_string( $font_family ) ) {
			return false;
		}

		return isset( FontsStore::$google_fonts[ $font_family ] );

	}

	/**
	 * Get standard font variants.
	 *
	 * @return array Array of 'variant' => 'label' pairs. E.g: `[ '700italic' => '700 Italic' ]`.
	 */
	public function getStandardVariants() {

		return FontsStore::$standard_font_variants;

	}

	/**
	 * Get array of value & label pairs from standard font variants.
	 *
	 * Can be used for select fields.
	 *
	 * @return array Array of value & label pairs from standard font variants.
	 */
	public function getStandardVariantOptions() {

		return FontsStore::$standard_font_variant_options;

	}

	/**
	 * Get complete font variants.
	 *
	 * @return array Array of 'variant' => 'label' pairs. E.g: `[ '300italic' => '300 Italic' ]`.
	 */
	public function getCompleteVariants() {

		return FontsStore::$complete_font_variants;

	}

	/**
	 * Get array of value & label pairs from complete font variants.
	 *
	 * Can be used for select fields.
	 *
	 * @return array Array of value & label pairs from complete font variants.
	 */
	public function getCompleteVariantOptions() {

		return FontsStore::$complete_font_variant_options;

	}

}
