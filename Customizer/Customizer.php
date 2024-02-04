<?php
/**
 * Wpbf customizer.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer;

defined( 'ABSPATH' ) || die( "Can't access directly" );

use Mapsteps\Wpbf\Customizer\Entities\CustomizerControlEntity;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerPanelEntity;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerSectionEntity;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerSettingEntity;
use Mapsteps\Wpbf\Customizer\Entities\PartialRefreshEntity;
use WP_Customize_Manager;

/**
 * Singleton class for Wpbf customizer.
 */
final class Customizer {

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
	 * Added settings.
	 *
	 * @var CustomizerSettingEntity[]
	 */
	public static $added_settings = array();

	/**
	 * Added panels.
	 *
	 * @var CustomizerPanelEntity[]
	 */
	public static $added_panels = array();

	/**
	 * Added sections.
	 *
	 * @var CustomizerSectionEntity[]
	 */
	public static $added_sections = array();

	/**
	 * Added controls.
	 *
	 * @var CustomizerControlEntity[]
	 */
	public static $added_controls = array();

	/**
	 * Added field dependencies.
	 *
	 * @var array
	 */
	public static $added_control_dependencies = array();

	/**
	 * Added partial refreshes.
	 *
	 * @var PartialRefreshEntity[]
	 */
	public static $added_partial_refreshes = array();

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

		add_action( 'customize_register', array( $this, 'register_wpbf_customizer' ) );

	}

	/**
	 * Register the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager Instance of WP_Customize_Manager.
	 *
	 * @return void
	 */
	public function register_wpbf_customizer( $wp_customize_manager ) {

		$this->register_settings( $wp_customize_manager );
		$this->register_panels( $wp_customize_manager );
		$this->register_sections( $wp_customize_manager );
		$this->register_controls( $wp_customize_manager );
		$this->register_selective_refreshes( $wp_customize_manager );

		add_action( 'customize_controls_enqueue_scripts', array( $this, 'register_control_dependencies' ) );

	}

	/**
	 * Register the customizer settings.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager Instance of WP_Customize_Manager.
	 *
	 * @return void
	 */
	private function register_settings( $wp_customize_manager ) {

		foreach ( self::$added_settings as $setting ) {

			$wp_customize_manager->add_setting(
				$setting->id,
				array(
					'default'              => $setting->default,
					'type'                 => $setting->type,
					'capability'           => $setting->capability,
					'transport'            => $setting->transport,
					'sanitize_callback'    => $setting->sanitize_callback,
					'sanitize_js_callback' => $setting->sanitize_js_callback,
					'validate_callback'    => $setting->validate_callback,
				)
			);

		}

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

		$customizer_util = new CustomizerUtil();

		foreach ( self::$added_controls as $control ) {

			$customizer_util->addControl( $wp_customize_manager, $control );

		}

	}

	/**
	 * Register the customizer control dependencies.
	 *
	 * @return void
	 */
	public function register_control_dependencies() {

		wp_localize_script( 'wpbf-base-control', 'wpbfCustomizerControlDependencies', self::$added_control_dependencies );

	}

	/**
	 * Register the customizer selective refreshes.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager Instance of WP_Customize_Manager.
	 *
	 * @return void
	 */
	public function register_selective_refreshes( $wp_customize_manager ) {

		foreach ( self::$added_partial_refreshes as $partial_refresh ) {

			$wp_customize_manager->selective_refresh->add_partial(
				$partial_refresh->id,
				array(
					'container_inclusive' => $partial_refresh->container_inclusive,
					'selector'            => $partial_refresh->selector,
					'settings'            => $partial_refresh->settings,
					'render_callback'     => $partial_refresh->render_callback,
				)
			);

		}

	}

}
