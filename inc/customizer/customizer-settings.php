<?php
/**
 * Theme customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Load textdomain. This is required to make strings translatable.
load_theme_textdomain( 'page-builder-framework' );

// Load customizer helpers & setup.
require_once WPBF_THEME_DIR . '/inc/customizer/settings/settings-helpers.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/settings-setup.php';

// Load customizer settings.
require_once WPBF_THEME_DIR . '/inc/customizer/settings/settings-compatibility.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/settings-premium.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/settings-general.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/settings-blog.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/settings-typography.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/settings-header.php';
require_once WPBF_THEME_DIR . '/inc/customizer/settings/settings-footer.php';
