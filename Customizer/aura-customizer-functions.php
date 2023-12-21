<?php
/**
 * Aura customizer's global functions.
 *
 * @package Aura
 */

use Mapsteps\Aura\Customizer\AuraCustomizer;
use Mapsteps\Aura\Customizer\AuraCustomizerControl;
use Mapsteps\Aura\Customizer\AuraCustomizerPanel;
use Mapsteps\Aura\Customizer\AuraCustomizerSection;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Get the instance of the Aura customizer singleton class.
 *
 * @return AuraCustomizer
 */
function aura_customizer() {

	return AuraCustomizer::get_instance();

}

/**
 * Initialize Aura customizer panel.
 *
 * @return AuraCustomizerPanel
 */
function aura_customizer_panel() {

	return new AuraCustomizerPanel();

}

/**
 * Initialize Aura customizer section.
 *
 * @return AuraCustomizerSection
 */
function aura_customizer_section() {

	return new AuraCustomizerSection();

}

/**
 * Initialize Aura customizer control.
 *
 * @return AuraCustomizerControl
 */
function aura_customizer_control() {

	return new AuraCustomizerControl();

}
