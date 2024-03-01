<?php
/**
 * Slider field's default settings.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Slider;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use WP_Customize_Manager;

/**
 * Default settings for the slider field.
 */
class SliderField extends BaseField {

	/**
	 * Setting's sanitize callback.
	 *
	 * @param string $value The value to sanitize.
	 *
	 * @return float
	 */
	public function sanitizeCallback( $value ) {

		return filter_var( $value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$slider_control = new SliderControl(
			$wp_customize_manager,
			$this->control->id,
			$control_args
		);

		$props = $this->control->custom_properties;

		if ( isset( $props['min'] ) ) {
			$slider_control->min = $props['min'];
		}

		if ( isset( $props['max'] ) ) {
			$slider_control->max = $props['max'];
		}

		if ( isset( $props['step'] ) ) {
			$slider_control->step = $props['step'];
		}

		$wp_customize_manager->add_control( $slider_control );

	}

}
