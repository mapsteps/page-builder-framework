<?php
/**
 * Categories
 *
 * Renders categories on archives, category, search and index pages.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if( get_post_type() !== 'post' ) return;

printf( '<p class="footer-categories">' . __( 'Filed under', 'page-builder-framework' ) . ': %1$s</p>' , get_the_category_list(', ') ); // WPCS: XSS ok.

?>