<?php
/**
 * 404 Page
 *
 * Displayed if a page couldn't be found.
 * See also inc/template-parts/404.php
 *
 * @package Page Builder Framework
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

do_action( 'wpbf_404' );

get_footer();