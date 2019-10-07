<?php
/**
 * Categories.
 *
 * Renders categories on archives.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Stop here if this is not a blog post.
if ( 'post' !== get_post_type() ) {
	return;
}

echo '<p class="footer-categories">';

echo '<span class="categories-title">' . apply_filters( 'wpbf_categories_title', __( 'Filed under:', 'page-builder-framework' ) ) . '</span> ';

echo get_the_category_list( ', ' );

echo '</p>';
