<?php
/**
 * Control slider.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Slider;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;
use Mapsteps\Wpbf\Customizer\Controls\Generic\NumberUtil;
use WP_Customize_Manager;
use WP_Customize_Setting;

/**
 * Class to add Wpbf customizer slider control.
 */
class SliderControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-slider';

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

		if ( isset( $args['min'] ) && is_numeric( $args['min'] ) ) {
			$this->min = (float) $args['min'];
		} else {
			$this->min = static::$default_min;
		}

		if ( isset( $args['max'] ) && is_numeric( $args['max'] ) ) {
			$this->max = (float) $args['max'];
		} else {
			$this->max = static::$default_max;
		}

		if ( $this->min > $this->max ) {
			$this->max = $this->min;
		}

		if ( isset( $args['step'] ) && is_numeric( $args['step'] ) ) {
			$this->step = (float) $args['step'];
		}

		if ( $this->setting instanceof WP_Customize_Setting ) {
			$default_value = $this->setting->default;

			$this->setting->default = ( new NumberUtil() )->limitNumber( $default_value, $this->min, $this->max );
		}

	}

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		parent::enqueue();

		// Enqueue the styles.
		wp_enqueue_style( 'wpbf-slider-control', WPBF_THEME_URI . '/Customizer/Controls/Slider/dist/slider-control-min.css', array(), WPBF_VERSION );

		// Enqueue the scripts.
		wp_enqueue_script(
			'wpbf-slider-control',
			WPBF_THEME_URI . '/Customizer/Controls/Slider/dist/slider-control-min.js',
			array( 'wpbf-base-control' ),
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

		$this->json['min']   = $this->min;
		$this->json['max']   = $this->max;
		$this->json['step']  = $this->step;
		$this->json['value'] = ( new NumberUtil() )->limitNumber( $this->value(), $this->min, $this->max );

	}

}
