<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Typography;

use Mapsteps\Wpbf\Customizer\Controls\Typography\Entities\GoogleFontEntity;
use Mapsteps\Wpbf\Customizer\Controls\Typography\Entities\GoogleFontsData;

final class GoogleFontsUtil {

	/**
	 * The available sorting modes.
	 *
	 * @var string[]
	 */
	private $available_sorting_modes = [ 'alpha', 'popularity', 'trending' ];

	/**
	 * The default sorting mode.
	 *
	 * @var string
	 */
	private $default_sorting_mode = 'alpha';

	/**
	 * The path to the 'webfonts.json' file.
	 *
	 * @var string
	 */
	private $webfonts_json_filepath;

	/**
	 * The path to the 'webfont-names.json' file.
	 *
	 * @var string
	 */
	private $webfont_names_json_filepath;

	/**
	 * The path to the 'webfont-files.json' file.
	 *
	 * @var string
	 */
	private $webfont_files_json_filepath;

	/**
	 * `GoogleFontsUtil` constructor.
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
	private function readFromJson( $json_filepath ) {

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
	private function cacheDuration() {

		return apply_filters( 'wpbf_googlefonts_transient_time', HOUR_IN_SECONDS );

	}

	/**
	 * Init Google Fonts related caches.
	 */
	public function initCaches() {

		$cached_google_fonts_array = get_site_transient( 'wpbf_googlefonts_cache' );

		if ( ! empty( $cached_google_fonts_array ) ) {
			TypographyStore::$google_fonts = $this->makeFontsCollection( $cached_google_fonts_array, true );
		} else {
			$this->cacheFonts();
		}

		$cached_google_font_names = get_site_transient( 'wpbf_googlefont_names_cache' );

		if ( ! empty( $cached_google_font_names ) ) {
			TypographyStore::$google_font_names = $cached_google_font_names;
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
		TypographyStore::$google_fonts = $this->makeFontsCollection( $raw_items, true );

	}

	/**
	 * Create Google Fonts collection.
	 *
	 * @param array $raw_items Array of Google Fonts data. Each data is an associative array with the following keys: 'family', 'category', and 'variants'.
	 * @param bool  $apply_filters Whether to apply the 'wpbf_fonts_google_fonts' filter.
	 *
	 * @return array An assoc array with font family as the key and `GoogleFontEntity` instance as the value.
	 */
	public function makeFontsCollection( $raw_items, $apply_filters = false ) {

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

	/**
	 * Cache all Google Font's font-family names.
	 */
	public function cacheFontNames() {

		$font_names = $this->readFromJson( $this->webfonts_json_filepath );

		if ( ! is_array( $font_names ) || empty( $font_names ) ) {
			return;
		}

		// Apply the 'wpbf_fonts_google_font_names' filter.
		$font_names = apply_filters( 'wpbf_fonts_google_font_names', $font_names );

		// Save the array in cache.
		set_site_transient( 'wpbf_googlefont_names_cache', $font_names, $this->cacheDuration() );

		// Set the Google Font's font-family names store.
		TypographyStore::$google_font_names = $font_names;

	}

	/**
	 * Get font family names by arguments.
	 *
	 * @param array $args The arguments.
	 * @return string[]
	 */
	public function getFontNamesByArgs( $args = [] ) {

		$cache_name    = 'wpbf_googlefonts_' . md5( wp_json_encode( $args ) );
		$cached_result = get_site_transient( $cache_name );

		if ( $cached_result && is_array( $cached_result ) ) {
			return $this->makeFontsCollection( $cached_result );
		}

		$sort_by = ! empty( $args['sort'] ) && is_string( $args['sort'] ) ? $args['sort'] : $this->default_sorting_mode;
		$sort_by = ! in_array( $sort_by, $this->available_sorting_modes, true ) ? $this->default_sorting_mode : $sort_by;

		$count = ! empty( $args['count'] ) && is_int( $args['count'] ) ? $args['count'] : null;
		$count = is_null( $count ) || $count < 1 ? null : absint( $count );

		if ( ! isset( $args['sort'] ) ) {
			$args['sort'] = 'alpha';
		}

		$data = GoogleFontsData::fromArray(
			$this->readFromJson( $this->webfonts_json_filepath )
		);

		/**
		 * The ordered font families.
		 *
		 * @var string[] $ordered_font_families
		 */
		$ordered_font_families = property_exists( $data, $sort_by ) ? $data->{$sort_by} : [];

		if ( ! is_null( $count ) ) {
			$ordered_font_families = array_slice( $ordered_font_families, 0, $count );
			set_site_transient( $cache_name, $ordered_font_families, $this->cacheDuration() );
			return $ordered_font_families;
		}

		set_site_transient( $cache_name, $ordered_font_families, $this->cacheDuration() );
		return $ordered_font_families;

	}

}
