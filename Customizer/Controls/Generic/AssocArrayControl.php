<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Generic;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;
use WP_Customize_Manager;
use WP_Customize_Setting;

class AssocArrayControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-assoc-array';

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

		if ( ! ( $this->setting instanceof WP_Customize_Setting ) ) {
			return;
		}

		$this->setting->default = static::make_default_value( $this->setting );

	}

	/**
	 * Make default value.
	 *
	 * @param WP_Customize_Setting $setting The setting object.
	 *
	 * @return array
	 */
	public static function make_default_value( $setting ) {

		$default_value = [];

		if ( ! empty( $setting->default ) ) {
			if ( is_string( $setting->default ) ) {
				$decoded = json_decode( $setting->default, true );

				if ( is_array( $decoded ) ) {
					$default_value = $decoded;
				}
			} elseif ( is_array( $setting->default ) ) {
				$default_value = $setting->default;
			}
		}

		return AssocArrayField::sanitize( $default_value, 'block_' );

	}

	/**
	 * The form (label, description, the value's parts) is rendered in the browser (assoc-array-control.tsx).
	 */
	protected function render_content() {
	}

}
