<?php
/**
 * Field's default settings.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Base;

use Mapsteps\Wpbf\Customizer\Customizer;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerControlEntity;

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
	private function parseDefaultControlArgs() {

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
	 * Parse 'tab' custom property.
	 *
	 * @param array $existing_properties The existing custom properties.
	 *
	 * @return array
	 */
	private function parseTabCustomProp( $existing_properties ) {

		$props = $existing_properties;

		if ( empty( $props['tab'] ) ) {
			return $props;
		}

		if ( ! isset( Customizer::$added_section_tabs[ $this->control->section_id ] ) ) {
			return $props;
		}

		$tab_wrapper_attrs = array(
			'data-wpbf-parent-tab-id'   => $this->control->section_id,
			'data-wpbf-parent-tab-item' => esc_attr( $props['tab'] ),
		);

		if ( isset( $props['wrapper_attrs'] ) ) {
			$props['wrapper_attrs'] = array_merge( $props['wrapper_attrs'], $tab_wrapper_attrs );
		} else {
			$props['wrapper_attrs'] = $tab_wrapper_attrs;
		}

		unset( $props['tab'] );

		return $props;

	}

	/**
	 * Parse the default control args with our custom properties.
	 */
	protected function parseControlArgs() {

		$default_args = $this->parseDefaultControlArgs();

		$custom_properties = $this->control->custom_properties;
		$custom_properties = $this->parseTabCustomProp( $custom_properties );

		return wp_parse_args( $custom_properties, $default_args );

	}

}
