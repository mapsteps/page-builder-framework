<?php
/**
 * Field's default settings.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Base;

use Mapsteps\Wpbf\Customizer\CustomizerUtil;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerControlEntity;
use WP_Customize_Manager;

/**
 * Default settings for the field.
 */
class BaseField {

	/**
	 * Control entity object.
	 *
	 * @var CustomizerControlEntity
	 */
	public $control;

	/**
	 * Construct the class.
	 *
	 * @param CustomizerControlEntity $control The control entity object.
	 */
	public function __construct( $control ) {

		$this->control = $control;

	}

	/**
	 * Enqueue styles & scripts on 'customize_preview_init' action.
	 */
	public function enqueueCustomizePreviewScripts() {
	}

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
	 */
	protected function parseDefaultControlArgs() {

		$control_args = array(
			'capability'  => $this->control->capability,
			'section'     => $this->control->section_id,
			'label'       => $this->control->label,
			'description' => $this->control->description,
			'priority'    => $this->control->priority,
			'choices'     => $this->control->choices,
			'input_attrs' => $this->control->input_attrs,
		);

		if ( ! empty( $this->control->settings ) ) {
			$control_args['settings'] = $this->control->settings;
		}

		if ( ! empty( $this->control->setting ) ) {
			$control_args['setting'] = $this->control->setting;
		}

		if ( ! empty( $this->control->active_callback ) ) {
			$control_args['active_callback'] = $this->control->active_callback;
		}

		return $control_args;

	}

	/**
	 * Parse control args.
	 */
	protected function parseControlArgs() {

		$default_args = $this->parseDefaultControlArgs();
		$custom_args  = array();

		return array_merge( $default_args, $custom_args );

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$base_control = new BaseControl(
			$wp_customize_manager,
			$this->control->id,
			$control_args
		);

		$basic_control_types = ( new CustomizerUtil() )->basic_controls;

		if ( in_array( $this->control->type, $basic_control_types, true ) ) {
			$base_control->type = $this->control->type;
		}

		$wp_customize_manager->add_control( $base_control );

	}

}
