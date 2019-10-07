<?php
/**
 * Tags.
 *
 * Renders tags on archives.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Stop here if this is not a blog post.
if ( 'post' !== get_post_type() ) {
	return;
}

the_tags( '<p class="footer-tags"><span class="tags-title">' . apply_filters( 'wpbf_tags_title', __( 'Tags:', 'page-builder-framework' ) ) . '</span> ', ', ', '</p>' );
