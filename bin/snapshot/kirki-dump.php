<?php
/**
 * Kirki layer dump (dev only, never shipped): every panel, section, setting and control the Kirki safety net created
 * from bin/snapshot/zz-test-kirki-fields.php (ids starting with zz_kirki), with what PHP hands to the browser and how a
 * few values are cleaned. Run it before and after touching Customizer/Compatibility/kirki-compatibility.php or the
 * builder, and compare.
 *
 * Usage:
 *     php -d extension=mysqli -d mysqli.default_port=10035 bin/snapshot/kirki-dump.php <wp-root> bin/snapshot/zz-test-kirki-fields.php > out.json
 *
 * Database writes are blocked; nothing is saved.
 *
 * @package Page Builder Framework
 */

// phpcs:disable -- Dev tool.

if ( 'cli' !== PHP_SAPI ) {
	exit( 1 );
}

$_SERVER['HTTP_HOST'] = 'pbf.local';
define( 'WP_USE_THEMES', false );
define( 'DISABLE_WP_CRON', true );

$GLOBALS['wp_filter']['query'][10][] = array(
	'function'      => function ( $query ) {
		return preg_match( '/^\s*(INSERT|UPDATE|DELETE|REPLACE|ALTER|CREATE|DROP|TRUNCATE)\b/i', $query ) ? 'SELECT 1' : $query;
	},
	'accepted_args' => 1,
);

require rtrim( $argv[1], '/\\' ) . '/wp-load.php';
require_once ABSPATH . WPINC . '/class-wp-customize-manager.php';
require $argv[2];

wp_set_current_user( 1 );

$manager                 = new WP_Customize_Manager();
$GLOBALS['wp_customize'] = $manager;
do_action( 'customize_register', $manager );

$mine   = function ( $id ) {
	return false !== strpos( $id, 'zz_kirki' );
};
$inputs = array( true, false, 0, '0', '', '12', '12px', 'abc', '<b>x</b><script>y</script>', 'rgba(0,0,0,0)', array( 'a', 'b' ), '{"desktop":"5","tablet":"x"}', array( 'top' => '1', 'left' => 'x' ) );
$out    = array( 'classes' => array(), 'panels' => array(), 'sections' => array(), 'settings' => array(), 'controls' => array() );

foreach ( array( 'Kirki', 'Kirki_Control_Base', 'Kirki_Customize_Control', 'Kirki\Panel', 'Kirki\Section', 'Kirki\Control\Base', 'Kirki\Field\Generic', 'Kirki\Field\Background', 'Kirki\Pro\Field\Margin', 'WPBF_Customize_Input_Slider', 'WPBF_Customize_Padding_Control', 'WPBF_Customize_Font_Size_Control', 'WPBF_Customize_Responsive_Input_Slider', 'WPBF_Customize_Responsive_Padding_Control', 'ZZ_Test_Kirki3_Control', 'ZZ_Test_Kirki4_Control', 'ZZ_Test_Old_Wpbf_Control' ) as $class ) {
	$out['classes'][ $class ] = class_exists( $class );
}

$out['configs'] = Kirki::$configs;

foreach ( $manager->panels() as $panel ) {
	if ( $mine( $panel->id ) ) {
		$out['panels'][ $panel->id ] = array( 'class' => get_class( $panel ), 'json' => $panel->json() );
	}
}

foreach ( $manager->sections() as $section ) {
	if ( $mine( $section->id ) ) {
		$out['sections'][ $section->id ] = array( 'class' => get_class( $section ), 'panel' => $section->panel, 'json' => $section->json() );
	}
}

foreach ( $manager->settings() as $setting ) {
	if ( ! $mine( $setting->id ) ) {
		continue;
	}
	$clean = array();
	foreach ( $inputs as $i => $input ) {
		try {
			$clean[ $i ] = $setting->sanitize( $input );
		} catch ( Throwable $e ) {
			$clean[ $i ] = 'ERROR ' . get_class( $e ) . ': ' . $e->getMessage();
		}
	}
	$out['settings'][ $setting->id ] = array(
		'class'      => get_class( $setting ),
		'type'       => $setting->type,
		'default'    => $setting->default,
		'transport'  => $setting->transport,
		'capability' => $setting->capability,
		'value'      => $setting->value(),
		'sanitized'  => $clean,
	);
}

foreach ( $manager->controls() as $control ) {
	if ( ! $mine( $control->id ) ) {
		continue;
	}
	$out['controls'][ $control->id ] = array(
		'class'    => get_class( $control ),
		'type'     => $control->type,
		'section'  => $control->section,
		'priority' => $control->priority,
		'active'   => $control->active(),
		'json'     => $control->json(),
	);
}

$out['partials'] = array();
if ( isset( $manager->selective_refresh ) ) {
	foreach ( $manager->selective_refresh->partials() as $partial ) {
		if ( $mine( $partial->id ) ) {
			$out['partials'][ $partial->id ] = array( 'selector' => $partial->selector, 'settings' => $partial->settings );
		}
	}
}

echo wp_json_encode( $out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
