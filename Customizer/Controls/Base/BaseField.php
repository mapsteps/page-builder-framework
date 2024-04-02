<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Base;

use Mapsteps\Wpbf\Customizer\CustomizerStore;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerControlEntity;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerSettingEntity;
use WP_Customize_Manager;

/**
 * Default settings for the field.
 */
abstract class BaseField {

	/**
	 * Control entity object.
	 *
	 * @var CustomizerControlEntity
	 */
	public $control;

	/**
	 * Whether the field is a wrapper that will render other fields.
	 *
	 * When set to false, `addControl` method will be called to add the control.
	 * When set to true, `addSubFields` method will be called to add sub fields.
	 *
	 * @var bool
	 */
	public $is_wrapper_field = false;

	/**
	 * Whether the control that belongs to the field renders its content
	 * using Underscore.js template inside of `content_template` method.
	 *
	 * @var bool
	 */
	public $use_content_template = false;

	/**
	 * Path of the control class for the field.
	 *
	 * This property will be used when the `use_content_template` property is set to `true`.
	 *
	 * @var string
	 */
	public $control_class_path = '';

	/**
	 * Construct the class.
	 *
	 * @param CustomizerControlEntity $control The control entity object.
	 */
	public function __construct( $control ) {

		$this->control = $control;

	}

	/**
	 * Filter the setting entity.
	 *
	 * This will allow fields to modify their setting entity before it is added to the customizer.
	 *
	 * @param CustomizerSettingEntity $setting The setting entity.
	 *
	 * @return CustomizerSettingEntity
	 */
	public function filterSettingEntity( $setting ) {

		return $setting;

	}

	/**
	 * Enqueue styles & scripts on 'customize_preview_init' action.
	 */
	public function enqueuePreviewScripts() {
	}

	/**
	 * Setting's sanitize callback.
	 *
	 * @param mixed $value The value to sanitize.
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
			'priority'    => $this->control->priority,
			'section'     => $this->control->section_id,
			'label'       => $this->control->label,
			'description' => $this->control->description,
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

		if ( ! isset( CustomizerStore::$added_section_tabs[ $this->control->section_id ] ) ) {
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

	/**
	 * Add control to the customizer when the `$is_wrapper_field` value is `false`.
	 *
	 * The implementation will be in the child class.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		if ( ! ( $wp_customize_manager instanceof WP_Customize_Manager ) ) {
			return;
		}

	}

	/**
	 * Add sub fields when the `$is_wrapper_field` is set to `true`.
	 *
	 * The implementation will be in the child class.
	 *
	 * @param CustomizerSettingEntity $setting_entity The setting entity object.
	 * @param callable|array          $active_callback_args Raw active callback arguments.
	 * @param array                   $partial_refresh_args Raw partial refresh arguments.
	 */
	public function addSubFields( $setting_entity, $active_callback_args, $partial_refresh_args ) {

		if ( ! ( $setting_entity instanceof CustomizerSettingEntity ) ) {
			return;
		}

		if ( ! is_array( $active_callback_args ) && is_callable( $active_callback_args ) ) {
			return;
		}

		if ( ! is_array( $partial_refresh_args ) ) {
			return;
		}

	}

}
