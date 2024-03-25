<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Media;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use WP_Customize_Manager;

class UploadField extends BaseField {

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
	public $control_class_path = '\Mapsteps\Wpbf\Customizer\Controls\Media\UploadControl';

	/**
	 * Setting's sanitize callback.
	 *
	 * @param string $value The value to sanitize.
	 *
	 * @return string|int|float|array
	 */
	public function sanitizeCallback( $value ) {

		$util    = $this->getUtilInstance();
		$props   = $this->control->custom_properties;
		$save_as = $util->default_save_as;

		// The properties of $src here are already sanitized.
		$src = $util->unknownToSrcArray( $value );

		if ( ! empty( $props['save_as'] ) && is_string( $props['save_as'] ) ) {
			if ( in_array( $props['save_as'], $util->allowed_save_as, true ) ) {
				$save_as = $props['save_as'];
			}
		}

		if ( 'array' === $save_as ) {
			return $src;
		}

		if ( 'id' === $save_as ) {
			return $src['id'];
		}

		return $src['url'];

	}

	/**
	 * Get utility instance.
	 *
	 * @return UploadUtil
	 */
	protected function getUtilInstance() {

		return new UploadUtil();

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$wp_customize_manager->add_control(
			new UploadControl(
				$wp_customize_manager,
				$this->control->id,
				$control_args
			)
		);

	}

}
