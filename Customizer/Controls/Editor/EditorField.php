<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Editor;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use WP_Customize_Manager;

class EditorField extends BaseField {

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
	public $control_class_path = '\Mapsteps\Wpbf\Customizer\Controls\Editor\EditorControl';

	/**
	 * Setting's sanitize callback.
	 *
	 * @param string $value The value to sanitize.
	 *
	 * @return bool
	 */
	public function sanitizeCallback( $value ) {

		return wp_kses_post( $value );

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$wp_customize_manager->add_control(
			new EditorControl(
				$wp_customize_manager,
				$this->control->id,
				$control_args
			)
		);

	}

}
