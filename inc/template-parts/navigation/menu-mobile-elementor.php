<?php
/**
 * Custom mobile menu.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

echo '<div class="wpbf-mobile-menu-custom wpbf-hidden-large">';

do_action( 'wpbf_mobile_menu' );

echo '</div>';
