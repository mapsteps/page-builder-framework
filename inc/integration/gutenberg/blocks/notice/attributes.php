<?php
/**
 * Define block's attributes.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

return array(
	'type'             => array(
		'type'    => 'string',
		'default' => '',
	),
	'message'          => array(
		'type'    => 'string',
		'default' => __( 'Enter the notice message', 'power-blocks' ),
	),
	'contentAlignment' => array(
		'type'    => 'string',
		'default' => '',
	),
	'className'          => array(
		'type'    => 'string',
		'default' => '',
	),
	'id'               => array(
		'type'    => 'string',
		'default' => '',
	),
);
