<?php
/**
 * Setting up notice block.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Scripts for notice block inside editor.
 */
function wpbf_register_notice_block() {

	register_block_type(
		'wpbf/notice-block',
		array(
			'title'       => __( 'Notice Block', 'page-builder-framework' ),
			'description' => __( 'Notice block utilizing CSS Framework of Page Builder Framework.', 'page-builder-framework' ),
			'category'    => 'wpbf',
			'icon'        => 'info-outline',
			'attributes'  => require __DIR__ . '/attributes.php',
			'textdomain'  => 'page-builder-framework',
		)
	);

}
add_action( 'init', 'wpbf_register_notice_block' );

/**
 * Scripts for notice block inside editor.
 */
function wpbf_notice_block_editor_scripts() {

	$opts = wpbf_array_to_js_object(
		array(
			'attributes' => require __DIR__ . '/attributes.php',
		)
	);

	wp_add_inline_script(
		'wpbf-blocks',
		'wpbfBlocks.notice = ' . $opts . ';',
		'before'
	);

}
add_action( 'enqueue_block_editor_assets', 'wpbf_notice_block_editor_scripts' );
