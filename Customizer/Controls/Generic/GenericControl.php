<?php
/**
 * Generic control.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Generic;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;
use Mapsteps\Wpbf\Customizer\Controls\Responsive\ResponsiveUtil;
use WP_Customize_Manager;
use WP_Customize_Setting;

/**
 * One control for the generic types: wpbf-generic (one field) and wpbf-responsive-generic (one field per device).
 *
 * The field is a text, number, number-unit, textarea, email, password, url, hidden or content field (`subtype`).
 * The type comes from `$args['type']` (default wpbf-generic); the form renders with React (GenericForm.tsx).
 */
class GenericControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-generic';

	/**
	 * Control's subtype.
	 *
	 * Accepts one of this values: "number", "number-unit", "text", "textarea", "email", "password", "url", "hidden", and "content".
	 *
	 * @var string
	 */
	protected $subtype = 'text';

	/**
	 * The allowed 'subtype' property.
	 *
	 * @var string[]
	 */
	public static $allowed_subtypes = [ 'number', 'number-unit', 'text', 'textarea', 'email', 'password', 'url', 'hidden', 'content' ];

	/**
	 * Number of rows for 'textarea' & 'content' subtype.
	 *
	 * @var int
	 */
	protected $rows = 5;

	/**
	 * Minimum value for 'number' and 'number-unit' subtype.
	 *
	 * @var int|float|null
	 */
	public $min = null;

	/**
	 * Maximum value for 'number' and 'number-unit' subtype.
	 *
	 * @var int|float|null
	 */
	public $max = null;

	/**
	 * Increase/decrease step value for 'number' and 'number-unit' subtype.
	 *
	 * @var int|float
	 */
	public $step = 1;

	/**
	 * Responsive only: the devices.
	 *
	 * @var string[]
	 */
	protected $devices = [];

	/**
	 * Responsive only: the device icons.
	 *
	 * @var array
	 */
	protected $device_icons = [];

	/**
	 * Responsive only: whether the value is saved as a JSON encoded string.
	 *
	 * @var bool
	 */
	protected $save_as_json = false;

	/**
	 * Responsive only: the default value per device.
	 *
	 * @var array
	 */
	protected $default_array = [];

	/**
	 * Responsive only: the value per device.
	 *
	 * @var array
	 */
	protected $value_array = [];

	/**
	 * Constructor.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager Customizer bootstrap instance.
	 * @param string               $id                   Control ID.
	 * @param array                $args                 Control arguments, incl. `type`, `subtype`, `min`, `max`, `step`,
	 *                                                   `rows`, and for the responsive type `devices`, `device_icons`
	 *                                                   and `save_as_json`.
	 */
	public function __construct( $wp_customize_manager, $id, $args = array() ) {

		parent::__construct( $wp_customize_manager, $id, $args );

		$number_util = new NumberUtil();

		// Already sanitized in `addControl` method in `GenericField` class.
		if ( ! empty( $args['subtype'] ) ) {
			$this->subtype = $args['subtype'];
		}

		if ( ! in_array( $this->subtype, static::$allowed_subtypes, true ) ) {
			$this->subtype = 'text';
		}

		if ( 'number' === $this->subtype || 'number-unit' === $this->subtype ) {
			$this->min = isset( $args['min'] ) && is_numeric( $args['min'] ) ? (float) $args['min'] : null;
			$this->max = isset( $args['max'] ) && is_numeric( $args['max'] ) ? (float) $args['max'] : null;
			$this->max = $number_util->normalizeMaxValue( $this->min, $this->max );

			if ( isset( $args['step'] ) && is_numeric( $args['step'] ) ) {
				$this->step = (float) $args['step'];
			}
		} elseif ( 'textarea' === $this->subtype || 'content' === $this->subtype ) {
			if ( isset( $args['rows'] ) && is_numeric( $args['rows'] ) ) {
				$this->rows = absint( $args['rows'] );
			}
		}

		if ( $this->isResponsive() ) {
			$this->setUpResponsive( $args );
		} elseif ( $this->setting instanceof WP_Customize_Setting ) {
			$this->setting->default = ( new GenericSanitizer() )->sanitize( $this->subtype, $this->setting->default, $this->min, $this->max );
		}

	}

	/**
	 * Whether this is the responsive type.
	 *
	 * @return bool
	 */
	protected function isResponsive() {

		return 'wpbf-responsive-generic' === $this->type;

	}

	/**
	 * The responsive type's devices, value per device, default and wrapper classes.
	 *
	 * @param array $args The control arguments.
	 */
	protected function setUpResponsive( $args ) {

		$responsive_util = new ResponsiveUtil();

		$this->devices      = ! empty( $args['devices'] ) && is_array( $args['devices'] ) ? $args['devices'] : $responsive_util->default_devices;
		$this->device_icons = ! empty( $args['device_icons'] ) && is_array( $args['device_icons'] ) ? $args['device_icons'] : $responsive_util->default_device_icons;
		$this->save_as_json = ! empty( $args['save_as_json'] ) && is_bool( $args['save_as_json'] );

		if ( ! ( $this->setting instanceof WP_Customize_Setting ) ) {
			return;
		}

		$has_actual_value = $this->value() ? true : false;

		$this->default_array = $responsive_util->toArrayValue( $this->devices, $this->subtype, $this->setting->default, $this->min, $this->max );

		$this->setting->default = $this->save_as_json ? wp_json_encode( $this->default_array ) : $this->default_array;

		$extra_classname = 'wpbf-customize-control-generic wpbf-customize-control-responsive';

		if ( ! empty( $this->wrapper_attrs['class'] ) ) {
			$existing_classname = str_ireplace( '{default_class}', '', $this->wrapper_attrs['class'] );

			$this->wrapper_attrs['class'] = '{default_class} ' . $existing_classname . ' ' . $extra_classname;
		} else {
			$this->wrapper_attrs['class'] = '{default_class} ' . $extra_classname;
		}

		$this->value_array = $has_actual_value ? $responsive_util->toArrayValue( $this->devices, $this->subtype, $this->value(), $this->min, $this->max ) : $this->default_array;

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {

		parent::to_json();

		$this->json['subtype']  = $this->subtype;
		$this->json['inputTag'] = 'textarea' === $this->subtype || 'content' === $this->subtype ? 'textarea' : 'input';

		if ( 'textarea' !== $this->subtype && 'content' !== $this->subtype ) {
			$this->json['inputType'] = 'number-unit' === $this->subtype ? 'text' : $this->subtype;
		}

		if ( 'number' === $this->subtype || 'number-unit' === $this->subtype ) {
			if ( ! is_null( $this->min ) ) {
				$this->json['min'] = $this->min;
			}

			if ( ! is_null( $this->max ) ) {
				$this->json['max'] = $this->max;
			}

			$this->json['step'] = $this->step;
		} elseif ( 'textarea' === $this->subtype || 'content' === $this->subtype ) {
			$this->json['rows'] = $this->rows;
		}

		if ( $this->isResponsive() ) {
			$this->json['defaultArray'] = $this->default_array;
			$this->json['valueArray']   = $this->value_array;
			$this->json['devices']      = $this->devices;
			$this->json['deviceIcons']  = $this->device_icons;
			$this->json['saveAsJson']   = $this->save_as_json;
		}

	}

}
