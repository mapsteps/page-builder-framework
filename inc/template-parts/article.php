<?php
/**
 * Article.
 *
 * Displays posts on archives, category, search and index pages.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$blog_layout = wpbf_blog_layout();

get_template_part( 'inc/template-parts/blog-layouts/' . $blog_layout['blog_layout'] );
