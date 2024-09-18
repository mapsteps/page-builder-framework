<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Checkbox;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use WP_Customize_Manager;

class CheckboxButtonsetField extends BaseField {

	/**
	 * Whether the control of this field renders its content
	 * using Underscore.js template inside of `content_template` method.
	 *
	 * @var bool
	 */
	public $use_content_template = true;

	/**
	 * Path of the control class for this field.
	 *
	 * @var string
	 */
	public $control_class_path = '\Mapsteps\Wpbf\Customizer\Controls\Checkbox\CheckboxButtonsetControl';

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

		$setting->default = $this->sanitizeCallback( $setting->default );

		return $setting;

	}

	/**
	 * Setting's sanitize callback.
	 *
	 * @param mixed $value The value to sanitize.
	 *
	 * @return array
	 */
	public function sanitizeCallback( $value ) {

		if ( ! is_array( $value ) || empty( $value ) ) {
			return [];
		}

		$sanitized_value = array_map(function ( $val ) {
			return sanitize_text_field( $val );
		}, $value);

		return array_values( $sanitized_value );

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$wp_customize_manager->add_control(
			new CheckboxButtonsetControl(
				$wp_customize_manager,
				$this->control->id,
				$control_args
			)
		);

	}

}
