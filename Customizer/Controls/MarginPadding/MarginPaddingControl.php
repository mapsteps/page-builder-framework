<?php

namespace Mapsteps\Wpbf\Customizer\Controls\MarginPadding;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;
use WP_Customize_Manager;
use WP_Customize_Setting;

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
	 * Default value of control's value unit.
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
	 * Default value of control's allowed dimensions.
	 *
	 * @var string[]
	 */
	public static $defaultDimensions = [ 'top', 'right', 'bottom', 'left' ];

	/**
	 * Control's allowed dimensions.
	 *
	 * @var string[]
	 */
	public $dimensions = [];

	/**
	 * Whether to save the control's value as JSON.
	 *
	 * This will make the control's value to be saved as JSON string (without unit).
	 * This is used to support the old PBF's "responsive_padding" control.
	 *
	 * @var bool
	 */
	public $save_as_json = false;

	/**
	 * The default of control's "default" without the unit.
	 *
	 * This will be populated in constructor based on $dimensions property above.
	 * After that, it will be parsed with the real default.
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

		if ( ! empty( $args['save_as_json'] ) && is_bool( $args['save_as_json'] ) ) {
			$this->save_as_json = true;
		}

		if ( ! empty( $args['unit'] ) && is_string( $args['unit'] ) ) {
			$this->unit = $args['unit'];
		} else {
			$this->unit = static::$defaultUnit;
		}

		if ( ! empty( $args['dimensions'] ) && is_array( $args['dimensions'] ) ) {
			$this->dimensions = $args['dimensions'];
		} else {
			$this->dimensions = static::$defaultDimensions;
		}

		foreach ( $this->dimensions as $dimension ) {
			$this->default_array[ $dimension ] = '';
			$this->value_array[ $dimension ]   = '';
		}

		parent::__construct( $wp_customize_manager, $id, $args );

		$util = new MarginPaddingUtil();

		$real_default = $this->setting instanceof WP_Customize_Setting ? $this->setting->default : ( $this->save_as_json ? '' : [] );

		// Parse $real_default with $this->default_array.
		if ( ! empty( $real_default ) ) {
			$defaults_array      = $util->toArrayValues( $this->dimensions, ( $this->save_as_json ? false : $this->unit ), $real_default );
			$this->default_array = wp_parse_args( $defaults_array, $this->default_array );
		}

		$this->default_array = $this->remove_units( $this->default_array );

		$real_value = $this->value();

		// Parse $real_value with $this->value_array.
		if ( ! empty( $real_value ) ) {
			$real_values       = $util->toArrayValues( $this->dimensions, ( $this->save_as_json ? false : $this->unit ), $real_value );
			$this->value_array = wp_parse_args( $real_values, $this->value_array );
		}

		$this->value_array = $this->remove_units( $this->value_array );

		if ( $this->save_as_json ) {
			// Normalize the real default, so that $this->value() will return JSON string.
			$this->setting->default = $util->toJsonStrWithoutUnit( $this->default_array );
		}

	}

	/**
	 * Remove unit from values.
	 *
	 * @param array $values The provided values.
	 *
	 * @return array
	 */
	private function remove_units( $values ) {

		foreach ( $values as $position => $value ) {
			if ( '' !== $value ) {
				// Force $value to not using unit.
				if ( ! is_numeric( $value ) ) {
					$unit  = preg_replace( '/\d+/', '', $value );
					$value = $unit ? str_ireplace( $unit, '', $value ) : $value;
				}

				$value = is_numeric( $value ) ? (float) $value : '';
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
		$this->json['dimensions']   = $this->dimensions;
		$this->json['save_as_json'] = $this->save_as_json;

	}

}