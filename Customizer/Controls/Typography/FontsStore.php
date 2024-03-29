<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Typography;

final class FontsStore {

	/**
	 * Whether the data has been initialized.
	 *
	 * @var bool
	 */
	private static $initialized = false;

	/**
	 * Standard font variants.
	 *
	 * @var array
	 */
	public static $standard_font_variants = [];

	/**
	 * Array of value & label pairs from standard font variants.
	 *
	 * Can be used for select fields.
	 *
	 * @var array
	 */
	public static $standard_font_variant_options = [];

	/**
	 * Complete font variants.
	 *
	 * @var array
	 */
	public static $complete_font_variants = [];

	/**
	 * Array of value & label pairs from complete font variants.
	 *
	 * Can be used for select fields.
	 *
	 * @var array
	 */
	public static $complete_font_variant_options = [];

	/**
	 * An assoc array with font-family as the key and `GoogleFontEntity` instance as the value.
	 *
	 * @var array
	 */
	public static $google_fonts;

	/**
	 * An array of all Google Font names.
	 *
	 * @var array
	 */
	public static $google_font_names;

	/**
	 * Check if the data has been initialized.
	 *
	 * @return bool
	 */
	public static function initialized() {

		return self::$initialized;

	}

	/**
	 * Initialize the store data.
	 *
	 * For performance reason, this should only be executed once per application runtime.
	 *
	 * If you need to add some filters related to wpbf fonts or google fonts,
	 * please add it outside of (before) `customize_register` hook.
	 */
	public static function init() {

		if ( self::$initialized ) {
			return;
		}

		self::$standard_font_variants = array(
			'regular'   => __( 'Regular', 'page-builder-framework' ),
			'italic'    => __( 'Italic', 'page-builder-framework' ),
			'700'       => __( '700', 'page-builder-framework' ),
			'700italic' => __( '700 Italic', 'page-builder-framework' ),
		);

		foreach ( self::$standard_font_variants as $variant_key => $variant_label ) {
			self::$standard_font_variant_options[] = [
				'value' => (string) $variant_key,
				'label' => $variant_label,
			];
		}

		self::$complete_font_variants = array(
			'regular'   => __( 'Regular', 'page-builder-framework' ),
			'italic'    => __( 'Italic', 'page-builder-framework' ),
			'100'       => __( '100', 'page-builder-framework' ),
			'100italic' => __( '100 Italic', 'page-builder-framework' ),
			'200'       => __( '200', 'page-builder-framework' ),
			'200italic' => __( '200 Italic', 'page-builder-framework' ),
			'300'       => __( '300', 'page-builder-framework' ),
			'300italic' => __( '300 Italic', 'page-builder-framework' ),
			'500'       => __( '500', 'page-builder-framework' ),
			'500italic' => __( '500 Italic', 'page-builder-framework' ),
			'600'       => __( '600', 'page-builder-framework' ),
			'600italic' => __( '600 Italic', 'page-builder-framework' ),
			'700'       => __( '700', 'page-builder-framework' ),
			'700italic' => __( '700 Italic', 'page-builder-framework' ),
			'800'       => __( '800', 'page-builder-framework' ),
			'800italic' => __( '800 Italic', 'page-builder-framework' ),
			'900'       => __( '900', 'page-builder-framework' ),
			'900italic' => __( '900 Italic', 'page-builder-framework' ),
		);

		foreach ( self::$complete_font_variants as $variant_key => $variant_label ) {
			self::$complete_font_variant_options[] = [
				'value' => (string) $variant_key,
				'label' => $variant_label,
			];
		}

		( new GoogleFontsCache() )->initCaches();

		self::$initialized = true;

	}

}
