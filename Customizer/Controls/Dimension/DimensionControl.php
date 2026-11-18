<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Dimension;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;

/**
 * Dimension control: a text field for a CSS size ("20px", "50%", "auto" …), warns about values that aren't one.
 *
 * The form renders with React (DimensionForm.tsx).
 */
class DimensionControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-dimension';

	/**
	 * Label position.
	 *
	 * @var string
	 */
	public $label_position = 'top';

	/**
	 * Whether to allow value without units.
	 *
	 * @var bool
	 */
	public $allow_unitless = true;

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		parent::enqueue();

		// Enqueue the styles.
		wp_enqueue_style( 'wpbf-dimension-control', WPBF_THEME_URI . '/Customizer/Controls/Dimension/dist/dimension-control-min.css', array(), WPBF_VERSION );

		// Enqueue the scripts.
		wp_enqueue_script(
			'wpbf-dimension-control',
			WPBF_THEME_URI . '/Customizer/Controls/Dimension/dist/dimension-control-min.js',
			array( 'wpbf-base-control', 'wp-element', 'react-jsx-runtime' ),
			WPBF_VERSION,
			false
		);

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {

		$input_class = 'wpbf-control-input';

		if ( isset( $this->input_attrs['class'] ) ) {
			$input_class .= ' ' . $this->input_attrs['class'];
			unset( $this->input_attrs['class'] );
		}

		parent::to_json();

		$this->json['inputClass'] = $input_class;

		$this->json['labelPosition'] = $this->label_position;

		$this->json['allowUnitless'] = $this->allow_unitless;

	}

}
