<?php
/**
 * Wpbf customizer.
 *
 * @package Wpbf
 */

namespace Mapsteps\Wpbf\Customizer;

defined( 'ABSPATH' ) || die( "Can't access directly" );

use Mapsteps\Wpbf\Customizer\Controls\Builder\BuilderStore;
use Mapsteps\Wpbf\Customizer\Controls\Bundle\ControlsBundleLoader;
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
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_section_assets' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'register_control_dependencies' ) );

	}

	/**
	 * Enqueue customize preview scripts.
	 *
	 * @return void
	 */
	public function customize_preview_init() {

		wp_enqueue_style( 'wpbf-customize-preview', WPBF_THEME_URI . '/inc/customizer/css/customize-preview.css', array(), WPBF_VERSION );

		// Enqueue bundled preview scripts.
		( new ControlsBundleLoader() )->enqueuePreview();

		add_action( 'body_open', array( $this, 'premium_add_on_notice' ) );

	}

	/**
	 * Premium Add-On notice inside customize preview screen.
	 *
	 * @return void
	 */
	public function premium_add_on_notice() {

		if ( wpbf_is_premium() ) {
			return;
		}
		?>

		<div class="wpbf-premium-notice">
			<?php _e( 'This feature is available in Ultimate Dashboard PRO.', 'ultimate-dashboard' ); ?>
			<a href="https://ultimatedashboard.io/docs/login-customizer/?utm_source=plugin&utm_medium=login_customizer_bar&utm_campaign=udb" class="wpbf-button wpbf-button-primary wpbf-premium-notice-button" target="_blank">
				<?php _e( 'Get Ultimate Dashboard PRO', 'ultimate-dashboard' ); ?>
			</a>
		</div>

		<?php

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

			if ( ! empty( $section->tabs ) ) {
				$props['tabs'] = $section->tabs;
			}

			$args = wp_parse_args( $props, $section_args );

			$section_instance = $this->customizer_util->getSectionInstance(
				$section->type,
				$wp_customize_manager,
				$section->id,
				$args
			);

			if ( property_exists( $section_instance, 'class_path' ) && ! empty( $section_instance->class_path ) ) {
				$wp_customize_manager->register_section_type( $section_instance->class_path );
			}

			$wp_customize_manager->add_section( $section_instance );
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
	 * Enqueue style & scripts related to customize sections.
	 *
	 * @return void
	 */
	public function enqueue_section_assets() {

		// Enqueue the styles.
		wp_enqueue_style( 'wpbf-sections', WPBF_THEME_URI . '/Customizer/Sections/dist/sections-min.css', array(), WPBF_VERSION );

		// Enqueue the scripts.
		wp_enqueue_script( 'wpbf-sections', WPBF_THEME_URI . '/Customizer/Sections/dist/sections-min.js', array( 'customize-controls' ), WPBF_VERSION, false );

		wp_localize_script( 'wpbf-sections', 'wpbfCustomizerSectionDependencies', CustomizerStore::$added_section_dependencies );

		wp_add_inline_script( 'wpbf-sections', 'window.WpbfCustomizeSection = {};', 'before' );

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

		wp_localize_script( 'wpbf-controls-bundle', 'wpbfCustomizerTooltips', $tooltips );

	}

	/**
	 * Add one time global JS vars for controls.
	 *
	 * @return void
	 */
	public function js_vars_for_controls() {

		if ( is_array( TypographyStore::$added_control_ids ) ) {
			wp_localize_script( 'wpbf-controls-bundle', 'wpbfTypographyControlIds', TypographyStore::$added_control_ids );
		}

		wp_localize_script(
			'wpbf-controls-bundle',
			'wpbfDimensionControlL10n',
			[
				'invalid-value' => esc_html__( 'Invalid Value', 'page-builder-framework' ),
			]
		);

		if ( is_array( BuilderStore::$added_control_ids ) ) {
			wp_localize_script( 'wpbf-controls-bundle', 'wpbfBuilderControlIds', BuilderStore::$added_control_ids );
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
