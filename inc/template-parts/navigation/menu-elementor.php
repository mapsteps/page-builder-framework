<?php
/**
 * Custom menu.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

echo '<div class="wpbf-menu-custom wpbf-visible-large">';

echo do_shortcode( get_theme_mod( 'menu_custom' ) );

echo '</div>';
