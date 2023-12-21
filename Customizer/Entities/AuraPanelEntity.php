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
	 * Panel priority.
	 *
	 * @var int
	 */
	public $priority = 0;

}
