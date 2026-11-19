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

		return ( new SliderValue( $this->control->type, $this->withChoicesLimits( $this->control->custom_properties ) ) )->clean( $value );

	}

	/**
	 * The slider's limits may also be given Kirki's way, in `choices` (Premium does for two sliders):
	 * `min`, `max` and `step` from there count when the properties don't have them.
	 *
	 * @param array $args The field's properties (or control arguments).
	 *
	 * @return array
	 */
	protected function withChoicesLimits( $args ) {

		$args    = is_array( $args ) ? $args : array();
		$choices = $this->control->choices;

		if ( ! is_array( $choices ) ) {
			return $args;
		}

		foreach ( array( 'min', 'max', 'step' ) as $key ) {
			if ( ! isset( $args[ $key ] ) && isset( $choices[ $key ] ) ) {
				$args[ $key ] = $choices[ $key ];
			}
		}

		return $args;

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args         = $this->withChoicesLimits( $this->parseControlArgs() );
		$control_args['type'] = 'wpbf-' . $this->control->type;

		$wp_customize_manager->add_control( new SliderControl( $wp_customize_manager, $this->control->id, $control_args ) );

	}

}
