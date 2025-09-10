<?php
/**
 * Color field's default settings.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Color;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseField;
use WP_Customize_Manager;

/**
 * Default settings for the color field.
 */
class ColorField extends BaseField {

	/**
	 * Enqueue styles & scripts on 'customize_preview_init' action.
	 */
	public function enqueuePreviewScripts() {

		wp_enqueue_script(
			'wpbf-color-preview',
			WPBF_THEME_URI . '/Customizer/Controls/Color/dist/color-preview-min.js',
			array(
				'wp-hooks',
				'customize-preview',
			),
			WPBF_VERSION,
			true
		);

	}

	/**
	 * Setting's sanitize callback.
	 *
	 * @param string|array $value The color value.
	 *
	 * @return string|int[]
	 */
	public function sanitizeCallback( $value ) {

		return ( new ColorSanitizer() )->sanitize( $value );

	}

	/**
	 * Add control to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager The customizer manager object.
	 */
	public function addControl( $wp_customize_manager ) {

		$control_args = $this->parseControlArgs();

		$custom_props = $this->control->custom_properties;

		$color_control = new ColorControl(
			$wp_customize_manager,
			$this->control->id,
			$control_args
		);

		if ( isset( $custom_props['mode'] ) ) {
			$color_control->mode = $custom_props['mode'];
		}

		if ( isset( $custom_props['label_style'] ) ) {
			$color_control->label_style = $custom_props['label_style'];
		}

		if ( isset( $custom_props['form_component'] ) ) {
			$color_control->form_component = $custom_props['form_component'];
		}

		if ( isset( $custom_props['color_swatches'] ) ) {
			$color_control->color_swatches = $custom_props['color_swatches'];
		} elseif ( isset( $custom_props['color_palette'] ) ) {
			$color_control->color_swatches = $custom_props['color_palette'];
		} elseif ( isset( $custom_props['color_palettes'] ) ) {
			$color_control->color_swatches = $custom_props['color_palette'];
		} elseif ( isset( $custom_props['swatches'] ) ) {
			// The 'swatches' property is for backwards compatibility with Kirki.
			$color_control->color_swatches = $custom_props['swatches'];
		} elseif ( isset( $custom_props['palettes'] ) ) {
			// The 'palettes' property is for backwards compatibility with Kirki.
			$color_control->color_swatches = $custom_props['palettes'];
		}

		$wp_customize_manager->add_control( $color_control );

	}

}
