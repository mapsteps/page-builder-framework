<?php

namespace Mapsteps\Wpbf\Customizer\Controls\MarginPadding;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;
use WP_Customize_Manager;

class MarginPaddingControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-margin-padding';

	/**
	 * Control's subtype.
	 *
	 * @var string
	 */
	public $subtype = 'margin';

	/**
	 * Control's default unit.
	 *
	 * @var string
	 */
	public static $defaultUnit = 'px';

	/**
	 * Control's value unit.
	 *
	 * @var string
	 */
	public $unit = '';

	/**
	 * Control's allowed dimensions.
	 *
	 * @var string[]
	 */
	public static $defaultDimensions = [ 'top', 'right', 'bottom', 'left' ];

	/**
	 * Control's dimensions.
	 *
	 * @var string[]
	 */
	public $dimensions = [];

	/**
	 * The default of control's "default" without the unit.
	 *
	 * This will be populated in constructor based on $dimensions property above.
	 * After that, it will be parsed with $args['default'].
	 * The returned value will still be without the unit.
	 *
	 * @var array
	 */
	public $default_array = [];

	/**
	 * The default of control's "value" without the unit.
	 *
	 * This will be populated in constructor based on $dimensions property above.
	 * After that, it will be parsed with $this->value().
	 * The returned value will still be without the unit.
	 *
	 * @var array
	 */
	public $value_array = [];

	/**
	 * Constructor.
	 *
	 * Supplied `$args` override class property defaults.
	 *
	 * If `$args['settings']` is not defined, use the `$id` as the setting ID.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager Customizer bootstrap instance.
	 * @param string               $id                   Control ID.
	 * @param array                $args                 Optional. Array of properties for the new Control object.
	 *                                                   Default empty array.
	 */
	public function __construct( $wp_customize_manager, $id, $args = array() ) {

		parent::__construct( $wp_customize_manager, $id, $args );

		if ( empty( $this->unit ) ) {
			$this->unit = static::$defaultUnit;
		}

		foreach ( static::$defaultDimensions as $dimension ) {
			$this->dimensions[]                = $dimension;
			$this->default_array[ $dimension ] = '';
			$this->value_array[ $dimension ]   = '';
		}

		// Parse $args['default'] with $this->default_array.
		if ( ! empty( $args['default'] ) && is_array( $args['default'] ) ) {
			$this->default_array = wp_parse_args( $args['default'], $this->default_array );
		}

		$this->default_array = $this->remove_unit( $this->default_array );

		// Parse $this->value() with $this->value_array.
		if ( ! empty( $this->value() ) && is_array( $this->value() ) ) {
			$this->value_array = wp_parse_args( $this->value(), $this->value_array );
		}

		$this->value_array = $this->remove_unit( $this->value_array );

	}

	/**
	 * Remove unit from values.
	 *
	 * @param array $values The provided values.
	 *
	 * @return array
	 */
	private function remove_unit( $values ) {

		foreach ( $values as $position => $value ) {
			if ( '' !== $value ) {
				// Force $value to not using unit.
				if ( ! is_numeric( $value ) ) {
					$unit  = preg_replace( '/\d+/', '', $value );
					$value = str_ireplace( $unit, '', $value );
				}

				$value = (float) $value;
			}

			$values[ $position ] = $value;
		}

		return $values;

	}

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		parent::enqueue();

		// Enqueue the styles.
		wp_enqueue_style( 'wpbf-margin-padding-control', WPBF_THEME_URI . '/Customizer/Controls/MarginPadding/dist/margin-padding-control-min.css', array(), WPBF_VERSION );

		// Enqueue the scripts.
		wp_enqueue_script(
			'wpbf-margin-padding-control',
			WPBF_THEME_URI . '/Customizer/Controls/MarginPadding/dist/margin-padding-control-min.js',
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

		$this->json['subtype'] = $this->subtype;

		if ( isset( $this->json['label'] ) ) {
			$this->json['label'] = html_entity_decode( $this->json['label'] );
		}

		if ( isset( $this->json['description'] ) ) {
			$this->json['description'] = html_entity_decode( $this->json['description'] );
		}

		$this->json['valueArray']   = $this->value_array;
		$this->json['defaultArray'] = $this->default_array;
		$this->json['unit']         = $this->unit;

		$this->json['value'] = [];

		foreach ( $this->json['valueArray'] as $position => $value ) {
			$this->json['value'][ $position ] = $value . $this->unit;
		}

		$this->json['dimensions'] = $this->dimensions;

	}

}