<?php
/**
 * Meta.
 *
 * Renders author/post meta on posts.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Stop here if this is not a blog post.
if ( 'post' !== get_post_type() ) {
	return;
}

wpbf_article_meta();
