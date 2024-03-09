<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Slider;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;
use Mapsteps\Wpbf\Customizer\Controls\Generic\NumberUtil;
use WP_Customize_Manager;
use WP_Customize_Setting;

class InputSliderControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-input-slider';

	/**
	 * Default minimum value.
	 *
	 * @var int
	 */
	public static $default_min = 0;

	/**
	 * Minimum value.
	 *
	 * @var int|float
	 */
	public $min;

	/**
	 * Default maximum value.
	 *
	 * @var int
	 */
	public static $default_max = 100;

	/**
	 * Maximum value.
	 *
	 * @var int|float
	 */
	public $max;

	/**
	 * Step value.
	 *
	 * @var int|float
	 */
	public $step = 1;

	/**
	 * Unit of the value.
	 *
	 * @var string
	 */
	public $value_unit = '';

	/**
	 * The value without number. Empty string is allowed.
	 *
	 * @var int|float|string
	 */
	public $value_number = 0;

	/**
	 * Constructor.
	 *
	 * Supplied `$args` override class property defaults.
	 *
	 * If `$args['settings']` is not defined, use the `$id` as the setting ID.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager Customizer bootstrap instance.
	 * @param string               $id                   Control ID.
	 * @param array                $args                 Optional. Array of properties for the new Control object.
	 *                                                   Default empty array.
	 */
	public function __construct( $wp_customize_manager, $id, $args = array() ) {

		parent::__construct( $wp_customize_manager, $id, $args );

		$number_util = new NumberUtil();

		if ( isset( $args['min'] ) ) {
			$this->min = $number_util->makeSureValueWithOrWithoutUnit( $args['min'] );
		} else {
			$this->min = static::$default_min;
		}

		if ( isset( $args['max'] ) ) {
			$this->max = $number_util->makeSureValueWithOrWithoutUnit( $args['max'] );
		} else {
			$this->max = static::$default_max;
		}

		$min_number_and_unit = $number_util->separateNumberAndUnit( $this->min );
		$min_number          = $min_number_and_unit['number'];

		$max_number_and_unit = $number_util->separateNumberAndUnit( $this->max );
		$max_number          = $max_number_and_unit['number'];
		$max_unit            = $max_number_and_unit['unit'];

		if ( $min_number > $max_number ) {
			$max_number = $min_number;
			$new_max    = $max_unit ? $max_number . $max_unit : $max_number;

			$this->max = $new_max;
		}

		if ( isset( $args['step'] ) && is_numeric( $args['step'] ) ) {
			$this->step = (float) $args['step'];
		}

		if ( $this->setting instanceof WP_Customize_Setting ) {
			$default_value = $this->setting->default;

			$this->setting->default = $number_util->limitNumberWithUnit( $default_value, $min_number, $max_number );
		}

		$value                = $number_util->limitNumberWithUnit( $this->value(), $min_number, $max_number );
		$value_numer_and_unit = $number_util->separateNumberAndUnit( $value );
		$this->value_number   = $value_numer_and_unit['number'];
		$this->value_unit     = $value_numer_and_unit['unit'];

	}

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		parent::enqueue();

		// Enqueue the styles.
		wp_enqueue_style( 'wpbf-input-slider-control', WPBF_THEME_URI . '/Customizer/Controls/Slider/dist/input-slider-control-min.css', array(), WPBF_VERSION );

		// Enqueue the scripts.
		wp_enqueue_script(
			'wpbf-input-slider-control',
			WPBF_THEME_URI . '/Customizer/Controls/Slider/dist/input-slider-control-min.js',
			array(
				'customize-controls',
				'react-dom',
			),
			WPBF_VERSION,
			false
		);

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {

		// TODO: continue from here.

		parent::to_json();

		if ( isset( $this->json['label'] ) ) {
			$this->json['label'] = html_entity_decode( $this->json['label'] );
		}

		if ( isset( $this->json['description'] ) ) {
			$this->json['description'] = html_entity_decode( $this->json['description'] );
		}

		$this->json['min']  = $this->min;
		$this->json['max']  = $this->max;
		$this->json['step'] = $this->step;

		$this->json['value']        = ! empty( $this->value_unit ) ? $this->value_number . $this->value_unit : $this->value_number;
		$this->json['value_number'] = $this->value_number;
		$this->json['value_unit']   = $this->value_unit;

	}

}
