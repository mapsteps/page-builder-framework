<?php
/**
 * Wpbf customizer panel.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer;

use Mapsteps\Wpbf\Customizer\Entities\CustomizerPanelEntity;

/**
 * Class to add Wpbf customizer panel.
 */
final class CustomizerPanel {

	/**
	 * The panel entity object.
	 *
	 * @var CustomizerPanelEntity
	 */
	private $panel;

	/**
	 * Construct the class.
	 */
	public function __construct() {

		$this->panel = new CustomizerPanelEntity();

	}

	/**
	 * Set the panel id.
	 *
	 * @param string $id Panel id.
	 *
	 * @return $this
	 */
	public function id( $id ) {

		if ( ! empty( $id ) && is_string( $id ) ) {
			$this->panel->id = $id;
		}

		return $this;

	}

	/**
	 * Set the panel parent id.
	 *
	 * @param string $id Panel parent id.
	 *
	 * @return $this
	 */
	public function parentId( $id ) {

		if ( ! empty( $id ) && is_string( $id ) ) {
			$this->panel->parent_id = $id;
		}

		return $this;

	}

	/**
	 * Set the panel type.
	 *
	 * @param string $type Panel type.
	 *
	 * @return $this
	 */
	public function type( $type ) {

		if ( ! empty( $type ) && is_string( $type ) ) {
			$this->panel->type = $type;
		}

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

		if ( is_int( $priority ) ) {
			$this->panel->priority = $priority;
		}

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

		if ( ! empty( $capability ) && is_string( $capability ) ) {
			$this->panel->capability = $capability;
		}

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

		if ( ! empty( $title ) && is_string( $title ) ) {
			$this->panel->title = $title;
		}

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

		if ( ! empty( $description ) && is_string( $description ) ) {
			$this->panel->description = $description;
		}

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

		if ( ! empty( $active_callback ) && is_callable( $active_callback ) ) {
			$this->panel->active_callback = $active_callback;
		}

		return $this;

	}

	/**
	 * Add the panel to the singleton.
	 *
	 * @return CustomizerPanelEntity
	 */
	public function add() {

		CustomizerStore::$added_panels[] = $this->panel;

		return $this->panel;

	}

}
