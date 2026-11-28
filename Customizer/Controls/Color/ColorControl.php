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
	 * Whether the color may share a row with its states (display only, every color keeps its own setting).
	 *
	 * A color whose id ends in `_alt` (hover) or `_active` (active) shows as a second or third swatch on the row of the
	 * color with the base id, when both are color controls in the same section: "Font Color" with "Normal", "Hover" (and
	 * "Active") swatches instead of a row per state. false keeps the color on its own row. Set with the field's
	 * `color_group` property.
	 *
	 * @var bool
	 */
	public $color_group = true;

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

		$color_group = $this->get_color_group();

		if ( $color_group ) {
			$this->json['colorGroup'] = $color_group;
		}

	}

	/**
	 * The color's place in a row of states (see `$color_group`).
	 *
	 * @return array|null [ 'role' => 'leader', 'members' => ids, 'caption' ] for the first color of a row,
	 *                    [ 'role' => 'member', 'leader' => id, 'caption' ] for a state joining it, null for a row of its own.
	 */
	public function get_color_group() {

		$captions = array(
			'alt'    => __( 'Hover', 'page-builder-framework' ),
			'active' => __( 'Active', 'page-builder-framework' ),
		);

		if ( preg_match( '/^(.+)_(alt|active)$/', $this->id, $matches ) ) {
			$leader = $this->manager->get_control( $matches[1] );

			if ( $this->can_group_with( $leader ) ) {
				return array(
					'role'    => 'member',
					'leader'  => $leader->id,
					'caption' => $captions[ $matches[2] ],
				);
			}
		}

		$members = array();

		foreach ( array_keys( $captions ) as $suffix ) {
			$member = $this->manager->get_control( $this->id . '_' . $suffix );

			if ( $this->can_group_with( $member ) ) {
				$members[] = $member->id;
			}
		}

		if ( empty( $members ) ) {
			return null;
		}

		return array(
			'role'    => 'leader',
			'members' => $members,
			'caption' => __( 'Normal', 'page-builder-framework' ),
		);

	}

	/**
	 * Whether this color and another one may share a row: both color controls with the default label style, in the
	 * same section, and neither kept on its own row.
	 *
	 * @param mixed $other The other control (or null).
	 *
	 * @return bool
	 */
	private function can_group_with( $other ) {

		return $other instanceof self
			&& false !== $this->color_group
			&& false !== $other->color_group
			&& 'default' === $this->label_style
			&& 'default' === $other->label_style
			&& $this->section === $other->section;

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
