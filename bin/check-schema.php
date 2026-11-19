<?php
/**
 * Checks the Customizer option schema against what the theme registers, and that wpbf_mod() reads values right.
 *
 * Usage: php -d extension=mysqli -d mysqli.default_port=10035 bin/check-schema.php [--premium]
 *
 * Loads WordPress (pbf.local) with the Premium Add-On switched off for this run (on with --premium: then Premium's
 * options and its schema entries, added with the `wpbf_option_schema` filter, are checked too) and every database
 * write blocked, then checks:
 * - every theme option that stores a value has a schema entry, and every entry is registered
 * - registration uses the schema's type, default and stored format (no settings file overrides them)
 * - "Default: …" label texts agree with the schema
 * - fields registered the documented way (own type and default, as Premium and child themes do) keep theirs
 * - wpbf_mod() returns defaults and saved values typed (JSON, toggles, numbers, {archive} ids)
 *
 * Dev only, never shipped.
 *
 * @package Page Builder Framework
 */

// phpcs:disable WordPress.WP.GlobalVariablesOverride, WordPress.Security.EscapeOutput.OutputNotEscaped, WordPress.PHP.DevelopmentFunctions -- Command line tool.

use Mapsteps\Wpbf\Customizer\CustomizerStore;
use Mapsteps\Wpbf\Customizer\Registry\Registry;
use Mapsteps\Wpbf\Customizer\Schema\OptionSchema;

if ( 'cli' !== PHP_SAPI ) {
	exit( 1 );
}

$_SERVER['HTTP_HOST'] = 'pbf.local';
define( 'WP_USE_THEMES', false );
define( 'DISABLE_WP_CRON', true );

// Hooks registered before WordPress loads: Premium off for this run (unless --premium), no database writes.
if ( ! in_array( '--premium', $argv, true ) ) {
	$GLOBALS['wp_filter']['option_active_plugins'][10][] = array(
		'function'      => function ( $plugins ) {
			return array_values( array_diff( (array) $plugins, array( 'wpbf-premium/wpbf-premium.php' ) ) );
		},
		'accepted_args' => 1,
	);
}
$GLOBALS['wp_filter']['query'][10][] = array(
	'function'      => function ( $query ) {
		return preg_match( '/^\s*(INSERT|UPDATE|DELETE|REPLACE|ALTER|CREATE|DROP|TRUNCATE)\b/i', $query ) ? 'SELECT 1' : $query;
	},
	'accepted_args' => 1,
);

require dirname( __DIR__, 4 ) . '/wp-load.php';

// The WooCommerce options are only registered with WooCommerce active.
if ( ! class_exists( 'WooCommerce' ) ) {
	require WPBF_THEME_DIR . '/inc/integration/woocommerce/woocommerce-customizer-settings.php';
}

// Fields are only built when the Customizer registers: build them now.
Registry::build();

$failures = array();
$fail     = function ( $message ) use ( &$failures ) {
	$failures[] = $message;
};
$same     = function ( $a, $b ) {
	return wp_json_encode( $a ) === wp_json_encode( $b );
};

/* Schema against registration */

$decorative = array( 'divider', 'headline', 'custom', 'section-tabs' );
$registered = array();
$controls   = array();

foreach ( CustomizerStore::$added_controls as $control ) {
	$controls[ $control->id ] = $control;
}

foreach ( CustomizerStore::$added_settings as $setting ) {
	$registered[ $setting->id ] = $setting;

	// Typography sub-settings (page_font_family[variant]) take their default from their parent.
	if ( in_array( $setting->control_type, $decorative, true ) || false !== strpos( $setting->id, '[' ) ) {
		continue;
	}

	$entry = OptionSchema::get( $setting->id );

	if ( null === $entry ) {
		$fail( "{$setting->id}: stores a value but has no schema entry" );
		continue;
	}

	if ( ! $same( $setting->default, OptionSchema::defaultValue( $entry ) ) ) {
		$fail( "{$setting->id}: registered default " . wp_json_encode( $setting->default ) . ' differs from the schema (a settings file still sets its own)' );
	}

	$control = isset( $controls[ $setting->id ] ) ? $controls[ $setting->id ] : null;
	$props   = $control && is_array( $control->custom_properties ) ? $control->custom_properties : array();

	if ( $control && 'typography' !== $entry['type'] && $control->type !== $entry['type'] ) {
		$fail( "{$setting->id}: registered as {$control->type}, the schema says {$entry['type']}" );
	}

	if ( ! empty( $props['save_as_json'] ) !== ! empty( $entry['json'] ) ) {
		$fail( "{$setting->id}: stored format differs from the schema" );
	}

	// "Default: 1200px" in the label/description. An empty default means "same as the parent setting", the text names that.
	$text = ( $control ? $control->label . ' ' . $control->description : '' );

	if ( preg_match( '/Default:\s*([^<\s]+)/', $text, $match ) && '' !== OptionSchema::defaultValue( $entry ) && (string) OptionSchema::defaultValue( $entry ) !== $match[1] ) {
		$fail( "{$setting->id}: label says \"Default: {$match[1]}\", the schema says " . wp_json_encode( OptionSchema::defaultValue( $entry ) ) );
	}
}

foreach ( OptionSchema::all() as $id => $entry ) {
	$check_id = str_replace( array( '{archive}', '{single}' ), array( 'archive', 'single' ), $id );

	if ( ! isset( $registered[ $check_id ] ) ) {
		$fail( "{$id}: in the schema but not registered" );
	}

	if ( ! isset( $entry['type'] ) || ! array_key_exists( 'default', $entry ) ) {
		$fail( "{$id}: schema entry needs 'type' and 'default'" );
	}
}

/* Fields registered the documented way keep their own type and default */

add_filter(
	'wpbf_archives',
	function ( $archives ) {
		$archives[] = 'zz-test-archive';
		return $archives;
	}
);

wpbf_customizer_field()
	->id( 'zz_test_color' )
	->type( 'color' )
	->label( 'Test' )
	->defaultValue( '#123456' )
	->addToSection( 'wpbf_page_options' );

wpbf_customizer_field()
	->id( 'zz_test_padding' )
	->type( 'responsive-padding' )
	->label( 'Test' )
	->defaultValue( array( 'desktop_top' => 5 ) )
	->properties( array( 'save_as_json' => true ) )
	->addToSection( 'wpbf_page_options' );

// Re-registering a theme option with its own default (as a child theme might) keeps that default.
wpbf_customizer_field()
	->id( 'page_boxed_padding' )
	->label( 'Test' )
	->defaultValue( 99 )
	->addToSection( 'wpbf_page_options' );

$test_settings = array();

foreach ( CustomizerStore::$added_settings as $setting ) {
	$test_settings[ $setting->id ] = $setting; // The last registration of an id wins.
}

$own = OptionSchema::find( 'zz_test_color' );

if ( ! isset( $test_settings['zz_test_color'] ) || '#123456' !== $test_settings['zz_test_color']->default || 'color' !== $own['type'] ) {
	$fail( 'A field registered with its own type and default lost them' );
}

if ( 99 !== $test_settings['page_boxed_padding']->default ) {
	$fail( 'A theme option re-registered with its own default got the schema default instead' );
}

/* Reading values */

$saved = array();

add_filter(
	'pre_option_theme_mods_' . get_option( 'stylesheet' ),
	function () use ( &$saved ) {
		return $saved;
	}
);

$expect = function ( $id, $expected, $why ) use ( $fail, $same ) {
	$actual = wpbf_mod( $id );

	if ( ! $same( $actual, $expected ) || gettype( $actual ) !== gettype( $expected ) ) {
		$fail( "wpbf_mod( '{$id}' ) {$why}: got " . wp_json_encode( $actual ) . ' (' . gettype( $actual ) . '), expected ' . wp_json_encode( $expected ) );
	}
};

// Nothing saved: defaults.
$expect( 'page_max_width', '1200px', 'not saved' );
$expect( 'page_boxed', false, 'not saved' );
$expect( 'page_boxed_padding', 20, 'not saved' );
$expect( 'page_padding', array(
	'desktop_top'    => 40,
	'desktop_right'  => 20,
	'desktop_bottom' => 40,
	'desktop_left'   => 20,
), 'not saved' );
$expect( 'menu_logo_alt', get_bloginfo( 'name' ), 'not saved' );
$expect( 'zz-test-archive_layout', OptionSchema::defaultValue( OptionSchema::get( 'archive_layout' ) ), 'not saved ({archive} id)' );
$expect( 'zz_test_color', '#123456', 'not saved (own default)' );
$expect( 'zz_test_padding', array( 'desktop_top' => 5 ), 'not saved (own default)' );
$expect( 'zz_test_unknown', false, 'unknown option' );

if ( null !== OptionSchema::get( 'nope_layout' ) ) {
	$fail( "OptionSchema::get( 'nope_layout' ) matched a {archive} entry although 'nope' isn't an archive" );
}

// Saved values: typed.
$saved = array(
	'page_max_width'       => '1000px',
	'page_boxed'           => '1',
	'page_boxed_padding'   => 30.0,
	'sidebar_width'        => '33.5',
	'page_padding'         => '{"desktop_top":"10","desktop_right":20}',
	'single_boxed_padding' => 'not json',
	'menu_logo_alt'        => '',
	'zz_test_padding'      => '{"desktop_top":7}',
	'zz_test_unknown'      => 'x',
);
$expect( 'page_max_width', '1000px', 'saved text' );
$expect( 'page_boxed', true, "saved '1'" );
$expect( 'page_boxed_padding', 30, 'saved 30.0' );
$expect( 'sidebar_width', 33.5, "saved '33.5'" );
$expect( 'page_padding', array(
	'desktop_top'   => '10',
	'desktop_right' => 20,
), 'saved JSON' );
$expect( 'single_boxed_padding', array(), 'saved broken JSON' );
$expect( 'menu_logo_alt', '', 'saved empty' );
$expect( 'zz_test_padding', array( 'desktop_top' => 7 ), 'saved JSON (own field)' );
$expect( 'zz_test_unknown', 'x', 'unknown option, saved' );

/* Result */

if ( $failures ) {
	echo count( $failures ) . " problem(s):\n- " . implode( "\n- ", $failures ) . "\n";
	exit( 1 );
}

echo 'All ' . count( OptionSchema::all() ) . " schema entries OK, wpbf_mod() OK.\n";
