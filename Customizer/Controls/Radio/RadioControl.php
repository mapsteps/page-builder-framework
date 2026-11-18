<?php
/**
 * Radio control.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Radio;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;

/**
 * One control for the radio types: wpbf-radio (a list), wpbf-radio-buttonset (buttons) and wpbf-radio-image (images).
 *
 * The type comes from `$args['type']` (default wpbf-radio); the form picks its layout from it (RadioForm.tsx).
 */
class RadioControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-radio';

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {

		parent::to_json();

		if ( 'wpbf-radio-image' !== $this->type ) {
			return;
		}

		// The image radios put a `style` input attribute on the image labels too.
		foreach ( $this->input_attrs as $attr => $value ) {
			if ( 'style' !== $attr ) {
				$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
				continue;
			}

			$this->json['labelStyle'] = 'style="' . esc_attr( $value ) . '" ';
		}

	}

}
