<?php
/**
 * Setting up notices block.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/writing-your-first-block-type/
 */
function wpbf_register_notices_block() {
	register_block_type_from_metadata( __DIR__ );
}
add_action( 'init', 'wpbf_register_notices_block' );
