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
	 * Control's value unit.
	 *
	 * @var string
	 */
	private $value_unit = '%';

	/**
	 * Control's value number.
	 *
	 * @var string
	 */
	private $value_number = 100;

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		parent::enqueue();

		// Enqueue the styles.
		wp_enqueue_style( 'wpbf-control-slider', WPBF_THEME_URI . '/Customizer/Controls/Slider/dist/slider-control.css', array(), WPBF_VERSION );

		// Enqueue the scripts.
		wp_enqueue_script(
			'wpbf-control-slider',
			WPBF_THEME_URI . '/Customizer/Controls/Slider/dist/slider-control.js',
			array(
				'jquery',
				'customize-controls',
				'customize-base',
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

		$this->json['choices'] = wp_parse_args(
			$this->json['choices'],
			array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			)
		);

		if ( isset( $this->json['label'] ) ) {
			$this->json['label'] = html_entity_decode( $this->json['label'] );
		}

		if ( isset( $this->json['description'] ) ) {
			$this->json['description'] = html_entity_decode( $this->json['description'] );
		}

		$this->json['choices']['min']  = (float) $this->json['choices']['min'];
		$this->json['choices']['max']  = (float) $this->json['choices']['max'];
		$this->json['choices']['step'] = (float) $this->json['choices']['step'];

		$this->json['value'] = $this->json['value'] < $this->json['choices']['min'] ? $this->json['choices']['min'] : $this->json['value'];
		$this->json['value'] = $this->json['value'] > $this->json['choices']['max'] ? $this->json['choices']['max'] : $this->json['value'];
		$this->json['value'] = (float) $this->json['value'];

		$this->value_unit   = preg_replace( '/\d+/', '', $this->value() );
		$this->value_number = str_ireplace( $this->value_unit, '', $this->value() );

		$this->json['value_unit']   = $this->value_unit;
		$this->json['value_number'] = $this->value_number;

	}
}
