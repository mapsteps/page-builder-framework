<?php
/**
 * Custom Menu
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$wrapper = get_theme_mod( 'mobile_menu_options' ) != 'menu-mobile-elementor' ? '<div class="wpbf-visible-large">' : false;
$wrapper_close = get_theme_mod( 'mobile_menu_options' ) != 'menu-mobile-elementor' ? '</div>' : false;

echo $wrapper; // WPCS: XSS ok.

$custom_menu = get_theme_mod( 'menu_custom' );
echo do_shortcode( $custom_menu );

echo $wrapper_close; // WPCS: XSS ok.

?>