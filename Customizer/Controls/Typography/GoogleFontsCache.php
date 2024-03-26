<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Typography;

use Mapsteps\Wpbf\Customizer\Controls\Typography\Entities\GoogleFontEntity;

final class GoogleFontsCache {

	/**
	 * The path to the 'webfonts.json' file.
	 *
	 * @var string
	 */
	public $webfonts_json_filepath;

	/**
	 * The path to the 'webfont-names.json' file.
	 *
	 * @var string
	 */
	public $webfont_names_json_filepath;

	/**
	 * The path to the 'webfont-files.json' file.
	 *
	 * @var string
	 */
	public $webfont_files_json_filepath;

	/**
	 * `GoogleFontsCache` constructor.
	 */
	public function __construct() {

		$this->webfonts_json_filepath = __DIR__ . '/dist/webfonts.json';

		$this->webfont_names_json_filepath = __DIR__ . '/dist/webfont-names.json';

		$this->webfont_files_json_filepath = __DIR__ . '/dist/webfont-files.json';

	}

	/**
	 * Decode the JSON file content and return as array.
	 *
	 * @param string $json_filepath The path of the JSON file to read.
	 * @return array
	 */
	public function readFromJson( $json_filepath ) {

		$fonts = [];

		if ( file_exists( $json_filepath ) ) {
			$json = file_get_contents( $json_filepath );

			if ( ! $json ) {
				return $fonts;
			}

			$decoded = json_decode( $json, true );

			if ( ! $decoded || ! is_array( $decoded ) ) {
				return $fonts;
			}

			$fonts = $decoded;
		}

		return $fonts;

	}

	/**
	 * Get the caching duration.
	 *
	 * @return int
	 */
	public function cacheDuration() {

		return apply_filters( 'wpbf_googlefonts_transient_time', HOUR_IN_SECONDS );

	}

	/**
	 * Init Google Fonts related caches.
	 *
	 * For performance reason, this should only be executed once per application runtime.
	 */
	public function initCaches() {

		$cached_google_fonts_array = get_site_transient( 'wpbf_googlefonts_cache' );

		if ( ! empty( $cached_google_fonts_array ) ) {
			FontsStore::$google_fonts = $this->makeEntities( $cached_google_fonts_array, true );
		} else {
			$this->cacheFonts();
		}

		$cached_google_font_names = get_site_transient( 'wpbf_googlefont_names_cache' );

		if ( ! empty( $cached_google_font_names ) ) {
			FontsStore::$google_font_names = $cached_google_font_names;
		} else {
			$this->cacheFontNames();
		}

	}

	/**
	 * Cache Google Font families.
	 */
	public function cacheFonts() {

		$raw_array = $this->readFromJson( $this->webfonts_json_filepath );
		$raw_items = $raw_array['items'];

		// Save the array in cache.
		set_site_transient( 'wpbf_googlefonts_cache', $raw_items, $this->cacheDuration() );

		// Set the Google Fonts collection store.
		FontsStore::$google_fonts = $this->makeEntities( $raw_items, true );

	}

	/**
	 * Cache all Google Font's font-family names.
	 */
	public function cacheFontNames() {

		$font_names = $this->readFromJson( $this->webfont_names_json_filepath );

		if ( ! is_array( $font_names ) || empty( $font_names ) ) {
			return;
		}

		// Apply the 'wpbf_fonts_google_font_names' filter.
		$font_names = apply_filters( 'wpbf_fonts_google_font_names', $font_names );

		// Save the array in cache.
		set_site_transient( 'wpbf_googlefont_names_cache', $font_names, $this->cacheDuration() );

		// Set the Google Font's font-family names store.
		FontsStore::$google_font_names = $font_names;

	}

	/**
	 * Create array of 'font family' => `GoogleFontEntity` pairs.
	 *
	 * @param array $raw_items Array of Google Fonts data. Each data is an associative array with the following keys: 'family', 'category', and 'variants'.
	 * @param bool  $apply_filters Whether to apply the 'wpbf_fonts_google_fonts' filter.
	 *
	 * @return array An assoc array with font family as the key and `GoogleFontEntity` instance as the value.
	 */
	private function makeEntities( $raw_items, $apply_filters = false ) {

		if ( ! is_array( $raw_items ) ) {
			return;
		}

		if ( $apply_filters ) {
			// Apply the 'wpbf_fonts_google_fonts' filter.
			$raw_items = apply_filters( 'wpbf_fonts_google_fonts', $raw_items );
		}

		$google_fonts = [];

		foreach ( $raw_items as $font_family => $font_data ) {
			$google_fonts[ $font_family ] = GoogleFontEntity::fromArray( $font_data );
		}

		return $google_fonts;

	}

}
