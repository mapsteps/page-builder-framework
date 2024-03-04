<?php

namespace Mapsteps\Wpbf\Customizer\Controls\MarginPadding;

use WP_Customize_Manager;

class ResponsiveMarginPaddingField extends MarginPaddingField {

	/**
	 * Get allowed dimensions.
	 *
	 * @return string[]
	 */
	protected function dimensions() {

		return ResponsiveMarginPaddingControl::$defaultDimensions;

	}

	/**
	 * Get control's default unit.
	 *
	 * @return string
	 */
	protected function unit() {

		return ResponsiveMarginPaddingControl::$defaultUnit;

	}

	/**
	 * Init control instance.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 * @param string               $control_id           The control ID.
	 * @param array                $control_args         The control arguments.
	 *
	 * @return ResponsiveMarginPaddingControl
	 */
	protected function initControlInstance( $wp_customize_manager, $control_id, $control_args ) {

		$control = new ResponsiveMarginPaddingControl( $wp_customize_manager, $control_id, $control_args );

		$props = $this->control->custom_properties;

		if ( ! empty( $props['devices'] ) && is_array( $props['devices'] ) ) {
			$control->devices = $props['devices'];
		}

		return $control;

	}

}