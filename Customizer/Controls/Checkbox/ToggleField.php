<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Checkbox;

use WP_Customize_Manager;

class ToggleField extends CheckboxField {

	/**
	 * Path of the control class for this field.
	 *
	 * @var string
	 */
	public $control_class_path = '\Mapsteps\Wpbf\Customizer\Controls\Checkbox\ToggleControl';

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$props = $this->control->custom_properties;

		if ( isset( $props['checkbox_type'] ) ) {
			if ( isset( $props['wrapper_attrs'] ) && is_array( $props['wrapper_attrs'] ) ) {
				if ( isset( $props['wrapper_attrs']['class'] ) ) {
					$props['wrapper_attrs']['class'] .= ' switch-control';
				} else {
					$props['wrapper_attrs']['class'] = '{default_class} switch-control';
				}
			} else {
				$props['wrapper_attrs'] = array(
					'class' => '{default_class} switch-control',
				);
			}

			$this->control->custom_properties = $props;
		}

		$control_args = $this->parseControlArgs();

		$wp_customize_manager->add_control(
			new ToggleControl(
				$wp_customize_manager,
				$this->control->id,
				$control_args
			)
		);

	}

}
