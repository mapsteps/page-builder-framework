<?php
/**
 * Control dump (dev only, never shipped): for every control of the listed types (theme + Premium), what PHP hands to
 * the browser and how the field cleans values: setting default, value, json() (incl. the li markup), and the cleaned
 * result of ~40 tricky inputs. Run it before and after changing a control family and compare the two files.
 *
 *     php -d extension=mysqli -d mysqli.default_port=10035 bin/snapshot/control-dump.php <wp-root> [extra-fields.php] > out.json
 *
 * extra-fields.php: fields to add for this run (e.g. bin/snapshot/zz-test-fields.php, the variants nobody uses).
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
if ( ! empty( $argv[2] ) ) {
	require $argv[2];
}

wp_set_current_user( 1 );

$manager                       = new WP_Customize_Manager();
$GLOBALS['wp_customize']       = $manager;
do_action( 'customize_register', $manager );

$types = array(
	'wpbf-checkbox', 'wpbf-toggle', 'wpbf-radio', 'wpbf-radio-buttonset', 'wpbf-radio-image', 'wpbf-generic',
	'wpbf-responsive-generic', 'wpbf-dimension', 'wpbf-margin-padding', 'wpbf-responsive-margin-padding',
	'wpbf-editor', 'wpbf-image', 'wpbf-headline', 'wpbf-divider', 'wpbf-custom', 'wpbf-section-tabs', 'wpbf-sortable',
	'code_editor', 'wpbf-upload', 'upload', 'media',
);

$inputs = array(
	true, false, 1, 0, '1', '0', '', 'on', 'off', 'true', 'false', 'yes', null, array(), '12', '12px', '-5', '1.5em', '3.',
	'abc', '<b>x</b><script>y</script>', 'a@b.c', 'http://x.y/z', '20%', '%%', 'calc(1px + 2px)', '10px 20px', 99999,
	array( 'top' => '1', 'right' => '2px', 'bottom' => '', 'left' => 'x' ),
	'{"top":"1","right":"2px","bottom":"","left":"x"}',
	array( 'desktop' => '10', 'tablet' => '20px', 'mobile' => '' ),
	'{"desktop":"10","tablet":"20px","mobile":""}',
	array( 'desktop_top' => 5, 'tablet_left' => '7px', 'mobile_bottom' => 'x' ),
	'{"desktop_top":5,"tablet_left":"7px","mobile_bottom":"x"}',
	array( 'id' => 5, 'url' => 'http://pbf.local/x.png', 'width' => 10, 'height' => 20 ),
	array( 'b', 'a', '<i>c</i>' ),
);

$out = array();

foreach ( $manager->controls() as $control ) {
	if ( ! in_array( $control->type, $types, true ) ) {
		continue;
	}

	$entry = array(
		'class' => get_class( $control ),
		'type'  => $control->type,
	);

	$setting = $control->setting;

	if ( $setting instanceof WP_Customize_Setting ) {
		$entry['default'] = $setting->default;
		$entry['value']   = $setting->value();
		$clean            = array();

		foreach ( $inputs as $i => $input ) {
			try {
				$clean[ $i ] = $setting->sanitize( $input );
			} catch ( Throwable $e ) {
				$clean[ $i ] = 'ERROR ' . get_class( $e ) . ': ' . $e->getMessage();
			}
		}

		foreach ( (array) $control->choices as $key => $label ) {
			$clean[ 'choice:' . $key ] = $setting->sanitize( is_int( $key ) ? $key : (string) $key );
		}

		$entry['sanitized'] = $clean;
	}

	$entry['json'] = $control->json();

	$out[ $control->id ] = $entry;
}

ksort( $out );
echo wp_json_encode( $out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
