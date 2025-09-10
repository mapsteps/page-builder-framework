<?php
/**
 * Customizer setup.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Customizer setup.
 *
 * @param object $wp_customize The wp customize object.
 */
function wpbf_customizer_setup( $wp_customize ) {

	// Move sections.
	$wp_customize->get_section( 'title_tagline' )->panel    = 'header_panel';
	$wp_customize->get_section( 'background_image' )->panel = 'layout_panel';

	// Move controls.
	$wp_customize->get_control( 'background_color' )->section = 'background_image';

	// Change section titles.
	$wp_customize->get_section( 'title_tagline' )->title    = __( 'Logo', 'page-builder-framework' );
	$wp_customize->get_section( 'background_image' )->title = __( 'Background', 'page-builder-framework' );

	// Change panel priority.
	$panel = $wp_customize->get_panel( 'nav_menus' );

	if ( $panel ) {
		$panel->priority = 40;
	}

	// Change section priority.
	$wp_customize->get_section( 'background_image' )->priority = 200;

	// Change setting transport method.
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	// Change control priorities.
	$wp_customize->get_control( 'custom_logo' )->priority      = 0;
	$wp_customize->get_control( 'blogname' )->priority         = 9;
	$wp_customize->get_control( 'blogdescription' )->priority  = 19;
	$wp_customize->get_control( 'background_color' )->priority = 100;
	$wp_customize->get_control( 'background_image' )->priority = 0;

	/**
	 * Partial refresh for custom logo.
	 *
	 * This is faking a partial refresh to have an edit icon displayed for the logo.
	 * A partial refresh isn't possible because the logo & mobile logo are the same by default but can be configured differently.
	 * Unfortunately we can't pass multiple arrays with add_partial - this would solve the issue.
	 */
	$wp_customize->selective_refresh->add_partial( 'custom_logo', array(
		'selector' => '.wpbf-logo',
	) );

	// Partial refresh for blogname.
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector'        => '.site-title a',
		'render_callback' => function () {
			bloginfo( 'name' );
		},
	) );

	// Partial refresh for blogdescription.
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector'        => '.wpbf-tagline',
		'render_callback' => function () {
			bloginfo( 'description' );
		},
	) );

}
add_action( 'customize_register', 'wpbf_customizer_setup', 20 );
