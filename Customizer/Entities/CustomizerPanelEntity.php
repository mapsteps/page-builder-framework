<?php
/**
 * Wpbf customizer's panel entity.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer\Entities;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Entity object of an Wpbf customizer's panel.
 *
 * @see https://developer.wordpress.org/reference/classes/WP_Customize_Panel/__construct/
 */
class CustomizerPanelEntity {

	/**
	 * A specific ID for the panel.
	 *
	 * @var string
	 */
	public $id;

	/**
	 * Type of this panel.
	 *
	 * @var string
	 */
	public $type = '';

	/**
	 * Parent panel id.
	 *
	 * @var string
	 */
	public $parent_id = '';

	/**
	 * Priority of the panel, defining the display order of panels and sections. Default 160.
	 *
	 * @var int
	 */
	public $priority = 160;

	/**
	 * Capability required for the panel. Default is 'edit_theme_options'.
	 *
	 * @var string
	 */
	public $capability = 'edit_theme_options';

	/**
	 * Title of the panel to show in UI.
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
	 * Panel active callback.
	 *
	 * Callback will be called with one parameter which is the instance of WP_Customize_Panel.
	 * It should return boolean to indicate whether the section is active or not.
	 *
	 * @var callable
	 */
	public $active_callback = '';

}
