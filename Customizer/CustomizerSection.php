<?php
/**
 * Wpbf customizer section.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer;

use Mapsteps\Wpbf\Customizer\Entities\CustomizerSectionEntity;

/**
 * Class to add Wpbf customizer section.
 */
final class CustomizerSection {

	/**
	 * The section entity object.
	 *
	 * @var CustomizerSectionEntity
	 */
	private $section;

	/**
	 * Construct the class.
	 */
	public function __construct() {

		$this->section = new CustomizerSectionEntity();

	}

	/**
	 * Set the section id.
	 *
	 * @param string $id Section id.
	 *
	 * @return $this
	 */
	public function id( $id ) {

		$this->section->id = $id;

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

		$this->section->priority = $priority;

		return $this;

	}

	/**
	 * Set the section capability.
	 *
	 * @param string $capability Section capability.
	 *
	 * @return $this
	 */
	public function capability( $capability ) {

		$this->section->capability = $capability;

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

		$this->section->title = $title;

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

		$this->section->description = $description;

		return $this;

	}

	/**
	 * Set the section active callback.
	 *
	 * Callback will be called with one parameter which is the instance of WP_Customize_Section.
	 * It should return boolean to indicate whether the section is active or not.
	 *
	 * @param callable $active_callback Section active callback.
	 *
	 * @return $this
	 */
	public function activeCallback( $active_callback ) {

		$this->section->active_callback = $active_callback;

		return $this;

	}

	/**
	 * Add the section to a panel.
	 *
	 * @param string $panel_id Panel id.
	 *
	 * @return CustomizerSectionEntity
	 */
	public function addToPanel( $panel_id ) {

		$this->section->panel_id = $panel_id;

		Customizer::$added_sections[] = $this->section;

		return new CustomizerSectionEntity();

	}

}