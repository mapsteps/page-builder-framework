<?php
/**
 * Custom mobile menu.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

echo '<div class="wpbf-mobile-menu-custom wpbf-hidden-large">';

echo do_shortcode( get_theme_mod( 'menu_custom' ) );

echo '</div>';
