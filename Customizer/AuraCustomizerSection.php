<?php
/**
 * Aura customizer section.
 *
 * @package Aura
 */

namespace Mapsteps\Aura\Customizer;

use Mapsteps\Aura\Customizer\Entities\AuraSectionEntity;

/**
 * Class to add Aura customizer section.
 */
final class AuraCustomizerSection {

	/**
	 * Set the section id.
	 *
	 * @param string $id Section id.
	 *
	 * @return $this
	 */
	public function id( $id ) {

		return $this;

	}

	/**
	 * Set the section title.
	 *
	 * @param string $title Section title.
	 *
	 * @return $this
	 */
	public function title( $title ) {

		return $this;

	}

	/**
	 * Set the section description.
	 *
	 * @param string $description Section description.
	 *
	 * @return $this
	 */
	public function description( $description ) {

		return $this;

	}

	/**
	 * Set the section priority.
	 *
	 * @param int $priority Section priority.
	 *
	 * @return $this
	 */
	public function priority( $priority ) {

		return $this;

	}

	/**
	 * Add the section to a panel.
	 *
	 * @param string $panel_id Panel id.
	 *
	 * @return AuraSectionEntity
	 */
	public function addToPanel( $panel_id ) {

		return new AuraSectionEntity();

	}

}