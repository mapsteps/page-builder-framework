<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Typography;

class TypographyStore {

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
	 * Complete font variants.
	 *
	 * @var array
	 */
	public static $complete_font_variants = [];

	/**
	 * Complete font variant labels.
	 *
	 * @var array
	 */
	public static $complete_font_variant_labels = [];

	/**
	 * Check if the data has been initialized.
	 *
	 * @return bool
	 */
	public static function initialized() {

		return static::$initialized;

	}

	/**
	 * Initialize the data.
	 */
	public static function init() {

		if ( static::$initialized ) {
			return;
		}

		static::$standard_font_variants = array(
			[
				'value' => 'regular',
				'label' => __( 'Regular', 'page-builder-framework' ),
			],
			[
				'value' => 'italic',
				'label' => __( 'Italic', 'page-builder-framework' ),
			],
			[
				'value' => '700',
				'label' => __( '700', 'page-builder-framework' ),
			],
			[
				'value' => '700italic',
				'label' => __( '700 Italic', 'page-builder-framework' ),
			],
		);

		static::$complete_font_variants = array(
			[
				'value' => 'regular',
				'label' => __( 'Regular', 'page-builder-framework' ),
			],
			[
				'value' => 'italic',
				'label' => __( 'Italic', 'page-builder-framework' ),
			],
			[
				'value' => '100',
				'label' => __( '100', 'page-builder-framework' ),
			],
			[
				'value' => '100italic',
				'label' => __( '100 Italic', 'page-builder-framework' ),
			],
			[
				'value' => '200',
				'label' => __( '200', 'page-builder-framework' ),
			],
			[
				'value' => '200italic',
				'label' => __( '200 Italic', 'page-builder-framework' ),
			],
			[
				'value' => '300',
				'label' => __( '300', 'page-builder-framework' ),
			],
			[
				'value' => '300italic',
				'label' => __( '300 Italic', 'page-builder-framework' ),
			],
			[
				'value' => '500',
				'label' => __( '500', 'page-builder-framework' ),
			],
			[
				'value' => '500italic',
				'label' => __( '500 Italic', 'page-builder-framework' ),
			],
			[
				'value' => '600',
				'label' => __( '600', 'page-builder-framework' ),
			],
			[
				'value' => '600italic',
				'label' => __( '600 Italic', 'page-builder-framework' ),
			],
			[
				'value' => '700',
				'label' => __( '700', 'page-builder-framework' ),
			],
			[
				'value' => '700italic',
				'label' => __( '700 Italic', 'page-builder-framework' ),
			],
			[
				'value' => '800',
				'label' => __( '800', 'page-builder-framework' ),
			],
			[
				'value' => '800italic',
				'label' => __( '800 Italic', 'page-builder-framework' ),
			],
			[
				'value' => '900',
				'label' => __( '900', 'page-builder-framework' ),
			],
			[
				'value' => '900italic',
				'label' => __( '900 Italic', 'page-builder-framework' ),
			],
		);

		foreach ( static::$complete_font_variants as $font_variants ) {
			static::$complete_font_variant_labels[ $font_variants['value'] ] = $font_variants['label'];
		}

		static::$initialized = true;

	}

}
