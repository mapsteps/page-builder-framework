<?php
/**
 * Elementor Pro integration.
 *
 * @package Page Builder Framework
 * @subpackage Integration
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Register Elementor locations.
 *
 * @param object $elementor_theme_manager The elementor theme manager.
 */
function wpbf_elementor_locations( $elementor_theme_manager ) {

	// Header.
	$elementor_theme_manager->register_location(
		'header',
		[
			'hook'         => 'wpbf_header',
			'remove_hooks' => ['wpbf_do_header'],
		]
	);

	$elementor_theme_manager->register_location(
		'before-header',
		[
			'label'    => __( 'Before Header', 'page-builder-framework' ),
			'multiple' => true,
			'hook'     => 'wpbf_before_header',
		]
	);

	$elementor_theme_manager->register_location(
		'pre-header',
		[
			'label'        => __( 'Pre Header', 'page-builder-framework' ),
			'multiple'     => true,
			'hook'         => 'wpbf_before_header',
			'remove_hooks' => ['wpbf_do_pre_header'],
		]
	);

	$elementor_theme_manager->register_location(
		'after-header',
		[
			'label'    => __( 'After Header', 'page-builder-framework' ),
			'multiple' => true,
			'hook'     => 'wpbf_after_header',
		]
	);

	// Footer.
	$elementor_theme_manager->register_location(
		'footer',
		[
			'hook'         => 'wpbf_footer',
			'remove_hooks' => ['wpbf_do_footer'],
		]
	);

	$elementor_theme_manager->register_location(
		'before-footer',
		[
			'label'    => __( 'Before Footer', 'page-builder-framework' ),
			'multiple' => true,
			'hook'     => 'wpbf_before_footer',
		]
	);

	$elementor_theme_manager->register_location(
		'after-footer',
		[
			'label'    => __( 'After Footer', 'page-builder-framework' ),
			'multiple' => true,
			'hook'     => 'wpbf_after_footer',
		]
	);

	// Article.
	$elementor_theme_manager->register_location(
		'before-post',
		[
			'label'    => __( 'Before Post', 'page-builder-framework' ),
			'multiple' => true,
			'hook'     => 'wpbf_before_article',
		]
	);

	$elementor_theme_manager->register_location(
		'after-post',
		[
			'label'    => __( 'After Post', 'page-builder-framework' ),
			'multiple' => true,
			'hook'     => 'wpbf_after_article',
		]
	);

	// Sidebar.
	$elementor_theme_manager->register_location(
		'before-sidebar',
		[
			'label'    => __( 'Before Sidebar', 'page-builder-framework' ),
			'multiple' => true,
			'hook'     => 'wpbf_sidebar_open',
		]
	);

	$elementor_theme_manager->register_location(
		'after-sidebar',
		[
			'label'    => __( 'After Sidebar', 'page-builder-framework' ),
			'multiple' => true,
			'hook'     => 'wpbf_sidebar_close',
		]
	);

}
add_action( 'elementor/theme/register_locations', 'wpbf_elementor_locations' );
