<?php
/**
 * Values of the slider control's three types.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Slider;

use Mapsteps\Wpbf\Customizer\Controls\Generic\NumberUtil;

/**
 * Limits and stored values of wpbf-slider, wpbf-input-slider and wpbf-responsive-input-slider.
 *
 * Used by the field (to check saved values) and the control (default and value shown), so both agree.
 * The stored formats are the ones the three separate controls had:
 *
 * - wpbf-slider: a number within min and max ('' when empty).
 * - wpbf-input-slider: the same, or text with its unit kept ("20px").
 * - wpbf-responsive-input-slider: an array with one such value per device, or that array as JSON text
 *   when the field has `save_as_json`.
 */
class SliderValue {

	/**
	 * Default minimum.
	 *
	 * @var int
	 */
	const DEFAULT_MIN = 0;

	/**
	 * Default maximum.
	 *
	 * @var int
	 */
	const DEFAULT_MAX = 100;

	/**
	 * Default devices of the responsive slider.
	 *
	 * @var string[]
	 */
	const DEFAULT_DEVICES = array( 'desktop', 'tablet', 'mobile' );

	/**
	 * The control type ('wpbf-slider', 'wpbf-input-slider' or 'wpbf-responsive-input-slider').
	 *
	 * @var string
	 */
	public $type;

	/**
	 * Minimum.
	 *
	 * @var int|float
	 */
	public $min;

	/**
	 * Maximum (never below the minimum).
	 *
	 * @var int|float
	 */
	public $max;

	/**
	 * Step.
	 *
	 * @var int|float
	 */
	public $step = 1;

	/**
	 * Devices (responsive slider).
	 *
	 * @var string[]
	 */
	public $devices = array();

	/**
	 * Whether the responsive slider saves its value as JSON text.
	 *
	 * @var bool
	 */
	public $save_as_json = false;

	/**
	 * Read the limits from the field's arguments.
	 *
	 * @param string $type The control type, with or without the 'wpbf-' prefix.
	 * @param array  $args The field's arguments (`min`, `max`, `step`, `devices`, `save_as_json`).
	 */
	public function __construct( $type, $args ) {

		$this->type = 0 === strpos( $type, 'wpbf-' ) ? $type : 'wpbf-' . $type;

		if ( 'wpbf-slider' === $this->type ) {
			// The plain slider only takes numbers as limits.
			$this->min = isset( $args['min'] ) && is_numeric( $args['min'] ) ? (float) $args['min'] : self::DEFAULT_MIN;
			$this->max = isset( $args['max'] ) && is_numeric( $args['max'] ) ? (float) $args['max'] : self::DEFAULT_MAX;
		} else {
			// The input sliders also take limits with a unit ("10px").
			$number_util = new NumberUtil();

			$this->min = isset( $args['min'] ) ? $number_util->makeSureValueIsNumber( $args['min'] ) : self::DEFAULT_MIN;
			$this->max = isset( $args['max'] ) ? $number_util->makeSureValueIsNumber( $args['max'] ) : self::DEFAULT_MAX;
		}

		if ( $this->min > $this->max ) {
			$this->max = $this->min;
		}

		if ( isset( $args['step'] ) && is_numeric( $args['step'] ) ) {
			$this->step = (float) $args['step'];
		}

		if ( $this->isResponsive() ) {
			$this->devices      = ! empty( $args['devices'] ) && is_array( $args['devices'] ) ? $args['devices'] : self::DEFAULT_DEVICES;
			$this->save_as_json = ! empty( $args['save_as_json'] ) && is_bool( $args['save_as_json'] );
		}

	}

	/**
	 * Whether this is the responsive slider.
	 *
	 * @return bool
	 */
	public function isResponsive() {

		return 'wpbf-responsive-input-slider' === $this->type;

	}

	/**
	 * Clean a value to the stored format of the type.
	 *
	 * @param mixed $value The value.
	 *
	 * @return int|float|string|array
	 */
	public function clean( $value ) {

		$number_util = new NumberUtil();

		if ( 'wpbf-slider' === $this->type ) {
			return $number_util->limitNumber( $value, $this->min, $this->max );
		}

		if ( ! $this->isResponsive() ) {
			return $number_util->limitNumberWithUnit( $value, $this->min, $this->max );
		}

		$devices_value = $this->toDevicesValue( $value );

		return $this->save_as_json ? wp_json_encode( $devices_value ) : $devices_value;

	}

	/**
	 * Turn a value into one value per device (responsive slider).
	 *
	 * Takes an array or JSON text; a single number becomes the first device's value.
	 *
	 * @param mixed $raw_value The value.
	 *
	 * @return array
	 */
	private function toDevicesValue( $raw_value ) {

		$value = is_array( $raw_value ) ? $raw_value : null;

		if ( is_string( $raw_value ) ) {
			$decoded = json_decode( $raw_value, true );
			$value   = is_array( $decoded ) ? $decoded : null;
		}

		if ( null === $value ) {
			$value = array();

			if ( ! empty( $this->devices ) && is_numeric( $raw_value ) ) {
				$value[ $this->devices[0] ] = (float) $raw_value;
			}
		}

		$number_util   = new NumberUtil();
		$devices_value = array();

		foreach ( $this->devices as $device ) {
			// An empty value is allowed.
			$devices_value[ $device ] = $number_util->limitNumberWithUnit( isset( $value[ $device ] ) ? $value[ $device ] : '', $this->min, $this->max );
		}

		return $devices_value;

	}

}
