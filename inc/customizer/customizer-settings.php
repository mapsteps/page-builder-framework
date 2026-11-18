<?php
/**
 * Theme customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Helpers (pluggable sanitize helper, font choices): always available.
require_once WPBF_THEME_DIR . '/inc/customizer/settings/settings-helpers.php';

// The settings themselves are only loaded when the Customizer registers, at this point of the declaration order.
Mapsteps\Wpbf\Customizer\Registry\Registry::add(
	function () {
		require_once WPBF_THEME_DIR . '/inc/customizer/settings/settings-setup.php';
		require_once WPBF_THEME_DIR . '/inc/customizer/settings/settings-compatibility.php';
		require_once WPBF_THEME_DIR . '/inc/customizer/settings/settings-premium.php';
		require_once WPBF_THEME_DIR . '/inc/customizer/settings/settings-general.php';
		require_once WPBF_THEME_DIR . '/inc/customizer/settings/settings-blog.php';
		require_once WPBF_THEME_DIR . '/inc/customizer/settings/settings-typography.php';
		require_once WPBF_THEME_DIR . '/inc/customizer/settings/settings-header.php';
		require_once WPBF_THEME_DIR . '/inc/customizer/settings/settings-footer.php';
	}
);
