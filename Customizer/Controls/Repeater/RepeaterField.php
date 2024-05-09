<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Repeater;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerSettingEntity;
use WP_Customize_Manager;

class RepeaterField extends BaseField {

	/**
	 * Path of the control class for this field.
	 *
	 * @var string
	 */
	public $control_class_path = '\Mapsteps\Wpbf\Customizer\Controls\Repeater\RepeaterControl';

	/**
	 * Filter the setting entity.
	 *
	 * Make sure the default value's data type is a boolean.
	 *
	 * @param CustomizerSettingEntity $setting The setting entity.
	 *
	 * @return CustomizerSettingEntity
	 */
	public function filterSettingEntity( $setting ) {

		// Maybe do something here.

		return $setting;

	}

	/**
	 * Setting's sanitize callback.
	 *
	 * @param string $value The value to sanitize.
	 *
	 * @return bool
	 */
	public function sanitizeCallback( $value ) {

		if ( ! $value ) {
			return [];
		}

		$props  = $this->control->custom_properties;
		$fields = isset( $props['fields'] ) ? $props['fields'] : [];

		return ( new RepeaterSanitizer() )->sanitize( $value, $fields );

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$wp_customize_manager->add_control(
			new RepeaterControl(
				$wp_customize_manager,
				$this->control->id,
				$control_args
			)
		);

	}

}
