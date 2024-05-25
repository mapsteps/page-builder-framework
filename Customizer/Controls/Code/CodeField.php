<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Code;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use WP_Customize_Manager;

class CodeField extends BaseField {

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
	public $control_class_path = '\Mapsteps\Wpbf\Customizer\Controls\Code\CodeControl';

	/**
	 * Setting's sanitize callback.
	 *
	 * Code fields should not be filtered by default.
	 * Their values usually contain CSS/JS and it it the responsibility of the theme/plugin that registers this field to properly sanitize the value.
	 *
	 * @param string $value The value to sanitize.
	 *
	 * @return string
	 */
	public function sanitizeCallback( $value ) {

		return $value;

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$wp_customize_manager->add_control(
			new CodeControl(
				$wp_customize_manager,
				$this->control->id,
				$control_args
			)
		);

	}

}
