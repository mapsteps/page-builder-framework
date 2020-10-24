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

	// Replace
	$elementor_theme_manager->register_location(
		'pre-header',
		[
			'label'        => __( 'Pre Header (Replace)', 'page-builder-framework' ),
			'hook'         => 'wpbf_before_header',
			'remove_hooks' => ['wpbf_do_pre_header'],
		]
	);

	$elementor_theme_manager->register_location(
		'header',
		[
			'label'        => __( 'Header (Replace)', 'page-builder-framework' ),
			'hook'         => 'wpbf_header',
			'remove_hooks' => ['wpbf_do_header'],
		]
	);

	$elementor_theme_manager->register_location(
		'footer',
		[
			'label'        => __( 'Footer (Replace)', 'page-builder-framework' ),
			'hook'         => 'wpbf_footer',
			'remove_hooks' => ['wpbf_do_footer'],
		]
	);

	$elementor_theme_manager->register_location(
		'before-header',
		[
			'label'    => __( 'Before Header', 'page-builder-framework' ) . ' (wpbf_before_header)',
			'multiple' => true,
			'hook'     => 'wpbf_before_header',
		]
	);

	$elementor_theme_manager->register_location(
		'after-header',
		[
			'label'    => __( 'After Header', 'page-builder-framework' ) . ' (wpbf_after_header)',
			'multiple' => true,
			'hook'     => 'wpbf_after_header',
		]
	);

	// Hooks
	$elementor_theme_manager->register_location(
		'before-content',
		[
			'label'    => __( 'Before Content', 'page-builder-framework' ) . ' (wpbf_content_open)',
			'multiple' => true,
			'hook'     => 'wpbf_content_open',
		]
	);

	$elementor_theme_manager->register_location(
		'after-content',
		[
			'label'    => __( 'After Content', 'page-builder-framework' ) . ' (wpbf_content_close)',
			'multiple' => true,
			'hook'     => 'wpbf_content_close',
		]
	);

	$elementor_theme_manager->register_location(
		'before-inner-content',
		[
			'label'    => __( 'Before Inner Content', 'page-builder-framework' ) . ' (wpbf_inner_content_open)',
			'multiple' => true,
			'hook'     => 'wpbf_inner_content_open',
		]
	);

	$elementor_theme_manager->register_location(
		'after-inner-content',
		[
			'label'    => __( 'After Inner Content', 'page-builder-framework' ) . ' (wpbf_inner_content_close)',
			'multiple' => true,
			'hook'     => 'wpbf_inner_content_close',
		]
	);

	$elementor_theme_manager->register_location(
		'before-main-content',
		[
			'label'    => __( 'Before Main Content', 'page-builder-framework' ) . ' (wpbf_main_content_open)',
			'multiple' => true,
			'hook'     => 'wpbf_main_content_open',
		]
	);

	$elementor_theme_manager->register_location(
		'after-main-content',
		[
			'label'    => __( 'After Main Content', 'page-builder-framework' ) . ' (wpbf_main_content_open)',
			'multiple' => true,
			'hook'     => 'wpbf_main_content_open',
		]
	);

	$elementor_theme_manager->register_location(
		'before-footer',
		[
			'label'    => __( 'Before Footer', 'page-builder-framework' ) . ' (wpbf_before_footer)',
			'multiple' => true,
			'hook'     => 'wpbf_before_footer',
		]
	);

	$elementor_theme_manager->register_location(
		'after-footer',
		[
			'label'    => __( 'After Footer', 'page-builder-framework' ) . ' (wpbf_after_footer)',
			'multiple' => true,
			'hook'     => 'wpbf_after_footer',
		]
	);

	$elementor_theme_manager->register_location(
		'before-post',
		[
			'label'    => __( 'Before Post', 'page-builder-framework' ) . ' (wpbf_before_article)',
			'multiple' => true,
			'hook'     => 'wpbf_before_article',
		]
	);

	$elementor_theme_manager->register_location(
		'after-post',
		[
			'label'    => __( 'After Post', 'page-builder-framework' ) . ' (wpbf_after_article)',
			'multiple' => true,
			'hook'     => 'wpbf_after_article',
		]
	);

	$elementor_theme_manager->register_location(
		'before-sidebar',
		[
			'label'    => __( 'Before Sidebar', 'page-builder-framework' ) . ' (wpbf_sidebar_open)',
			'multiple' => true,
			'hook'     => 'wpbf_sidebar_open',
		]
	);

	$elementor_theme_manager->register_location(
		'after-sidebar',
		[
			'label'    => __( 'After Sidebar', 'page-builder-framework' ) . ' (wpbf_sidebar_close)',
			'multiple' => true,
			'hook'     => 'wpbf_sidebar_close',
		]
	);

}
add_action( 'elementor/theme/register_locations', 'wpbf_elementor_locations' );
