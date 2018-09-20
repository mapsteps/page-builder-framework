<?php
/**
 * Read More
 *
 * Renders read more link on archives, category, search and index pages.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$read_more_button = get_theme_mod( 'blog_read_more_link' ) == 'text' ? ' wpbf-inline-block' : ' wpbf-button';
$read_more_button_primary = get_theme_mod( 'blog_read_more_link' ) == 'primary' ? ' wpbf-button-primary' : false;
$read_more_text = get_theme_mod( 'blog_read_more_text', __( 'Read more', 'page-builder-framework' ) );

echo '<a class="wpbf-read-more'. esc_attr( $read_more_button ) . esc_attr( $read_more_button_primary ) .'" href="'. esc_url( get_permalink( $post->ID ) ) . '">'. esc_html( $read_more_text ) .'</a>'

?>