<?php
/**
 * Aura customizer panel.
 *
 * @package Aura
 */

namespace Mapsteps\Aura\Customizer;

use Mapsteps\Aura\Customizer\Entities\AuraPanelEntity;

/**
 * Class to add Aura customizer panel.
 */
final class AuraCustomizerPanel {

	/**
	 * The panel entity object.
	 *
	 * @var AuraPanelEntity
	 */
	private $panel;

	/**
	 * Set the panel id.
	 *
	 * @param string $id Panel id.
	 *
	 * @return $this
	 */
	public function id( $id ) {

		$this->panel->id = $id;

		return $this;

	}

	/**
	 * Set the panel priority.
	 *
	 * @param int $priority Panel priority.
	 *
	 * @return $this
	 */
	public function priority( $priority ) {

		$this->panel->priority = $priority;

		return $this;

	}

	/**
	 * Set the panel capability.
	 *
	 * @param string $capability Panel capability.
	 *
	 * @return $this
	 */
	public function capability( $capability ) {

		$this->panel->capability = $capability;

		return $this;

	}

	/**
	 * Set the panel title.
	 *
	 * @param string $title Panel title.
	 *
	 * @return $this
	 */
	public function title( $title ) {

		$this->panel->title = $title;

		return $this;

	}

	/**
	 * Set the panel description.
	 *
	 * @param string $description Panel description.
	 *
	 * @return $this
	 */
	public function description( $description ) {

		$this->panel->description = $description;

		return $this;

	}

	/**
	 * Set the panel active callback.
	 *
	 * Callback will be called with one parameter which is the instance of WP_Customize_Panel.
	 * It should return boolean to indicate whether the section is active or not.
	 *
	 * @param callable $active_callback Panel active callback.
	 *
	 * @return $this
	 */
	public function activeCallback( $active_callback ) {

		$this->panel->active_callback = $active_callback;

		return $this;

	}

	/**
	 * Add the panel to the singleton.
	 *
	 * @return AuraPanelEntity
	 */
	public function add() {

		AuraCustomizer::$added_panels[] = $this->panel;

		return $this->panel;

	}

}
