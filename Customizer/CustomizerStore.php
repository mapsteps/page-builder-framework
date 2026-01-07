<?php

namespace Mapsteps\Wpbf\Customizer;

defined( 'ABSPATH' ) || die( "Can't access directly" );

use Mapsteps\Wpbf\Customizer\Entities\CustomizerControlEntity;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerPanelEntity;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerSectionEntity;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerSettingEntity;
use Mapsteps\Wpbf\Customizer\Entities\PartialRefreshEntity;
use Mapsteps\Wpbf\Customizer\FooterBuilder\FooterBuilderOutput;
use Mapsteps\Wpbf\Customizer\HeaderBuilder\HeaderBuilderOutput;

/**
 * Singleton class to store customizer data.
 */
final class CustomizerStore {

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
	 * Added section dependencies.
	 *
	 * @var array
	 */
	public static $added_section_dependencies = array();

	/**
	 * Added controls.
	 *
	 * @var CustomizerControlEntity[]
	 */
	public static $added_controls = array();

	/**
	 * Added control dependencies.
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
	 * Array of 'control-type' => 'ControlClassPath' of controls that render their content
	 * using Underscore.js template inside of `content_template` method.
	 *
	 * @var array
	 */
	public static $controls_using_content_template = array();

	/**
	 * Header builder output instance.
	 *
	 * @var HeaderBuilderOutput
	 */
	private static $header_builder_output_instance;

	/**
	 * Footer builder output instance.
	 *
	 * @var FooterBuilderOutput
	 */
	private static $footer_builder_output_instance;

	/**
	 * Get header builder output instance.
	 *
	 * @return HeaderBuilderOutput
	 */
	public static function headerBuilderOutputInstance() {

		if ( ! self::$header_builder_output_instance ) {
			self::$header_builder_output_instance = new HeaderBuilderOutput();
		}

		return self::$header_builder_output_instance;

	}

	/**
	 * Get footer builder output instance.
	 *
	 * @return FooterBuilderOutput
	 */
	public static function footerBuilderOutputInstance() {

		if ( ! self::$footer_builder_output_instance ) {
			self::$footer_builder_output_instance = new FooterBuilderOutput();
		}

		return self::$footer_builder_output_instance;

	}

	/**
	 * Find added setting by control id.
	 *
	 * @param string $control_id Control id.
	 *
	 * @return CustomizerSettingEntity|null
	 */
	public static function findSettingByControlId( $control_id ) {

		foreach ( self::$added_settings as $setting ) {
			if ( $setting->id === $control_id ) {
				return $setting;
			}
		}

		return null;

	}

	/**
	 * Find added partial refresh entities by control id.
	 *
	 * @param string $control_id Control id.
	 *
	 * @return PartialRefreshEntity[]
	 */
	public static function findPartialRefreshesByControlId( $control_id ) {

		$partial_refreshes = array();

		foreach ( self::$added_partial_refreshes as $partial_refresh ) {
			if ( $partial_refresh->control_id === $control_id ) {
				$partial_refreshes[] = $partial_refresh;
			}
		}

		return $partial_refreshes;

	}

	/**
	 * Find a control by its control ID.
	 *
	 * @param string $control_id The control ID.
	 * @return Control|null The control, or null if not found.
	 */
	public static function findControl( $control_id ) {

		foreach ( self::$added_controls as $added_control ) {
			if ( $added_control->id === $control_id ) {
				return $added_control;
			}
		}

		return null;

	}

}
