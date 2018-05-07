<?php
/**
 * Tagline
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$site_description = get_bloginfo( 'description' );
$site_description_toggle = get_theme_mod( 'menu_logo_description' );
$menu_logo = get_theme_mod( 'custom_logo' );

if( ! empty( $site_description ) && $site_description_toggle && !$menu_logo ) {

	echo '<div class="wpbf-tagline">'. esc_html( $site_description ) .'</div>';

}