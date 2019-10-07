<?php
/**
 * 404.
 *
 * See also inc/template-parts/404.php.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

get_header();

do_action( 'wpbf_404' );

get_footer();
