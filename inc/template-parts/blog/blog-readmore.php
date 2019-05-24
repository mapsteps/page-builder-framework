<?php
/**
 * Read More
 *
 * Renders read more link on archives.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$read_more_class = get_theme_mod( 'blog_read_more_link' ) == 'text' ? ' wpbf-inline-block' : ' wpbf-button';
if( get_theme_mod( 'blog_read_more_link' ) == 'primary' ) $read_more_class .= ' wpbf-button-primary';

$read_more_text = apply_filters( 'wpbf_read_more_text', __( 'Read more', 'page-builder-framework' ) );

echo sprintf( '<a href="%1$s" class="%2$s">%3$s%4$s</a>',
	esc_url( get_permalink() ),
	'wpbf-read-more' . esc_attr( $read_more_class ),
	esc_html( $read_more_text ),
	'<span class="screen-reader-text">' . get_the_title() . '</span>'
);