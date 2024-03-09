<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Slider;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use Mapsteps\Wpbf\Customizer\Controls\Generic\NumberUtil;

class InputSliderField extends BaseField {

	/**
	 * Setting's sanitize callback.
	 *
	 * @param string|int|float $value The value to sanitize.
	 *
	 * @return string|int|float
	 */
	public function sanitizeCallback( $value ) {

		$number_util = new NumberUtil();

		$props = $this->control->custom_properties;

		if ( isset( $props['min'] ) ) {
			$min = $number_util->makeSureValueIsNumber( $props['min'] );
		} else {
			$min = InputSliderControl::$default_min;
		}

		if ( isset( $args['max'] ) ) {
			$max = $number_util->makeSureValueIsNumber( $args['max'] );
		} else {
			$max = InputSliderControl::$default_max;
		}

		if ( $min > $max ) {
			$max = $min;
		}

		return $number_util->limitNumberWithUnit( $value, $min, $max );

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$wp_customize_manager->add_control( new InputSliderControl(
			$wp_customize_manager,
			$this->control->id,
			$control_args
		) );

	}

}
