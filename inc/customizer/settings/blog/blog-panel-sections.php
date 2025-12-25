<?php
/**
 * Blog customizer settings - Panel & Sections.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Panel */

// Blog.
wpbf_customizer_panel()
	->id( 'blog_panel' )
	->title( __( 'Blog', 'page-builder-framework' ) )
	->priority( 2 )
	->add();

/* Sections */

// General.
wpbf_customizer_section()
	->id( 'wpbf_blog_settings' )
	->title( __( 'General', 'page-builder-framework' ) )
	->priority( 100 )
	->addToPanel( 'blog_panel' );

// Pagination.
wpbf_customizer_section()
	->id( 'wpbf_pagination_settings' )
	->title( __( 'Pagination', 'page-builder-framework' ) )
	->priority( 100 )
	->addToPanel( 'blog_panel' );

// Archive layout.
$archives = apply_filters( 'wpbf_archives', array( 'archive' ) );

foreach ( $archives as $archive ) {

	$panel_title = $archive;

	if ( 'archive' === $panel_title ) {
		$panel_title = __( 'Blog / Archive', 'page-builder-framework' );
	}

	if ( 'search' === $panel_title ) {
		$panel_title = __( 'Search Results', 'page-builder-framework' );
	}

	$section_title = ucwords( str_replace( '-', ' ', $panel_title ) ) . '&nbsp;' . __( 'Layout', 'page-builder-framework' );

	wpbf_customizer_section()
		->id( 'wpbf_' . $archive . '_options' )
		->title( $section_title )
		->priority( 100 )
		->addToPanel( 'blog_panel' );

}

// Post layout.
$singles = apply_filters( 'wpbf_singles', array( 'single' ) );

foreach ( $singles as $single ) {

	$panel_title = $single;

	if ( 'single' === $panel_title ) {
		$panel_title = __( 'Post', 'page-builder-framework' );
	}

	$section_title = ucwords( $panel_title ) . '&nbsp;' . __( 'Layout', 'page-builder-framework' );

	wpbf_customizer_section()
		->id( 'wpbf_' . $single . '_options' )
		->title( $section_title )
		->priority( 200 )
		->addToPanel( 'blog_panel' );

}
