<?php
/**
 * Mobile logo.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$menu_logo_url = get_theme_mod( 'menu_logo_url', home_url() );
$menu_logo_url = is_customize_preview() ? site_url() : $menu_logo_url;

if ( has_custom_logo() ) {

	$menu_alt_tag     = get_theme_mod( 'menu_logo_alt', get_bloginfo( 'name' ) );
	$menu_title_tag   = get_theme_mod( 'menu_logo_title', get_bloginfo( 'name' ) );
	$custom_logo_id   = get_theme_mod( 'custom_logo' );
	$custom_logo_data = wp_get_attachment_image_src( $custom_logo_id, 'full' );
	$custom_logo_url  = apply_filters( 'wpbf_logo_mobile', $custom_logo_data[0] );

	if ( $custom_logo_data[0] !== $custom_logo_url ) {

		if ( function_exists( 'attachment_url_to_postid' ) ) {

			$custom_logo_id   = attachment_url_to_postid( $custom_logo_url );
			$custom_logo_data = wp_get_attachment_image_src( $custom_logo_id, 'full' );

		}

	}

	$custom_logo_width  = $custom_logo_data[1];
	$custom_logo_height = $custom_logo_data[2];
	// $custom_logo_srcset = wp_get_attachment_image_srcset( $custom_logo_id, 'full' );
	// $custom_logo_sizes  = wp_get_attachment_image_sizes( $custom_logo_id, 'full' );

	echo '<div class="wpbf-mobile-logo" itemscope="itemscope" itemtype="https://schema.org/Organization">';
	do_action( 'wpbf_before_mobile_logo' );
	echo '<a href="' . esc_url( $menu_logo_url ) . '" itemprop="url">';
	echo '<img src="' . esc_url( $custom_logo_url ) . '" alt="' . esc_attr( $menu_alt_tag ) . '" title="' . esc_attr( $menu_title_tag ) . '" width="' . esc_attr( $custom_logo_width ) . '" height="' . esc_attr( $custom_logo_height ) . '" itemprop="logo" />';
	echo '</a>';
	do_action( 'wpbf_after_mobile_logo' );
	echo '</div>';

} else {

	$tagline        = get_bloginfo( 'description' );
	$tagline_toggle = get_theme_mod( 'menu_logo_description_mobile' );

	echo '<div class="wpbf-mobile-logo" itemscope="itemscope" itemtype="https://schema.org/Organization">';
	do_action( 'wpbf_before_mobile_logo' );
	echo '<span class="site-title" itemprop="name">';
	echo '<a href="' . esc_url( $menu_logo_url ) . '" rel="home" itemprop="url">' . esc_html( get_bloginfo( 'name' ) ) . '</a>';
	echo '</span>';
	do_action( 'wpbf_after_mobile_logo' );
	if ( ! empty( $tagline ) && $tagline_toggle ) {
		echo '<p class="site-description wpbf-tagline" itemprop="description">' . esc_html( $tagline ) . '</p>';
	}
	echo '</div>';

}
