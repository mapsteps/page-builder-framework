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

		$props = $this->control->custom_properties;

		if ( ! empty( $props['save_as_json'] ) && is_bool( $props['save_as_json'] ) ) {
			$control_args['save_as_json'] = true;
		}

		if ( ! empty( $props['devices'] ) && is_array( $props['devices'] ) ) {
			$control_args['devices'] = $props['devices'];
		}

		return new ResponsiveInputSliderControl( $wp_customize_manager, $control_id, $control_args );

	}

}
