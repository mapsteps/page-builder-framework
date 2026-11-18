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
	'code_editor', 'wpbf-upload', 'upload', 'media', 'wpbf-color', 'wpbf-assoc-array', 'wpbf-repeater',
);

// Typography's font family / variant selects (the select family itself is 7d's).
$typography_parts = '/\[(font-family|variant)\]$/';

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
	// 7c: colors, typography, repeater.
	'transparent', 'rgba(0,0,0,0)', 'rgba(10, 20, 30, 0.5)', 'var(--x)', '#abcd', '#FFF', '#12345678', 'rgb(1,2,3)',
	'hsla(200, 50%, 40%, 0.7)', 'red', 120, array( 'r' => 1, 'g' => 2, 'b' => 3, 'a' => 0.5 ),
	array( 'font-family' => 'Roboto', 'variant' => '700italic', 'font-size' => '<b>14px</b>', 'random' => 3, 'color' => 'transparent' ),
	array( 'font-family' => 'Helvetica, Arial, sans-serif', 'variant' => '400', 'text-transform' => 'bogus' ),
	rawurlencode( '[{"font_name":"A <b>b</b>","font_css_name":"a","font_variants":["regular","700"],"font_woff":"12"},null]' ),
	str_replace( '%2C', ',', rawurlencode( '[{"zz_text":"x","zz_select":"b","zz_multi":["a"],"zz_upload":"","zz_checkbox":"1","zz_color":"rgba(0,0,0,0)","bogus":1}]' ) ),
	array( array( 'zz_text' => '<script>x</script>', 'font_name' => 'n', 'zz_number' => '5' ) ),
);

$out = array();

foreach ( $manager->controls() as $control ) {
	if ( ! in_array( $control->type, $types, true ) && ! preg_match( $typography_parts, $control->id ) ) {
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
