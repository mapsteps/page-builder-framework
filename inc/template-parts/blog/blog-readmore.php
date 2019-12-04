<?php
/**
 * Read more.
 *
 * Renders read more link on archives.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$read_more_class = 'text' === get_theme_mod( 'blog_read_more_link' ) ? ' wpbf-inline-block' : ' wpbf-button';

if ( 'primary' === get_theme_mod( 'blog_read_more_link' ) ) {
	$read_more_class .= ' wpbf-button-primary';
}

$read_more_text = apply_filters( 'wpbf_read_more_text', __( 'Read more', 'page-builder-framework' ) );

echo sprintf( '<a href="%1$s" class="%2$s">%3$s%4$s</a>',
	esc_url( get_permalink() ),
	'wpbf-read-more' . $read_more_class,
	esc_html( $read_more_text ),
	'<span class="screen-reader-text">' . get_the_title() . '</span>'
);
