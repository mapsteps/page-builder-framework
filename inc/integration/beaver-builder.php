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

/**
 * Remove sidebar from fl-builder-template.
 *
 * @param string $layout The sidebar layout.
 *
 * @return string The updated sidebar layout.
 */
function wpbf_bb_template( $layout ) {

	if ( 'fl-builder-template' === get_post_type() ) {
		$layout = 'none';
	}

	return $layout;

}
add_filter( 'wpbf_sidebar_layout', 'wpbf_bb_template' );
