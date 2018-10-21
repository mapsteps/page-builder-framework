<?php
/**
 * Logo
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$menu_active_logo = get_theme_mod( 'menu_active_logo' ) ? ' data-menu-active-logo='. get_theme_mod( 'menu_active_logo' ) .'' : '';
$menu_alt_tag = get_theme_mod( 'menu_logo_alt', get_bloginfo( 'name' ) );
$menu_title_tag = get_theme_mod( 'menu_logo_title', get_bloginfo( 'name' ) );
$menu_logo_url = get_theme_mod( 'menu_logo_url', home_url() );

$custom_logo_id = get_theme_mod( 'custom_logo' );
$custom_logo_url = wp_get_attachment_image_src( $custom_logo_id , 'full' );
$custom_logo_url = apply_filters( 'wpbf_logo', $custom_logo_url[0] );

if ( has_custom_logo() ) {

	echo '<div class="wpbf-logo"'. esc_html( $menu_active_logo ) .' itemscope="itemscope" itemtype="https://schema.org/Organization">
	<a class="wpbf-remove-font-size" href="'. esc_url( $menu_logo_url ) .'">
	<img src="'. esc_url( $custom_logo_url ) .'" alt="'. esc_attr( $menu_alt_tag ) .'" title="'. esc_attr( $menu_title_tag ) .'">
	</a>
	</div>';

} else {

	echo '<div class="wpbf-logo" itemscope="itemscope" itemtype="https://schema.org/Organization">
	<a href="'. esc_url( $menu_logo_url ) .'">'. esc_html( get_bloginfo( 'name' ) ) .'</a>
	</div>';

}