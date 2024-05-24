<?php

namespace Mapsteps\Wpbf\Customizer\Controls\MarginPadding;

use WP_Customize_Manager;

class ResponsiveMarginPaddingField extends MarginPaddingField {

	/**
	 * Get allowed dimensions.
	 *
	 * @return string[]
	 */
	protected function defaultDimensions() {

		return ResponsiveMarginPaddingControl::$default_dimensions;

	}

	/**
	 * Get control's default unit.
	 *
	 * @return string
	 */
	protected function defaultUnit() {

		return ResponsiveMarginPaddingControl::$default_unit;

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

		if ( ! isset( $control_args['wrapper_attrs'] ) ) {
			$control_args['wrapper_attrs'] = [];
		}

		if ( empty( $control_args['wrapper_attrs']['class'] ) ) {
			$control_args['wrapper_attrs']['class'] = '{default_class} wpbf-customize-control-responsive';
		} else {
			$control_args['wrapper_attrs']['class'] .= ' wpbf-customize-control-responsive';
		}

		$control = new ResponsiveMarginPaddingControl( $wp_customize_manager, $control_id, $control_args );

		if ( ! empty( $control_args['devices'] ) && is_array( $control_args['devices'] ) ) {
			$control->devices = $control_args['devices'];
		}

		return $control;

	}

}
