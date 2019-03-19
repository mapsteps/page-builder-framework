<?php
/**
 * Categories
 *
 * Renders categories on posts.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// stop here if this is not a blog post
if( get_post_type() !== 'post' ) return;

echo '<p class="footer-categories">';

echo '<span class="categories-title">' . apply_filters( 'wpbf_categories_title', __( 'Filed under:', 'page-builder-framework' ) ) . '</span> ';

echo get_the_category_list(', ');

echo '</p>';