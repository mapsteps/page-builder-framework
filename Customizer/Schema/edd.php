<?php
/**
 * Option schema: Easy Digital Downloads.
 *
 * One entry per option that stores a value: control type, default (the value visitors see when nothing is saved)
 * and, for options saved as JSON text, 'json' => true. See Customizer/Schema/OptionSchema.php.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

return array(
	'edd_sidebar_layout' => array(
		'type'    => 'select',
		'default' => 'global',
	),
	'edd_single_sidebar_layout' => array(
		'type'    => 'select',
		'default' => 'global',
	),
	'edd_menu_item_hide_if_not_edd' => array(
		'type'    => 'toggle',
		'default' => false,
	),
	'edd_menu_item_desktop' => array(
		'type'    => 'select',
		'default' => 'show',
	),
	'edd_menu_item_desktop_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'edd_menu_item_mobile' => array(
		'type'    => 'select',
		'default' => 'show',
	),
	'edd_menu_item_mobile_color' => array(
		'type'    => 'color',
		'default' => '',
	),
	'edd_menu_item_count' => array(
		'type'    => 'select',
		'default' => 'show',
	),
);
