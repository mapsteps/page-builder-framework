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
			$min = $number_util->makeSureValueWithOrWithoutUnit( $props['min'] );
		} else {
			$min = InputSliderControl::$default_min;
		}

		if ( isset( $args['max'] ) ) {
			$max = $number_util->makeSureValueWithOrWithoutUnit( $args['max'] );
		} else {
			$max = InputSliderControl::$default_max;
		}

		$min_number_and_unit = $number_util->separateNumberAndUnit( $min );
		$min_number          = $min_number_and_unit['number'];

		$max_number_and_unit = $number_util->separateNumberAndUnit( $max );
		$max_number          = $max_number_and_unit['number'];
		$max_unit            = $max_number_and_unit['unit'];

		if ( $min_number > $max_number ) {
			$max_number = $min_number;
			$new_max    = $max_unit ? $max_number . $max_unit : $max_number;

			$max = $new_max;
		}

		return $number_util->limitNumberWithUnit( $value, $min_number, $max_number );

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
