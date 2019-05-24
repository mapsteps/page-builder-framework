<?php
/**
 * Tags
 *
 * Renders tags on archives.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// stop here if this is not a blog post
if( get_post_type() !== 'post' ) return;

the_tags( '<p class="footer-tags"><span class="tags-title">' . apply_filters( 'wpbf_tags_title', __( 'Tags:', 'page-builder-framework' ) ) . '</span> ', ', ', '</p>' );