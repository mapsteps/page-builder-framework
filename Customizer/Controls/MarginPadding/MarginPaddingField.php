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
	protected function dimensions() {

		return MarginPaddingControl::$defaultDimensions;

	}

	/**
	 * Get control's default unit.
	 *
	 * @return string
	 */
	protected function unit() {

		return MarginPaddingControl::$defaultUnit;

	}

	/**
	 * Setting's sanitize callback.
	 *
	 * @param string|array $value The color value.
	 *
	 * @return array|string
	 */
	public function sanitizeCallback( $value ) {

		$props = $this->control->custom_properties;
		$unit  = ! empty( $props['unit'] ) ? $props['unit'] : $this->unit();

		if ( empty( $value ) ) {
			return '';
		}

		$allowed_dimensions = ! empty( $props['dimensions'] ) ? $props['dimensions'] : $this->dimensions();

		if ( is_numeric( $value ) ) {
			$parsed_value = [];

			foreach ( $allowed_dimensions as $dimension ) {
				$parsed_value[ $dimension ] = $value . $unit;
			}

			return $parsed_value;
		}

		if ( is_string( $value ) ) {
			$sanitized_value = sanitize_text_field( $value );

			$value = [];

			foreach ( $allowed_dimensions as $dimension ) {
				$value[ $dimension ] = $sanitized_value;
			}
		}

		foreach ( $value as $position => $position_value ) {
			if ( '' !== $position_value ) {
				if ( is_numeric( $position_value ) ) {
					$position_value = $position_value . $unit;
				}
			}

			$value[ $position ] = sanitize_text_field( strtolower( $position_value ) );
		}

		return $value;

	}

	/**
	 * Enqueue styles & scripts on 'customize_preview_init' action.
	 */
	public function enqueueCustomizePreviewScripts() {

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

		$control = $this->initControlInstance(
			$wp_customize_manager,
			$this->control->id,
			$control_args
		);

		$control->subtype = $this->control->type;

		$props = $this->control->custom_properties;

		if ( ! empty( $props['unit'] ) && is_string( $props['unit'] ) ) {
			$control->unit = esc_attr( strtolower( $props['unit'] ) );
		}

		if ( ! empty( $props['dimensions'] ) && is_array( $props['dimensions'] ) ) {
			$control->dimensions = $props['dimensions'];
		}

		$wp_customize_manager->add_control( $control );

	}

}