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
	 * Section priority.
	 *
	 * @var int
	 */
	public $priority = 0;

	/**
	 * Section panel id.
	 *
	 * @var string
	 */
	public $panel_id;

}
