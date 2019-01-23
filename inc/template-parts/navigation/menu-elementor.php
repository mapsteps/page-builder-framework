<?php
/**
 * Custom Menu
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

echo '<div class="wpbf-menu-custom wpbf-visible-large">';

echo do_shortcode( get_theme_mod( 'menu_custom' ) );

echo '</div>';