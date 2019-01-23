<?php
/**
 * Mobile Menu - Custom
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

echo '<div class="wpbf-mobile-menu-custom wpbf-hidden-large">';

echo do_shortcode( get_theme_mod( 'menu_custom' ) );

echo '</div>';