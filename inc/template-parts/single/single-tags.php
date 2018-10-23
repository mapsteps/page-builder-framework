<?php
/**
 * Tags
 *
 * Renders tags on archives, category, search, index & single pages.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if( get_post_type() !== 'post' ) return;

the_tags( '<p class="footer-tags"><span class="tags-title">' . __( 'Tags:', 'page-builder-framework' ) . '</span> ', ', ', '</p>' );

?>