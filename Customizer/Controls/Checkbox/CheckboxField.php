<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Checkbox;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerSettingEntity;
use WP_Customize_Manager;

class CheckboxField extends BaseField {

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
	public $control_class_path = '\Mapsteps\Wpbf\Customizer\Controls\Checkbox\CheckboxControl';

	/**
	 * Positive values which will be treated as `true`.
	 *
	 * @var array $positive_values
	 */
	private $positive_values = [ true, 'true', 1, '1', 'on', 'On', 'ON' ];

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

		if ( ! $setting->default ) {
			$setting->default = false;
		} else {
			$setting->default = in_array( $setting->default, $this->positive_values, true );
		}

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
			return false;
		}

		return in_array( $value, $this->positive_values, true );

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$wp_customize_manager->add_control(
			new CheckboxControl(
				$wp_customize_manager,
				$this->control->id,
				$control_args
			)
		);

	}

}
