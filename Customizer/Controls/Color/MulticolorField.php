<?php
/**
 * Color field's default settings.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Color;

/**
 * Default settings for the color field.
 */
class MulticolorField extends ColorField {

	/**
	 * Setting's sanitize callback.
	 *
	 * @param array $values The multicolor values.
	 *
	 * @return array
	 */
	public function sanitizeCallback( $values ) {

		if ( empty( $values ) || ! is_array( $values ) ) {
			return [];
		}

		$sanitized_values = [];

		foreach ( $values as $key => $value ) {
			$sanitized_values[ $key ] = ( new ColorSanitizer() )->sanitize( $value );
		}

		return ( new ColorSanitizer() )->sanitize( $sanitized_values );

	}

	/**
	 * Get the control instance.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 * @param array                $control_args         Optional. Array of properties for the new Control object.
	 *
	 * @return MulticolorControl
	 */
	protected function controlInstance( $wp_customize_manager, $control_args = [] ) {

		return new MulticolorControl(
			$wp_customize_manager,
			$this->control->id,
			$control_args
		);

	}

}
