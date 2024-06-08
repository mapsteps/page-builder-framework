<?php
/**
 * Wpbf customizer.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer;

defined( 'ABSPATH' ) || die( "Can't access directly" );

use Mapsteps\Wpbf\Customizer\Controls\Repeater\RepeaterSetting;
use Mapsteps\Wpbf\Customizer\Controls\Typography\TypographyStore;
use Mapsteps\Wpbf\Customizer\Output\FontsOutput;
use WP_Customize_Manager;

/**
 * Singleton class for Wpbf customizer.
 */
final class Customizer {

	/**
	 * Customizer utility helper.
	 *
	 * @var CustomizerUtil
	 */
	public $customizer_util;

	/**
	 * Customizer constructor.
	 */
	public function __construct() {

		$this->customizer_util = new CustomizerUtil();

	}

	/**
	 * Initialize the class, setup hooks.
	 *
	 * @return void
	 */
	public function init() {

		/**
		 * Added with priority 5 to ensure that the 'section-tab' fields will be added
		 * in the next priority where 'register_wpbf_customizer' is called.
		 */
		add_action( 'customize_register', array( $this, 'add_section_tabs' ), 5 );

		add_action( 'customize_register', array( $this, 'register_wpbf_customizer' ) );
		add_action( 'customize_preview_init', array( $this, 'customize_preview_init' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'register_tooltips' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'js_vars_for_controls' ) );

	}

	/**
	 * Output the customizer.
	 *
	 * @return void
	 */
	public function output() {

		( new FontsOutput() )->init();

	}

	/**
	 * Add section tabs by adding 'section-tab' fields.
	 *
	 * These 'section-tab' fields are added by hooking it to 'customize_register' action with priority 5.
	 * The reason was to allow 'section-tab' fields to be added via Premium Add-On.
	 * It's fine, because these fields are basically just a visual fields.
	 *
	 * @return void
	 */
	public function add_section_tabs() {

		foreach ( CustomizerStore::$added_section_tabs as $section_id => $section_tabs ) {
			if ( empty( $section_tabs ) ) {
				continue;
			}

			wpbf_customizer_field()
				->id( 'wpbf_section_tabs_' . $section_id )
				->type( 'section-tabs' )
				->priority( -1 )
				->choices( $section_tabs )
				->addToSection( $section_id );
		}

	}

	/**
	 * Register the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager Instance of WP_Customize_Manager.
	 *
	 * @return void
	 */
	public function register_wpbf_customizer( $wp_customize_manager ) {

		$this->register_control_types( $wp_customize_manager );
		$this->register_settings( $wp_customize_manager );
		$this->register_panels( $wp_customize_manager );
		$this->register_sections( $wp_customize_manager );
		$this->register_controls( $wp_customize_manager );
		$this->register_selective_refreshes( $wp_customize_manager );

		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_custom_panel_types' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_custom_section_types' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'register_control_dependencies' ) );

	}

	/**
	 * Enqueue customize preview scripts.
	 *
	 * @return void
	 */
	public function customize_preview_init() {

		$customizer_util = new CustomizerUtil();

		foreach ( CustomizerStore::$added_controls as $control ) {
			$customizer_util->enqueuePreviewScripts( $control );
		}

	}

	/**
	 * Register the customizer control types.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager Instance of WP_Customize_Manager.
	 */
	public function register_control_types( $wp_customize_manager ) {

		if ( empty( CustomizerStore::$controls_using_content_template ) || ! is_array( CustomizerStore::$controls_using_content_template ) ) {
			return;
		}

		foreach ( CustomizerStore::$controls_using_content_template as $control_type => $class_path ) {
			if ( ! class_exists( $class_path ) ) {
				continue;
			}

			$wp_customize_manager->register_control_type( $class_path );
		}

	}

	/**
	 * Register the customizer settings.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager Instance of WP_Customize_Manager.
	 *
	 * @return void
	 */
	private function register_settings( $wp_customize_manager ) {

		foreach ( CustomizerStore::$added_settings as $setting ) {
			if ( 'repeater' === $setting->control_type ) {
				$wp_customize_manager->add_setting(
					new RepeaterSetting(
						$wp_customize_manager,
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
					)
				);

				continue;
			}

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

		foreach ( CustomizerStore::$added_panels as $panel ) {
			$panel_args = array(
				'type'            => $panel->type,
				'title'           => $panel->title,
				'description'     => $panel->description,
				'capability'      => $panel->capability,
				'priority'        => $panel->priority,
				'active_callback' => $panel->active_callback,
			);

			if ( ! empty( $panel->parent_id ) ) {
				$panel_args['parent_id'] = $panel->parent_id;
			}

			$wp_customize_manager->add_panel( $this->customizer_util->getPanelInstance(
				$panel->type,
				$wp_customize_manager,
				$panel->id,
				$panel_args
			) );
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

		foreach ( CustomizerStore::$added_sections as $section ) {
			$section_args = array(
				'panel'           => $section->panel_id,
				'title'           => $section->title,
				'description'     => $section->description,
				'capability'      => $section->capability,
				'priority'        => $section->priority,
				'active_callback' => $section->active_callback,
			);

			if ( ! empty( $section->parent_id ) ) {
				$section_args['parent_id'] = $section->parent_id;
			}

			$props = $section->custom_properties;
			$args  = wp_parse_args( $props, $section_args );

			$wp_customize_manager->add_section( $this->customizer_util->getSectionInstance(
				$section->type,
				$wp_customize_manager,
				$section->id,
				$args
			) );
		}

	}

	/**
	 * Enqueue custom panel types.
	 *
	 * @return void
	 */
	public function enqueue_custom_panel_types() {

		// Enqueue the scripts.
		wp_enqueue_script( 'wpbf-panels', WPBF_THEME_URI . '/Customizer/Panels/dist/panel-types-min.js', array( 'customize-controls' ), WPBF_VERSION, false );

	}

	/**
	 * Enqueue custom section types.
	 *
	 * @return void
	 */
	public function enqueue_custom_section_types() {

		// Enqueue the styles.
		wp_enqueue_style( 'wpbf-sections', WPBF_THEME_URI . '/Customizer/Sections/dist/section-types-min.css', array(), WPBF_VERSION );

		// Enqueue the scripts.
		wp_enqueue_script( 'wpbf-sections', WPBF_THEME_URI . '/Customizer/Sections/dist/section-types-min.js', array( 'customize-controls' ), WPBF_VERSION, false );

	}

	/**
	 * Register control's tooltips.
	 *
	 * @return void
	 */
	public function register_tooltips() {

		/**
		 * Tooltips
		 *
		 * @var array[] $tooltips
		 */
		$tooltips = [];

		foreach ( CustomizerStore::$added_controls as $control ) {
			if ( ! empty( $control->tooltip ) ) {
				$tooltips[] = [
					'id'      => sanitize_key( $control->id ),
					'content' => wp_kses_post( $control->tooltip ),
				];
			}
		}

		wp_localize_script( 'wpbf-base-control', 'wpbfCustomizerTooltips', $tooltips );

	}

	/**
	 * Add one time global JS vars for controls.
	 *
	 * @return void
	 */
	public function js_vars_for_controls() {

		if ( is_array( TypographyStore::$added_control_ids ) ) {
			wp_localize_script( 'wpbf-typography-control', 'wpbfTypographyControlIds', TypographyStore::$added_control_ids );
		}

		wp_localize_script(
			'wpbf-dimension-control',
			'wpbfDimensionControlL10n',
			[
				'invalid-value' => esc_html__( 'Invalid Value', 'page-builder-framework' ),
			]
		);

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

		foreach ( CustomizerStore::$added_controls as $control ) {
			$customizer_util->addControl( $wp_customize_manager, $control );
		}

	}

	/**
	 * Register the customizer control dependencies.
	 *
	 * @return void
	 */
	public function register_control_dependencies() {

		wp_localize_script( 'wpbf-base-control', 'wpbfCustomizerControlDependencies', CustomizerStore::$added_control_dependencies );

	}

	/**
	 * Register the customizer selective refreshes.
	 *
	 * @param WP_Customize_Manager $wp_customize_manager Instance of WP_Customize_Manager.
	 *
	 * @return void
	 */
	public function register_selective_refreshes( $wp_customize_manager ) {

		foreach ( CustomizerStore::$added_partial_refreshes as $partial_refresh ) {
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
