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
class SelectField extends BaseField {

	/**
	 * Setting's sanitize callback.
	 *
	 * @param string $value The value to sanitize.
	 *
	 * @return string|string[]
	 */
	public function sanitizeCallback( $value ) {

		if ( ! is_array( $value ) ) {
			return sanitize_text_field( $value );
		}

		$total_values   = count( $value );
		$max_selections = -1;

		if ( isset( $this->control->custom_properties['max_selections'] ) ) {
			$max_selections = (int) $this->control->custom_properties['max_selections'];
		}

		if ( $total_values > $max_selections ) {
			$value = array_slice( $value, 0, $max_selections );
		}

		$values = array_map( 'sanitize_text_field', $value );

		return array_values( $values );

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$custom_props = $this->control->custom_properties;

		$select_control = new SelectControl(
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

		if ( isset( $custom_props['clearable'] ) ) {
			$select_control->clearable = $custom_props['clearable'];
		}

		$wp_customize_manager->add_control( $select_control );

	}

}
