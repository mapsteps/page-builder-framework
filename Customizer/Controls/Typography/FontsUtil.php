<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Typography;

use WP_Error;
use WP_Filesystem_Direct;

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

	/**
	 * Slugify the font-family name to be used as a directory name and part of option name.
	 *
	 * @param string $font_family The font-family name.
	 *
	 * @return string
	 */
	public function slugifyFontFamily( $font_family = '' ) {

		if ( empty( $font_family ) ) {
			return '';
		}

		$font_family = trim( str_replace( array( "'", ';' ), '', $font_family ) );
		$font_family = sanitize_key( strtolower( str_replace( ' ', '-', $font_family ) ) );

		return $font_family;

	}

	/**
	 * Get array of downloaded Google Fonts CSS.
	 *
	 * @return array Array of downloaded Google Fonts CSS.
	 */
	public function getDownloadedGoogleFontsCss() {

		$downloaded_css = get_option( 'wpbf_downloaded_google_fonts_css', array() );
		$downloaded_css = ! empty( $downloaded_css ) && is_array( $downloaded_css ) ? $downloaded_css : [];

		return $downloaded_css;

	}

	/**
	 * Clear downloaded Google Fonts.
	 *
	 * @return true|WP_Error
	 */
	public function clearDownloadedGoogleFonts() {

		include_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
		include_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';

		$file_system = new WP_Filesystem_Direct( false );
		$fonts_dir   = WP_CONTENT_DIR . '/fonts';

		if ( ! is_dir( $fonts_dir ) ) {
			return new WP_Error( 'no_local_fonts', __( 'No local fonts found.', 'page-builder-framework' ) );
		}

		$file_system->rmdir( $fonts_dir, true );

		delete_option( 'wpbf_downloaded_google_fonts' );
		delete_option( 'wpbf_downloaded_google_fonts_css' );

		// This option is not being used anymore.
		delete_option( 'wpbf_downloaded_google_fonts_stylesheet' );

		return true;

	}

}
