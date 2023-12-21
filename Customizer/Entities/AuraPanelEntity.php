<?php
/**
 * Aura customizer's panel entity.
 *
 * @package Aura
 */

namespace Mapsteps\Aura\Customizer\Entities;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * The properties of an Aura customizer's panel.
 */
class AuraPanelEntity {

	/**
	 * Panel id.
	 *
	 * @var string
	 */
	public $id;

	/**
	 * Panel title.
	 *
	 * @var string
	 */
	public $title;

	/**
	 * Panel description.
	 *
	 * @var string
	 */
	public $description = '';

	/**
	 * Panel capability.
	 *
	 * @var string
	 */
	public $capability = '';

	/**
	 * Panel priority.
	 *
	 * @var int
	 */
	public $priority = 0;

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
