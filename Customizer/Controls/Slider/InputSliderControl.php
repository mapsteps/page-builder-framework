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
	protected $min;

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
	protected $max;

	/**
	 * Step value.
	 *
	 * @var int|float
	 */
	protected $step = 1;

	/**
	 * Number utility.
	 *
	 * @var NumberUtil
	 */
	protected $number_util;

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

		$this->number_util = new NumberUtil();

		parent::__construct( $wp_customize_manager, $id, $args );

		if ( isset( $args['min'] ) ) {
			$this->min = $this->number_util->makeSureValueIsNumber( $args['min'] );
		} else {
			$this->min = static::$default_min;
		}

		if ( isset( $args['max'] ) ) {
			$this->max = $this->number_util->makeSureValueIsNumber( $args['max'] );
		} else {
			$this->max = static::$default_max;
		}

		if ( $this->min > $this->max ) {
			$this->max = $this->min;
		}

		if ( isset( $args['step'] ) && is_numeric( $args['step'] ) ) {
			$this->step = (float) $args['step'];
		}

		$this->constructDefaultValue( $args );

	}

	/**
	 * Construct the default value.
	 *
	 * @param array $args The control arguments.
	 */
	protected function constructDefaultValue( $args ) {

		if ( $this->setting instanceof WP_Customize_Setting ) {
			$default_value = $this->setting->default;

			$this->setting->default = $this->number_util->limitNumberWithUnit( $default_value, $this->min, $this->max );
		}

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

		$this->setValueToJson();

	}

	/**
	 * Set the value to JSON.
	 */
	protected function setValueToJson() {

		$value = $this->number_util->limitNumberWithUnit( $this->value(), $this->min, $this->max );

		$this->json['value'] = $value;

	}

}
