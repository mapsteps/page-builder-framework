<?php
/**
 * Backwards compatibility.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$menu_logo_font_size             = get_theme_mod( 'menu_logo_font_size' );
$menu_logo_description_font_size = get_theme_mod( 'menu_logo_description_font_size' );
$sidebar_widget_padding_top      = get_theme_mod( 'sidebar_widget_padding_top' );
$sidebar_widget_padding_right    = get_theme_mod( 'sidebar_widget_padding_right' );
$sidebar_widget_padding_bottom   = get_theme_mod( 'sidebar_widget_padding_bottom' );
$sidebar_widget_padding_left     = get_theme_mod( 'sidebar_widget_padding_left' );

if ( $menu_logo_font_size ) {
	set_theme_mod( 'menu_logo_font_size_desktop', $menu_logo_font_size );
	remove_theme_mod( 'menu_logo_font_size' );
}

if ( $menu_logo_description_font_size ) {
	set_theme_mod( 'menu_logo_description_font_size_desktop', $menu_logo_description_font_size );
	remove_theme_mod( 'menu_logo_description_font_size' );
}

if ( $sidebar_widget_padding_top ) {
	set_theme_mod( 'sidebar_widget_padding_top_desktop', $sidebar_widget_padding_top );
	remove_theme_mod( 'sidebar_widget_padding_top' );
}

if ( $sidebar_widget_padding_right ) {
	set_theme_mod( 'sidebar_widget_padding_right_desktop', $sidebar_widget_padding_right );
	remove_theme_mod( 'sidebar_widget_padding_right' );
}

if ( $sidebar_widget_padding_bottom ) {
	set_theme_mod( 'sidebar_widget_padding_bottom_desktop', $sidebar_widget_padding_bottom );
	remove_theme_mod( 'sidebar_widget_padding_bottom' );
}

if ( $sidebar_widget_padding_left ) {
	set_theme_mod( 'sidebar_widget_padding_left_desktop', $sidebar_widget_padding_left );
	remove_theme_mod( 'sidebar_widget_padding_left' );
}

$article_meta  = get_theme_mod( 'blog_sortable_meta', array( 'author', 'date' ) );
$blog_author   = get_theme_mod( 'blog_author' );
$single_author = get_theme_mod( 'single_author' );
$blog_comments = get_theme_mod( 'blog_comments' );

if ( 'hide' === $blog_author || 'hide' === $single_author ) {

	$article_meta = array_diff( $article_meta, array( 'author' ) );
	$article_meta = array_values( $article_meta );

	set_theme_mod( 'blog_sortable_meta', $article_meta );
	remove_theme_mod( 'blog_author' );
	remove_theme_mod( 'single_author' );

}

if ( 'show' === $blog_comments ) {

	$article_meta[] = 'comments';

	set_theme_mod( 'blog_sortable_meta', $article_meta );
	remove_theme_mod( 'blog_comments' );

}
