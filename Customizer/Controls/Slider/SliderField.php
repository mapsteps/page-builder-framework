<?php
/**
 * Slider field.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Slider;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use WP_Customize_Manager;

/**
 * The field of the three slider types: slider, input-slider and responsive-input-slider.
 */
class SliderField extends BaseField {

	/**
	 * Setting's sanitize callback.
	 *
	 * @param mixed $value The value to sanitize.
	 *
	 * @return int|float|string|array
	 */
	public function sanitizeCallback( $value ) {

		return ( new SliderValue( $this->control->type, $this->control->custom_properties ) )->clean( $value );

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args         = $this->parseControlArgs();
		$control_args['type'] = 'wpbf-' . $this->control->type;

		$wp_customize_manager->add_control( new SliderControl( $wp_customize_manager, $this->control->id, $control_args ) );

	}

}
