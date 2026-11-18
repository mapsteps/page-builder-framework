<?php
/**
 * Slider control.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Slider;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;
use WP_Customize_Manager;
use WP_Customize_Setting;

/**
 * One control for the three slider types: wpbf-slider, wpbf-input-slider and wpbf-responsive-input-slider.
 *
 * The type comes from `$args['type']` (default wpbf-slider); the form picks its layout from it (slider-control.tsx).
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
	public static $default_min = SliderValue::DEFAULT_MIN;

	/**
	 * Default maximum value.
	 *
	 * @var int
	 */
	public static $default_max = SliderValue::DEFAULT_MAX;

	/**
	 * Minimum value.
	 *
	 * @var int|float
	 */
	public $min;

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
	 * Limits and stored format of the type.
	 *
	 * @var SliderValue
	 */
	protected $slider_value;

	/**
	 * Constructor.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager Customizer bootstrap instance.
	 * @param string               $id                   Control ID.
	 * @param array                $args                 Control arguments, incl. `type`, `min`, `max`, `step`,
	 *                                                   and for the responsive slider `devices` and `save_as_json`.
	 */
	public function __construct( $wp_customize_manager, $id, $args = array() ) {

		$slider_value = new SliderValue( isset( $args['type'] ) ? $args['type'] : $this->type, $args );

		if ( $slider_value->isResponsive() ) {
			$args['wrapper_attrs'] = $this->responsiveWrapperAttrs( isset( $args['wrapper_attrs'] ) ? $args['wrapper_attrs'] : array() );
		}

		parent::__construct( $wp_customize_manager, $id, $args );

		$this->type         = $slider_value->type;
		$this->slider_value = $slider_value;
		$this->min          = $slider_value->min;
		$this->max          = $slider_value->max;
		$this->step         = $slider_value->step;

		if ( $this->setting instanceof WP_Customize_Setting ) {
			$this->setting->default = $slider_value->clean( $this->setting->default );
		}

	}

	/**
	 * The responsive slider's wrapper classes: the responsive and the input slider styles.
	 *
	 * @param array $wrapper_attrs The wrapper attributes.
	 *
	 * @return array
	 */
	private function responsiveWrapperAttrs( $wrapper_attrs ) {

		$wrapper_attrs = is_array( $wrapper_attrs ) ? $wrapper_attrs : array();
		$existing      = ! empty( $wrapper_attrs['class'] ) ? str_ireplace( '{default_class}', '', $wrapper_attrs['class'] ) : '';

		$wrapper_attrs['class'] = '{default_class} ' . $existing . ' wpbf-customize-control-responsive wpbf-customize-control-input-slider';

		return $wrapper_attrs;

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
		$this->json['value'] = $this->slider_value->clean( $this->value() );

		if ( $this->slider_value->isResponsive() ) {
			$this->json['devices']    = $this->slider_value->devices;
			$this->json['saveAsJson'] = $this->slider_value->save_as_json;
		}

	}

}
