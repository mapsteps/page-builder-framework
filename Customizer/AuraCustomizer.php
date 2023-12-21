<?php
/**
 * Aura customizer.
 *
 * @package Aura
 */

namespace Mapsteps\Aura\Customizer;

defined( 'ABSPATH' ) || die( "Can't access directly" );

use Mapsteps\Aura\Customizer\Entities\AuraControlEntity;
use Mapsteps\Aura\Customizer\Entities\AuraPanelEntity;
use Mapsteps\Aura\Customizer\Entities\AuraSectionEntity;
use WP_Customize_Manager;

/**
 * Singleton class for Aura customizer.
 */
final class AuraCustomizer {

	/**
	 * Instance of the class.
	 *
	 * @var self
	 */
	public static $instance;

	/**
	 * Option type.
	 *
	 * @var string
	 */
	public static $option_type = 'theme_mod';

	/**
	 * Capability.
	 *
	 * @var string
	 */
	public static $capability = 'edit_theme_options';

	/**
	 * Added panels.
	 *
	 * @var AuraPanelEntity[]
	 */
	public static $added_panels = array();

	/**
	 * Added sections.
	 *
	 * @var AuraSectionEntity[]
	 */
	public static $added_sections = array();

	/**
	 * Added controls.
	 *
	 * @var AuraControlEntity[]
	 */
	public static $added_controls = array();

	/**
	 * Get the instance of the class.
	 *
	 * @return self
	 */
	public static function get_instance() {

		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

	/**
	 * Initialize the class, setup hooks.
	 *
	 * @return void
	 */
	public function init() {

		add_action( 'customize_register', array( $this, 'register_aura_customizer' ) );

	}

	/**
	 * Register the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager Instance of WP_Customize_Manager.
	 *
	 * @return void
	 */
	public function register_aura_customizer( $wp_customize_manager ) {

		$this->register_panels( $wp_customize_manager );
		$this->register_sections( $wp_customize_manager );
		$this->register_controls( $wp_customize_manager );

	}

	/**
	 * Register the customizer panels.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager Instance of WP_Customize_Manager.
	 *
	 * @return void
	 */
	private function register_panels( $wp_customize_manager ) {

		foreach ( self::$added_panels as $panel ) {

			$wp_customize_manager->add_panel(
				$panel->id,
				array(
					'title'           => $panel->title,
					'description'     => $panel->description,
					'capability'      => $panel->capability,
					'priority'        => $panel->priority,
					'active_callback' => $panel->active_callback,
				)
			);

		}

	}

	/**
	 * Register the customizer sections.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager Instance of WP_Customize_Manager.
	 *
	 * @return void
	 */
	private function register_sections( $wp_customize_manager ) {

		foreach ( self::$added_sections as $section ) {

			$wp_customize_manager->add_section(
				$section->id,
				array(
					'title'           => $section->title,
					'description'     => $section->description,
					'capability'      => $section->capability,
					'priority'        => $section->priority,
					'active_callback' => $section->active_callback,
				)
			);

		}

	}

	/**
	 * Register the customizer controls.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager Instance of WP_Customize_Manager.
	 *
	 * @return void
	 */
	private function register_controls( $wp_customize_manager ) {

		//

	}

}
