<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Slider;

use WP_Customize_Setting;

class ResponsiveInputSliderControl extends InputSliderControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-responsive-input-slider';

	/**
	 * Control's default allowed devices.
	 *
	 * @var string[]
	 */
	public static $default_devices = [ 'desktop', 'tablet', 'mobile' ];

	/**
	 * Control's allowed devices.
	 *
	 * @var string[]
	 */
	protected $devices = [];

	/**
	 * Whether to save the value as a JSON encoded string.
	 *
	 * @var bool
	 */
	protected $save_as_json = false;

	/**
	 * `ResponsiveInputSliderControl` instance.
	 *
	 * @var ResponsiveInputSliderUtil
	 */
	protected $responsive_util;

	/**
	 * Construct the default value.
	 *
	 * @param array $args The control arguments.
	 */
	protected function constructDefaultValue( $args ) {

		if ( ! empty( $args['devices'] ) && is_array( $args['devices'] ) ) {
			$this->devices = $args['devices'];
		} else {
			$this->devices = static::$default_devices;
		}

		if ( ! empty( $args['save_as_json'] ) && is_bool( $args['save_as_json'] ) ) {
			$this->save_as_json = true;
		}

		$this->responsive_util = new ResponsiveInputSliderUtil();

		if ( ! ( $this->setting instanceof WP_Customize_Setting ) ) {
			return;
		}

		$default_array = $this->responsive_util->toArrayValue( $this->devices, $this->setting->default, $this->min, $this->max );

		$this->setting->default = $this->save_as_json ? wp_json_encode( $default_array ) : $default_array;

		$input_slider_classname = 'wpbf-customize-control-input-slider';

		if ( ! empty( $this->wrapper_attrs['class'] ) ) {
			$existing_classname = $this->wrapper_attrs['class'];
			$existing_classname = str_ireplace( '{default_class}', '', $existing_classname );

			$this->wrapper_attrs['class'] = '{default_class} ' . $existing_classname . ' ' . $input_slider_classname;
		} else {
			$this->wrapper_attrs['class'] = '{default_class} ' . $input_slider_classname;
		}

	}

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		parent::enqueue();

		// Enqueue the scripts.
		wp_enqueue_script(
			'wpbf-responsive-input-slider-control',
			WPBF_THEME_URI . '/Customizer/Controls/Slider/dist/responsive-input-slider-control-min.js',
			array(
				'customize-controls',
				'react-dom',
			),
			WPBF_VERSION,
			false
		);

	}

	/**
	 * Set the value to JSON.
	 */
	protected function setValueToJson() {

		$value = $this->responsive_util->toArrayValue( $this->devices, $this->value(), $this->min, $this->max );

		$this->json['value']      = $this->save_as_json ? wp_json_encode( $value ) : $value;
		$this->json['devices']    = $this->devices;
		$this->json['saveAsJson'] = $this->save_as_json;

	}

}
