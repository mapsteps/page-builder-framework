<?php
/**
 * Select field's default settings.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Select;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerControlEntity;
use WP_Customize_Manager;

/**
 * Default settings for the select field.
 */
class SelectField extends BaseField {

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager    $wp_customize_manager The customizer manager object.
	 * @param CustomizerControlEntity $control The control entity object.
	 */
	public function addControl( $wp_customize_manager, $control ) {

		$control_args = $this->parseControlArgs( $control );

		$custom_props = $control->custom_properties;

		$select_control = new SelectControl(
			$wp_customize_manager,
			$control->id,
			$control_args
		);

		if ( isset( $custom_props['multiple'] ) ) {
			$select_control->multiple = $custom_props['multiple'];
		}

		if ( isset( $custom_props['max_selection_number'] ) ) {
			$select_control->max_selection_number = $custom_props['max_selection_number'];
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
