<?php
/**
 * Control slider.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Slider;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;

/**
 * Class to add Wpbf customizer slider control.
 */
class SliderControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-slider';

	/**
	 * @var int|float Minimum value.
	 */
	public $min = 0;

	/**
	 * @var int|float Maximum value.
	 */
	public $max = 100;

	/**
	 * @var int|float Step value.
	 */
	public $step = 1;

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		parent::enqueue();

		// Enqueue the styles.
		wp_enqueue_style( 'wpbf-slider-control', WPBF_THEME_URI . '/Customizer/Controls/Slider/dist/slider-control-min.css', array(), WPBF_VERSION );

		// Enqueue the scripts.
		wp_enqueue_script(
			'wpbf-slider-control',
			WPBF_THEME_URI . '/Customizer/Controls/Slider/dist/slider-control-min.js',
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

		$this->json['min']  = (float) $this->min;
		$this->json['max']  = (float) $this->max;
		$this->json['step'] = (float) $this->step;

		$this->json['value'] = $this->json['value'] < $this->json['min'] ? $this->json['min'] : $this->json['value'];
		$this->json['value'] = $this->json['value'] > $this->json['max'] ? $this->json['max'] : $this->json['value'];
		$this->json['value'] = (float) $this->json['value'];

		$value_unit   = preg_replace( '/\d+/', '', $this->value() );
		$value_number = str_ireplace( $value_unit, '', $this->value() );

		$this->json['valueUnit']   = $value_unit;
		$this->json['valueNumber'] = $value_number;

	}

}
