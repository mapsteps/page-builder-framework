<?php

namespace Mapsteps\Wpbf\Customizer;

defined( 'ABSPATH' ) || die( "Can't access directly" );

use Mapsteps\Wpbf\Customizer\Entities\CustomizerControlEntity;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerPanelEntity;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerSectionEntity;
use Mapsteps\Wpbf\Customizer\Entities\CustomizerSettingEntity;
use Mapsteps\Wpbf\Customizer\Entities\PartialRefreshEntity;

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
	 * Added section tabs.
	 *
	 * @var array
	 */
	public static $added_section_tabs = array();

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

}
