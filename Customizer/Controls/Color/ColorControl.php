<?php
/**
 * Color control.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Color;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;

/**
 * Class to add Wpbf customizer color control.
 */
class ColorControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-color';

	/**
	 * The color mode.
	 *
	 * Used by ['mode' => 'alpha'] or ['mode' => 'hue'] argument in `properties` method of `wpbf_customizer_field()`.
	 *
	 * @var string
	 */
	public $mode = '';

	/**
	 * The label style. Accepts 'top', 'tooltip', or 'default'.
	 *
	 * @var string
	 */
	public $label_style = 'default';

	/**
	 * The form component.
	 *
	 * The value is based on react-colorful's components. It can be one of the following:
	 *
	 * 'HexColorPicker', 'RgbColorPicker', 'RgbStringColorPicker', 'RgbaColorPicker', 'RgbaStringColorPicker',
	 * 'HslColorPicker', 'HslStringColorPicker', 'HslaColorPicker', 'HslaStringColorPicker', 'HsvColorPicker',
	 * 'HsvStringColorPicker', 'HsvaColorPicker', 'HsvaStringColorPicker', 'HueColorPicker', 'HueStringColorPicker'.
	 *
	 * @var string
	 */
	public $form_component = '';

	/**
	 * The color swatches/palette.
	 *
	 * @var string[]
	 */
	public $color_swatches = array();

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		parent::enqueue();

		// Enqueue the styles.
		wp_enqueue_style( 'wpbf-color-control', WPBF_THEME_URI . '/Customizer/Controls/Color/dist/color-control-min.css', array(), WPBF_VERSION );

		// Enqueue the scripts.
		wp_enqueue_script(
			'wpbf-color-control',
			WPBF_THEME_URI . '/Customizer/Controls/Color/dist/color-control-min.js',
			array(
				'customize-controls',
				'react-dom',
			),
			WPBF_VERSION,
			false
		);

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {

		parent::to_json();

		if ( isset( $this->json['label'] ) ) {
			$this->json['label'] = html_entity_decode( $this->json['label'] );
		}

		if ( isset( $this->json['description'] ) ) {
			$this->json['description'] = html_entity_decode( $this->json['description'] );
		}

		$this->json['value'] = empty( $this->value() ) ? '' : ( 'hue' === $this->mode ? absint( $this->value() ) : $this->value() );

		if ( is_string( $this->json['value'] ) ) {
			$this->json['value'] = strtolower( $this->json['value'] );
		}

		$this->json['mode'] = $this->mode;

		$this->json['labelStyle'] = ! empty( $this->label_style ) ? $this->label_style : 'default';

		$this->json['colorSwatches'] = $this->get_color_swatches();

		if ( ! empty( $this->form_component ) ) {
			$this->json['formComponent'] = $this->form_component;
		}

	}

	/**
	 * Get color swatches values.
	 *
	 * @return string[] The color swatches values.
	 */
	public function get_color_swatches() {

		$default_swatches = array(
			'#000000',
			'#ffffff',
			'#dd3333',
			'#dd9933',
			'#eeee22',
			'#81d742',
			'#1e73be',
			'#8224e3',
		);

		// The 'kirki_default_color_swatches' filter is for backwards compatibility with Kirki.
		$default_swatches = apply_filters( 'kirki_default_color_swatches', $default_swatches );

		$default_swatches = apply_filters( 'wpbf_default_color_swatches', $default_swatches );

		$defined_swatches = ! empty( $this->color_swatches ) ? $this->color_swatches : array();

		if ( ! empty( $defined_swatches ) ) {
			$swatches       = $defined_swatches;
			$total_swatches = count( $swatches );

			if ( $total_swatches < 8 ) {
				for ( $i = $total_swatches; $i < 8; $i++ ) {
					if ( isset( $default_swatches[ $i ] ) ) {
						$swatches[] = $default_swatches[ $i ];
					}
				}
			}
		} else {
			$swatches = $default_swatches;
		}

		// The 'kirki_color_swatches' filter is for backwards compatibility with Kirki.
		$swatches = apply_filters( 'kirki_color_swatches', $swatches );

		return apply_filters( 'wpbf_color_swatches', $swatches );

	}

}
