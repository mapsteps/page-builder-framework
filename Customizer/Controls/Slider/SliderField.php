<?php
/**
 * Slider field's default settings.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Slider;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use Mapsteps\Wpbf\Customizer\Controls\Generic\NumberUtil;
use WP_Customize_Manager;

/**
 * Default settings for the slider field.
 */
class SliderField extends BaseField {

	/**
	 * Setting's sanitize callback.
	 *
	 * @param string|int|float $value The value to sanitize.
	 *
	 * @return string|int|float
	 */
	public function sanitizeCallback( $value ) {

		$props = $this->control->custom_properties;
		$min   = isset( $props['min'] ) && is_numeric( $props['min'] ) ? (float) $props['min'] : null;
		$min   = is_null( $min ) ? SliderControl::$default_min : $min;
		$max   = isset( $props['max'] ) && is_numeric( $props['max'] ) ? (float) $props['max'] : null;
		$max   = is_null( $max ) ? SliderControl::$default_max : $max;

		return ( new NumberUtil() )->limitNumber( $value, $min, $max );

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$wp_customize_manager->add_control( new SliderControl(
			$wp_customize_manager,
			$this->control->id,
			$control_args
		) );

	}

}
