<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Generic;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use WP_Customize_Manager;

class GenericField extends BaseField {

	/**
	 * Setting's sanitize callback.
	 *
	 * @param string $value The value to sanitize.
	 *
	 * @return string|int|float
	 */
	public function sanitizeCallback( $value ) {

		$props = $this->control->custom_properties;

		$subtype = $this->control->type;
		$subtype = ! in_array( $subtype, GenericControl::$allowed_subtypes, true ) ? 'text' : $subtype;

		$min = isset( $props['min'] ) && is_numeric( $props['min'] ) ? (float) $props['min'] : null;
		$max = isset( $props['max'] ) && is_numeric( $props['max'] ) ? (float) $props['max'] : null;

		return ( new GenericSanitizer() )->sanitize( $subtype, $value, $min, $max );

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$control_args['subtype'] = $this->control->type;

		$wp_customize_manager->add_control( new GenericControl(
			$wp_customize_manager,
			$this->control->id,
			$control_args
		) );

	}

}
