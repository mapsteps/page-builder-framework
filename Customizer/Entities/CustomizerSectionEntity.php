<?php
/**
 * Wpbf customizer's section entity.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Entities;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Entity object of an Wpbf customizer's section.
 *
 * @see https://developer.wordpress.org/reference/classes/WP_Customize_Section/__construct/
 */
class CustomizerSectionEntity {

	/**
	 * A specific ID of the section.
	 *
	 * @var string
	 */
	public $id;

	/**
	 * Parent section id.
	 *
	 * @var string
	 */
	public $parent_id = '';

	/**
	 * Priority of the section, defining the display order of panels and sections. Default 160.
	 *
	 * @var int
	 */
	public $priority = 160;

	/**
	 * The panel id this section belongs to (if any).
	 *
	 * @var string
	 */
	public $panel_id = '';

	/**
	 * Section capability.
	 *
	 * @var string
	 */
	public $capability = 'edit_theme_options';

	/**
	 * Type of this section.
	 *
	 * @var string
	 */
	public $type = '';

	/**
	 * Title of the section to show in UI.
	 *
	 * @var string
	 */
	public $title = '';

	/**
	 * Description to show in the UI.
	 *
	 * @var string
	 */
	public $description = '';


	/**
	 * Section active callback.
	 *
	 * Callback will be called with one parameter which is the instance of WP_Customize_Section.
	 * It should return boolean to indicate whether the section is active or not.
	 *
	 * @var callable
	 */
	public $active_callback = '';

	/**
	 * Custom properties which are not provided by WP_Customize_Section by default.
	 *
	 * @var array
	 */
	public $custom_properties = array();


}
