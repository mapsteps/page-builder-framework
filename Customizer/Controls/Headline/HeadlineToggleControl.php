<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Headline;

use Mapsteps\Wpbf\Customizer\Controls\Checkbox\CheckboxControl;
use WP_Customize_Manager;

/**
 * A toggle (wpbf-toggle) styled as a section headline.
 */
class HeadlineToggleControl extends CheckboxControl {

	/**
	 * Control's type.
	 *
	 * @var string
	 */
	public $type = 'wpbf-toggle';

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

		$headline_toggle_classname = 'wpbf-customize-control-headline-toggle';

		if ( ! empty( $this->wrapper_attrs['class'] ) ) {
			$existing_classname = $this->wrapper_attrs['class'];
			$existing_classname = str_ireplace( '{default_class}', '', $existing_classname );

			$this->wrapper_attrs['class'] = '{default_class} ' . $existing_classname . ' ' . $headline_toggle_classname;
		} else {
			$this->wrapper_attrs['class'] = '{default_class} ' . $headline_toggle_classname;
		}

	}

}
