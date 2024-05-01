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
	 * Tabs for the section.
	 *
	 * @var array
	 */
	private $section_tabs = [];

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

		if ( ! empty( $id ) && is_string( $id ) ) {
			$this->section->id = $id;
		}

		return $this;

	}

	/**
	 * Set the section parent id.
	 *
	 * @param string $id Section parent id.
	 *
	 * @return $this
	 */
	public function parentId( $id ) {

		if ( ! empty( $id ) && is_string( $id ) ) {
			$this->section->parent_id = $id;
		}

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

		if ( is_int( $priority ) ) {
			$this->section->priority = $priority;
		}

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

		if ( ! empty( $capability ) && is_string( $capability ) ) {
			$this->section->capability = $capability;
		}

		return $this;

	}

	/**
	 * Set the section type.
	 *
	 * @param string $type Section type.
	 *
	 * @return $this
	 */
	public function type( $type ) {

		if ( ! empty( $type ) && is_string( $type ) ) {
			$this->section->type = $type;
		}

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

		if ( ! empty( $title ) && is_string( $title ) ) {
			$this->section->title = $title;
		}

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

		if ( ! empty( $description ) && is_string( $description ) ) {
			$this->section->description = $description;
		}

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

		if ( ! empty( $active_callback ) && is_callable( $active_callback ) ) {
			$this->section->active_callback = $active_callback;
		}

		return $this;

	}

	/**
	 * Define tabs for the section.
	 *
	 * @param array $tabs Tabs for the section.
	 */
	public function tabs( $tabs ) {

		if ( ! empty( $tabs ) && is_array( $tabs ) ) {
			$this->section_tabs = $tabs;
		}

		return $this;

	}

	/**
	 * Set the control's custom_properties.
	 *
	 * @param array $properties Custom properties which are not provided by WP_Customize_Control by default.
	 *
	 * @return $this
	 */
	public function customProperties( $properties = array() ) {

		if ( ! empty( $properties ) && is_array( $properties ) ) {
			$this->section->custom_properties = $properties;
		}

		return $this;

	}

	/**
	 * Add the section without a panel.
	 *
	 * @return CustomizerSectionEntity
	 */
	public function add() {

		return $this->addToPanel( '' );

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

		CustomizerStore::$added_sections[] = $this->section;

		if ( ! empty( $this->section_tabs ) ) {
			CustomizerStore::$added_section_tabs[ $this->section->id ] = $this->section_tabs;
		}

		return $this->section;

	}

}
