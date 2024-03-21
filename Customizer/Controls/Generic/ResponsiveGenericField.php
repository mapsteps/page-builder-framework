<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Generic;

use Mapsteps\Wpbf\Customizer\Controls\Responsive\ResponsiveUtil;

class ResponsiveGenericField extends GenericField {

	/**
	 * Setting's sanitize callback.
	 *
	 * @param array|string $value The value to sanitize.
	 *
	 * @return array|string
	 */
	public function sanitizeCallback( $value ) {

		$responsive_util = new ResponsiveUtil();

		$props = $this->control->custom_properties;

		if ( ! empty( $props['devices'] ) && is_array( $props['devices'] ) ) {
			$devices = $props['devices'];
		} else {
			$devices = $responsive_util->default_devices;
		}

		$save_as_json = false;

		if ( ! empty( $props['save_as_json'] ) && is_bool( $props['save_as_json'] ) ) {
			$save_as_json = true;
		}

		$subtype = $this->control->type;
		$subtype = ! in_array( $subtype, ResponsiveGenericControl::$allowed_subtypes, true ) ? 'text' : $subtype;

		$min = isset( $props['min'] ) && is_numeric( $props['min'] ) ? (float) $props['min'] : null;
		$max = isset( $props['max'] ) && is_numeric( $props['max'] ) ? (float) $props['max'] : null;

		$array_value = $responsive_util->toArrayValue( $devices, $subtype, $value, $min, $max );

		return $save_as_json ? wp_json_encode( $array_value ) : $array_value;

	}

	/**
	 * Init control instance.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 * @param string               $control_id           The control ID.
	 * @param array                $control_args         The control arguments.
	 *
	 * @return ResponsiveGenericControl
	 */
	protected function initControlInstance( $wp_customize_manager, $control_id, $control_args ) {

		return new ResponsiveGenericControl( $wp_customize_manager, $control_id, $control_args );

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$control_args['subtype'] = str_ireplace( 'responsive-', '', $this->control->type );

		$props = $this->control->custom_properties;

		if ( ! empty( $props['save_as_json'] ) && is_bool( $props['save_as_json'] ) ) {
			$control_args['save_as_json'] = true;
		}

		if ( ! empty( $props['devices'] ) && is_array( $props['devices'] ) ) {
			$control_args['devices'] = $props['devices'];
		}

		$wp_customize_manager->add_control( new ResponsiveGenericControl(
			$wp_customize_manager,
			$this->control->id,
			$control_args
		) );

	}

}
