<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Typography;

use Mapsteps\Wpbf\Customizer\Controls\Typography\Entities\GoogleFontEntity;

final class GoogleFontsUtil {

	/**
	 * The available sorting modes.
	 *
	 * @var string[]
	 */
	public $available_sortby_modes = [ 'alpha', 'popularity', 'trending' ];

	/**
	 * The default sorting mode.
	 *
	 * @var string
	 */
	public $default_sortby_mode = 'alpha';

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
	 * Get font family names filtered by order by and count.
	 *
	 * @param string|null $sort_by Accepts 'alpha', 'popularity', or 'trending' as the value.
	 * @param int|null    $count Total result to return.
	 *
	 * @return string[]
	 */
	public function getFilteredFontNames( $sort_by = null, $count = null ) {

		$sort_by = ! is_string( $sort_by ) || empty( $sort_by ) ? $this->default_sortby_mode : $sort_by;
		$sort_by = ! in_array( $sort_by, $this->available_sortby_modes, true ) ? $this->default_sortby_mode : $sort_by;

		$count = ! is_int( $count ) || empty( $count ) || $count < 1 ? null : $count;

		$cache_name = 'wpbf_googlefonts';

		if ( ! is_null( $sort_by ) ) {
			$cache_name .= '_sort_by_' . $sort_by;
		}

		if ( ! is_null( $count ) ) {
			$cache_name .= '_count_' . $count;
		}

		$cache_name .= '_cache';

		$cached_font_names = get_site_transient( $cache_name );

		if ( $cached_font_names && is_array( $cached_font_names ) ) {
			return $cached_font_names;
		}

		$cache_util = new GoogleFontsCache();

		$data = $cache_util->readFromJson( $cache_util->webfonts_json_filepath );

		/**
		 * The ordered Google Font's font family names.
		 *
		 * @var string[] $ordered_font_names
		 */
		$ordered_font_names = isset( $data['order'] ) && isset( $data['order'][ $sort_by ] ) && is_array( $data['order'][ $sort_by ] )
			? $data['order'][ $sort_by ]
			: [];

		if ( ! is_null( $count ) ) {
			$ordered_font_names = array_slice( $ordered_font_names, 0, $count );
			set_site_transient( $cache_name, $ordered_font_names, $cache_util->cacheDuration() );
			return $ordered_font_names;
		}

		set_site_transient( $cache_name, $ordered_font_names, $cache_util->cacheDuration() );
		return $ordered_font_names;

	}

}
