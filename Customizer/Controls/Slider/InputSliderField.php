<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Slider;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use Mapsteps\Wpbf\Customizer\Controls\Generic\NumberUtil;

class InputSliderField extends BaseField {

	/**
	 * Instance of `NumberUtil`.
	 *
	 * @var NumberUtil
	 */
	protected $number_util;

	/**
	 * Construct the class.
	 *
	 * @param CustomizerControlEntity $control The control entity object.
	 */
	public function __construct( $control ) {

		parent::__construct( $control );

		$this->number_util = new NumberUtil();

	}

	/**
	 * Get control's default minimum value.
	 *
	 * @return string
	 */
	protected function defaultMin() {

		return InputSliderControl::$default_min;

	}

	/**
	 * Get control's default maximum value.
	 *
	 * @return string
	 */
	protected function defaultMax() {

		return InputSliderControl::$default_max;

	}

	/**
	 * Get control's min value.
	 *
	 * @return int
	 */
	protected function min() {

		$props = $this->control->custom_properties;

		if ( isset( $props['min'] ) ) {
			$min = $this->number_util->makeSureValueIsNumber( $props['min'] );
		} else {
			$min = $this->defaultMin();
		}

		return $min;

	}

	/**
	 * Get control's max value.
	 *
	 * @return int
	 */
	protected function max() {

		$props = $this->control->custom_properties;

		if ( isset( $props['max'] ) ) {
			$max = $this->number_util->makeSureValueIsNumber( $props['max'] );
		} else {
			$max = $this->defaultMax();
		}

		return $max;

	}

	/**
	 * Setting's sanitize callback.
	 *
	 * @param string|int|float $value The value to sanitize.
	 *
	 * @return string|int|float
	 */
	public function sanitizeCallback( $value ) {

		return $this->sanitizeValue( $value );

	}

	/**
	 * Sanitize value.
	 *
	 * @param string|int|float $value The value to sanitize.
	 *
	 * @return string|int|float
	 */
	protected function sanitizeValue( $value ) {

		$min = $this->min();
		$max = $this->max();

		if ( $min > $max ) {
			$max = $min;
		}

		return $this->number_util->limitNumberWithUnit( $value, $min, $max );

	}

	/**
	 * Init control instance.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 * @param string               $control_id           The control ID.
	 * @param array                $control_args         The control arguments.
	 *
	 * @return InputSliderControl
	 */
	protected function initControlInstance( $wp_customize_manager, $control_id, $control_args ) {

		return new InputSliderControl( $wp_customize_manager, $control_id, $control_args );

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$wp_customize_manager->add_control( $this->initControlInstance(
			$wp_customize_manager,
			$this->control->id,
			$control_args
		) );

	}

}
