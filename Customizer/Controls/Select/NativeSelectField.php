<?php
/**
 * Select field's default settings.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Select;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use WP_Customize_Manager;

/**
 * Default settings for the select field.
 */
class NativeSelectField extends BaseField {

	/**
	 * Setting's sanitize callback.
	 *
	 * @param string|string[] $value The value to sanitize.
	 *
	 * @return string|string[]
	 */
	public function sanitizeCallback( $value ) {

		$max_selections = -1;

		if ( isset( $this->control->custom_properties['max_selections'] ) ) {
			$max_selections = (int) $this->control->custom_properties['max_selections'];
		}

		return ( new SelectUtil() )->sanitize( $value, $max_selections );

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$custom_props = $this->control->custom_properties;

		$select_control = new NativeSelectControl(
			$wp_customize_manager,
			$this->control->id,
			$control_args
		);

		if ( isset( $custom_props['multiple'] ) ) {
			$select_control->multiple = $custom_props['multiple'];
		}

		if ( isset( $custom_props['max_selections'] ) ) {
			$select_control->max_selections = $custom_props['max_selections'];
		}

		if ( isset( $custom_props['placeholder'] ) ) {
			$select_control->placeholder = $custom_props['placeholder'];
		}

		if ( isset( $custom_props['layout_style'] ) ) {
			$select_control->layout_style = $custom_props['layout_style'];
		}

		$wp_customize_manager->add_control( $select_control );

	}

}
