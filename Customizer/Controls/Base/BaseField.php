<?php
/**
 * Field's default settings.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Base;

use Mapsteps\Wpbf\Customizer\Entities\CustomizerControlEntity;

/**
 * Default settings for the field.
 */
class BaseField {

	/**
	 * Setting's sanitize callback.
	 *
	 * @param string $value The value to sanitize.
	 *
	 * @return string|float|int|array
	 */
	public function sanitizeCallback( $value ) {

		return sanitize_text_field( $value );

	}

	/**
	 * Parse control args that are provided by WP_Customize_Control by default.
	 *
	 * @param CustomizerControlEntity $control The control entity object.
	 */
	protected function parseDefaultControlArgs( $control ) {

		$control_args = array(
			'capability'  => $control->capability,
			'section'     => $control->section_id,
			'label'       => $control->label,
			'description' => $control->description,
			'priority'    => $control->priority,
			'choices'     => $control->choices,
			'input_attrs' => $control->input_attrs,
		);

		if ( ! empty( $control->settings ) ) {
			$control_args['settings'] = $control->settings;
		}

		if ( ! empty( $control->setting ) ) {
			$control_args['setting'] = $control->setting;
		}

		if ( ! empty( $control->active_callback ) ) {
			$control_args['active_callback'] = $control->active_callback;
		}

		return $control_args;

	}

	/**
	 * Parse control args.
	 *
	 * @param CustomizerControlEntity $control The control entity object.
	 */
	protected function parseControlArgs( $control ) {

		$default_args = $this->parseDefaultControlArgs( $control );
		$custom_args  = array();

		return array_merge( $default_args, $custom_args );

	}

}
