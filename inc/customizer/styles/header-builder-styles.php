<?php
/**
 * Header builder customizer styles.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

use Mapsteps\Wpbf\Customizer\Controls\Responsive\ResponsiveUtil;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Breakpoint variables brought from styles.php file.
 *
 * Because this header-builder-styles.php file is included in styles.php file,
 * we can use these variables directly.
 *
 * @var int $breakpoint_mobile_int The mobile breakpoint in integer format.
 * @var int $breakpoint_medium_int The medium breakpoint in integer format.
 * @var int $breakpoint_desktop_int The desktop breakpoint in integer format.
 *
 * @var string $breakpoint_mobile The mobile breakpoint with 'px' suffix.
 * @var string $breakpoint_medium The medium breakpoint with 'px' suffix.
 * @var string $breakpoint_desktop The desktop breakpoint with 'px' suffix.
 */


// $menu_trigger_color = get_theme_mod( 'wpbf_header_builder_mobile_menu_trigger_color' );
// $menu_trigger_style = get_theme_mod( 'wpbf_header_builder_mobile_menu_trigger_style', '' );

// if ( $menu_trigger_color ) {
// echo '.wpbf-menu-toggle { color: ' . esc_attr( $menu_trigger_color ) . '; }';
// if ( 'outline' === $menu_trigger_style ) {
// echo '.wpbf-menu-toggle.outline { border-color: ' . esc_attr( $menu_trigger_color ) . '; }';
// }
// }

// Header Rows Styles.
require_once WPBF_THEME_DIR . '/inc/customizer/styles/header-builder-rows-styles.php';

$devices                          = ( new ResponsiveUtil() )->devices();
$header_builder_control_id_prefix = 'wpbf_header_builder_';

// Header Button Styles.
require_once WPBF_THEME_DIR . '/inc/customizer/styles/header-builder-button-styles.php';

// Header Search Styles.
require_once WPBF_THEME_DIR . '/inc/customizer/styles/header-builder-search-styles.php';

// Header Menu Styles.
require_once WPBF_THEME_DIR . '/inc/customizer/styles/header-builder-menu-styles.php';
