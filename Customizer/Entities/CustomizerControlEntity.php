<?php
/**
 * Aura customizer's control entity.
 *
 * @package Aura
 */

namespace Mapsteps\Wpbf\Customizer\Entities;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Entity object of an Aura customizer's control.
 *
 * @see https://developer.wordpress.org/reference/classes/WP_Customize_Control/__construct/
 */
class CustomizerControlEntity {

	/**
	 * Control ID.
	 *
	 * @var string
	 */
	public $id;

	/**
	 * All settings tied to the control. If undefined, $id will be used.
	 *
	 * @var array
	 */
	public $settings;

	/**
	 * The primary setting for the control (if there is one).
	 *
	 * @var string
	 */
	public $setting = 'default';

	/**
	 * Control type.
	 *
	 * @var string
	 */
	public $type;

	/**
	 * Capability required to use this control.
	 *
	 * @var string
	 */
	public $capability = 'edit_theme_options';

	/**
	 * Order priority to load the control. Default 10.
	 *
	 * @var int
	 */
	public $priority = 10;

	/**
	 * Section the control belongs to.
	 *
	 * @var string
	 */
	public $section_id = '';

	/**
	 * Label for the control.
	 *
	 * @var string
	 */
	public $label = '';

	/**
	 * Description for the control.
	 *
	 * @var string
	 */
	public $description = '';

	/**
	 * List of choices for multi-choices type controls, where values are the keys, and labels are the values.
	 *
	 * @var array
	 */
	public $choices = array();

	/**
	 * List of custom input attributes for control output, where attribute names are the keys and values are the values.
	 *
	 * @var array
	 */
	public $input_attrs = array();

	/**
	 * Data to export to the client via JSON.
	 *
	 * @var string
	 */
	public $json = '';
}
