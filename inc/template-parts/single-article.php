<?php
/**
 * Article.
 *
 * Displays content on singular pages (posts).
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$post_layout = wpbf_post_layout();

get_template_part( 'inc/template-parts/single-layouts/' . $post_layout['post_layout'] );
