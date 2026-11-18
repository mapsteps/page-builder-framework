<?php
/**
 * Checkbox control.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Controls\Checkbox;

use Mapsteps\Wpbf\Customizer\Controls\Base\BaseControl;
use WP_Customize_Manager;

/**
 * One control for the checkbox types: wpbf-checkbox (a plain checkbox) and wpbf-toggle (a toggle, or with
 * `checkbox_type` "switch" a switch with on/off labels).
 *
 * The type comes from `$args['type']` (default wpbf-checkbox); the form picks its layout from it (CheckboxForm.tsx).
 */
class CheckboxControl extends BaseControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-checkbox';

	/**
	 * The toggle's look: 'toggle' or 'switch'.
	 *
	 * @var string
	 */
	protected $checkbox_type = 'toggle';

	/**
	 * Allowed checkbox types.
	 *
	 * @var string[]
	 */
	protected $allowed_checkbox_types = [ 'toggle', 'switch' ];

	/**
	 * Constructor.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager Customizer bootstrap instance.
	 * @param string               $id                   Control ID.
	 * @param array                $args                 Control arguments, incl. `type` and for toggles `checkbox_type`.
	 */
	public function __construct( $wp_customize_manager, $id, $args = array() ) {

		parent::__construct( $wp_customize_manager, $id, $args );

		if ( ! empty( $args['checkbox_type'] ) && in_array( $args['checkbox_type'], $this->allowed_checkbox_types, true ) ) {
			$this->checkbox_type = $args['checkbox_type'];
		}

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {

		parent::to_json();

		if ( 'wpbf-toggle' !== $this->type ) {
			return;
		}

		$this->json['checkboxType'] = $this->checkbox_type;

		$this->json['defaultChoices'] = [
			'on'  => __( 'On', 'page-builder-framework' ),
			'off' => __( 'Off', 'page-builder-framework' ),
		];

	}

}
