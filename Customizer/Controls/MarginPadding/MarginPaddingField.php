<?php

namespace Mapsteps\Wpbf\Customizer\Controls\MarginPadding;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use WP_Customize_Manager;

class MarginPaddingField extends BaseField {

	/**
	 * Get allowed dimensions.
	 *
	 * @return string[]
	 */
	protected function defaultDimensions() {

		return MarginPaddingControl::$default_dimensions;

	}

	/**
	 * Get control's default unit.
	 *
	 * @return string
	 */
	protected function defaultUnit() {

		return MarginPaddingControl::$default_unit;

	}

	/**
	 * Setting's sanitize callback.
	 *
	 * @param string|array $value The value to sanitize.
	 *
	 * @return array|string
	 */
	public function sanitizeCallback( $value ) {

		// The allowed value are JSON string or array.
		if ( empty( $value ) || ( ! is_string( $value ) && ! is_array( $value ) ) ) {
			return '';
		}

		$props = $this->control->custom_properties;
		$unit  = ! empty( $props['unit'] ) ? $props['unit'] : $this->defaultUnit();

		$dimensions = ! empty( $props['dimensions'] ) ? $props['dimensions'] : $this->defaultDimensions();

		$save_as_json   = ! empty( $props['save_as_json'] ) && is_bool( $props['save_as_json'] );
		$dont_save_unit = ! empty( $props['dont_save_unit'] ) && is_bool( $props['dont_save_unit'] );

		$util = new MarginPaddingUtil();

		$array_values = $util->toArrayValue( $dimensions, ( $dont_save_unit ? false : $unit ), $value );

		return $save_as_json ? wp_json_encode( $array_values ) : $array_values;

	}

	/**
	 * Enqueue styles & scripts on 'customize_preview_init' action.
	 */
	public function enqueuePreviewScripts() {

		wp_enqueue_script(
			'wpbf-color-preview',
			WPBF_THEME_URI . '/Customizer/Controls/MarginPadding/dist/margin-padding-preview-min.js',
			array(
				'wp-hooks',
				'customize-preview',
			),
			WPBF_VERSION,
			true
		);

	}

	/**
	 * Init control instance.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 * @param string               $control_id           The control ID.
	 * @param array                $control_args         The control arguments.
	 *
	 * @return MarginPaddingControl
	 */
	protected function initControlInstance( $wp_customize_manager, $control_id, $control_args ) {

		return new MarginPaddingControl( $wp_customize_manager, $control_id, $control_args );

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$control_args['subtype'] = $this->control->type;

		$wp_customize_manager->add_control( $this->initControlInstance(
			$wp_customize_manager,
			$this->control->id,
			$control_args
		) );

	}

}
