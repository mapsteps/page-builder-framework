<?php
/**
 * Aura customizer's section entity.
 *
 * @package Aura
 */

namespace Mapsteps\Aura\Customizer\Entities;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * The properties of an Aura customizer's section.
 */
class AuraSectionEntity {

	/**
	 * Section id.
	 *
	 * @var string
	 */
	public $id;

	/**
	 * Section title.
	 *
	 * @var string
	 */
	public $title;

	/**
	 * Section description.
	 *
	 * @var string
	 */
	public $description = '';

	/**
	 * Section capability.
	 *
	 * @var string
	 */
	public $capability = '';

	/**
	 * Section priority.
	 *
	 * @var int
	 */
	public $priority = 0;

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
	 * Section panel id.
	 *
	 * @var string
	 */
	public $panel_id;

}
