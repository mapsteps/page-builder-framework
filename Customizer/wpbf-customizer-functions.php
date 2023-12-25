<?php
/**
 * Aura customizer's global functions.
 *
 * @package Aura
 */

use Mapsteps\Wpbf\Customizer\Customizer;
use Mapsteps\Wpbf\Customizer\CustomizerControl;
use Mapsteps\Wpbf\Customizer\CustomizerPanel;
use Mapsteps\Wpbf\Customizer\CustomizerSection;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Get the instance of the Aura customizer singleton class.
 *
 * @return Customizer
 */
function wpbf_customizer() {

	return Customizer::get_instance();

}

/**
 * Initialize Aura customizer panel.
 *
 * @return CustomizerPanel
 */
function wpbf_customizer_panel() {

	return new CustomizerPanel();

}

/**
 * Initialize Aura customizer section.
 *
 * @return CustomizerSection
 */
function wpbf_customizer_section() {

	return new CustomizerSection();

}

/**
 * Initialize Aura customizer control.
 *
 * @return CustomizerControl
 */
function wpbf_customizer_control() {

	return new CustomizerControl();

}
