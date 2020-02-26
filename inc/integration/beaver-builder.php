<?php
/**
 * Beaver Builder integration.
 *
 * @package Page Builder Framework
 * @subpackage Integration
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Remove content wrapper from fl-builder-template CPT.
 *
 * @param string $wrapper The inner content wrapper.
 *
 * @return $wrapper or false.
 */
function wpbf_bb_inner_content_wrapper( $wrapper ) {

	if ( 'fl-builder-template' === get_post_type() ) {
		return false;
	}

	return $wrapper;

}
add_filter( 'wpbf_inner_content', 'wpbf_bb_inner_content_wrapper' );
add_filter( 'wpbf_inner_content_close', 'wpbf_bb_inner_content_wrapper' );

/**
 * Remove title from fl-builder-template CPT.
 *
 * @param string $title The title.
 *
 * @return $title or false.
 */
function wpbf_bb_title( $title ) {

	if ( 'fl-builder-template' === get_post_type() ) {
		return false;
	}

	return $title;

}
add_filter( 'wpbf_title', 'wpbf_bb_title' );
