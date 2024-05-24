<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Slider;

class ResponsiveInputSliderField extends InputSliderField {

	/**
	 * Get control's allowed devices.
	 *
	 * @return array
	 */
	protected function devices() {

		$props = $this->control->custom_properties;

		if ( ! empty( $props['devices'] ) && is_array( $props['devices'] ) ) {
			$devices = $props['devices'];
		} else {
			$devices = ResponsiveInputSliderControl::$default_devices;
		}

		return $devices;

	}

	/**
	 * Setting's sanitize callback.
	 *
	 * @param array|string $value The value to sanitize.
	 *
	 * @return array
	 */
	public function sanitizeCallback( $value ) {

		$props = $this->control->custom_properties;

		$save_as_json = false;

		if ( ! empty( $props['save_as_json'] ) && is_bool( $props['save_as_json'] ) ) {
			$save_as_json = true;
		}

		$devices = $this->devices();

		$min = $this->min();
		$max = $this->max();

		if ( $min > $max ) {
			$max = $min;
		}

		$responsive_util = new ResponsiveInputSliderUtil();

		$array_value = $responsive_util->toArrayValue( $devices, $value, $min, $max );

		return $save_as_json ? wp_json_encode( $array_value ) : $array_value;

	}

	/**
	 * Init control instance.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 * @param string               $control_id           The control ID.
	 * @param array                $control_args         The control arguments.
	 *
	 * @return ResponsiveInputSliderControl
	 */
	protected function initControlInstance( $wp_customize_manager, $control_id, $control_args ) {

		if ( ! isset( $control_args['wrapper_attrs'] ) ) {
			$control_args['wrapper_attrs'] = [];
		}

		if ( empty( $control_args['wrapper_attrs']['class'] ) ) {
			$control_args['wrapper_attrs']['class'] = '{default_class} wpbf-customize-control-responsive';
		} else {
			$control_args['wrapper_attrs']['class'] .= ' wpbf-customize-control-responsive';
		}

		$control_args['save_as_json'] = ! empty( $control_args['save_as_json'] ) && is_bool( $control_args['save_as_json'] ) ? true : false;
		$control_args['devices']      = ! empty( $control_args['devices'] ) && is_array( $control_args['devices'] ) ? $control_args['devices'] : [];

		return new ResponsiveInputSliderControl( $wp_customize_manager, $control_id, $control_args );

	}

}
