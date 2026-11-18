<?php
/**
 * Checks that the theme still provides everything the Premium Add-On relies on.
 *
 * Usage: php bin/check-premium-deps.php
 *
 * The list lives in bin/premium-deps.json, the explanation in PREMIUM-DEPENDENCIES.md.
 * Dev only, never shipped.
 *
 * @package Page Builder Framework
 */

// phpcs:disable WordPress.WP.AlternativeFunctions, WordPress.WP.GlobalVariablesOverride, WordPress.Security.EscapeOutput.OutputNotEscaped -- Command line tool.

if ( 'cli' !== PHP_SAPI ) {
	exit( 1 );
}

$root = dirname( __DIR__ );
$deps = json_decode( file_get_contents( __DIR__ . '/premium-deps.json' ), true );

// Read all PHP files of the theme.
$sources  = array();
$iterator = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $root, FilesystemIterator::SKIP_DOTS ) );

foreach ( $iterator as $file ) {
	$path = str_replace( '\\', '/', substr( $file->getPathname(), strlen( $root ) + 1 ) );

	if ( 'php' !== $file->getExtension() || preg_match( '#^(vendor|node_modules|bin)/#', $path ) ) {
		continue;
	}

	$sources[ $path ] = file_get_contents( $file->getPathname() );
}

$all      = implode( "\n", $sources );
$failures = array();

/**
 * Get the source of the file that declares a class.
 *
 * @param array  $sources The theme's PHP files.
 * @param string $class_name Class name (global namespace).
 * @return string|false The file's source or false.
 */
function wpbf_deps_class_source( $sources, $class_name ) {
	foreach ( $sources as $source ) {
		if ( preg_match( '/^\s*(abstract\s+|final\s+)?class\s+' . $class_name . '\b/m', $source ) ) {
			return $source;
		}
	}

	return false;
}

foreach ( $deps['functions'] as $function ) {
	if ( ! preg_match( '/function\s+' . $function . '\s*\(/', $all ) ) {
		$failures[] = "Function missing: $function";
	}
}

// Premium defines these itself. The theme must keep wrapping its own version in function_exists(), or the site crashes.
foreach ( $deps['pluggable'] as $function ) {
	if ( ! preg_match( '/function_exists\(\s*[\'"]' . $function . '[\'"]\s*\)/', $all ) ) {
		$failures[] = "No longer pluggable (function_exists check missing): $function";
	}
}

foreach ( $deps['hooks'] as $hook ) {
	if ( ! preg_match( '/(?:do_action|apply_filters)(?:_ref_array|_deprecated)?\(\s*[\'"]' . preg_quote( $hook, '/' ) . '[\'"]/', $all ) ) {
		$failures[] = "Hook no longer fired: $hook";
	}
}

// Premium unhooks these by hook, function and priority. If any of the three changes, the removal silently stops working.
foreach ( $deps['removed_callbacks'] as $item ) {
	list( $hook, $function, $priority ) = $item;

	$found = false;

	if ( preg_match_all( '/add_action\(\s*[\'"]' . preg_quote( $hook, '/' ) . '[\'"]\s*,\s*[\'"]' . $function . '[\'"]\s*(?:,\s*(\d+))?/', $all, $matches ) ) {
		foreach ( $matches[1] as $found_priority ) {
			if ( (int) ( '' === $found_priority ? 10 : $found_priority ) === (int) $priority ) {
				$found = true;
			}
		}
	}

	if ( ! $found ) {
		$failures[] = "Removable callback changed: $hook → $function (priority $priority)";
	}
}

foreach ( $deps['constants'] as $constant ) {
	if ( ! preg_match( '/define\(\s*[\'"]' . $constant . '[\'"]/', $all ) ) {
		$failures[] = "Constant missing: $constant";
	}
}

foreach ( $deps['classes'] as $class_name ) {
	if ( ! wpbf_deps_class_source( $sources, $class_name ) ) {
		$failures[] = "Class missing: $class_name";
	}
}

foreach ( $deps['methods'] as $item ) {
	list( $class_name, $method ) = explode( '::', $item );

	$source = wpbf_deps_class_source( $sources, $class_name );

	if ( ! $source || ! preg_match( '/function\s+' . $method . '\s*\(/', $source ) ) {
		$failures[] = "Method missing: $item";
	}
}

// Methods of the Customizer builder (wpbf_customizer_field()->id()->type() …).
$customizer = '';

foreach ( $sources as $path => $source ) {
	if ( 0 === strpos( $path, 'Customizer/' ) ) {
		$customizer .= $source;
	}
}

foreach ( $deps['customizer_methods'] as $method ) {
	if ( ! preg_match( '/public\s+(?:static\s+)?function\s+' . $method . '\s*\(/', $customizer ) ) {
		$failures[] = "Customizer method missing: $method";
	}
}

$util = isset( $sources['Customizer/CustomizerUtil.php'] ) ? $sources['Customizer/CustomizerUtil.php'] : '';

foreach ( $deps['control_types'] as $type ) {
	if ( false === strpos( $util, "'" . $type . "'" ) ) {
		$failures[] = "Customizer control/section type missing: $type";
	}
}

foreach ( $deps['sections_panels'] as $id ) {
	if ( ! preg_match( '/->id\(\s*[\'"]' . $id . '[\'"]\s*\)/', $all ) ) {
		$failures[] = "Customizer section/panel missing: $id";
	}
}

// Sections built per archive/single type ('wpbf_' . $archive . '_options').
foreach ( $deps['dynamic_sections'] as $var ) {
	if ( ! preg_match( '/->id\(\s*[\'"]wpbf_[\'"]\s*\.\s*\$' . $var . '\s*\.\s*[\'"]_options[\'"]\s*\)/', $all ) ) {
		$failures[] = "Customizer section missing: 'wpbf_' . \$$var . '_options'";
	}
}

foreach ( $deps['theme_mods'] as $id ) {
	if ( ! preg_match( '/->id\(\s*[\'"]' . $id . '[\'"]\s*\)/', $all ) ) {
		$failures[] = "Customizer setting missing: $id";
	}
}

foreach ( $deps['handles'] as $handle ) {
	if ( ! preg_match( '/wp_(?:register|enqueue)_(?:script|style)\(\s*[\'"]' . preg_quote( $handle, '/' ) . '[\'"]/', $all ) ) {
		$failures[] = "Script/style handle missing: $handle";
	}
}

foreach ( $deps['paths'] as $path ) {
	if ( ! file_exists( $root . $path ) ) {
		$failures[] = "File missing: $path";
	}
}

$total = 0;

foreach ( $deps as $group ) {
	$total += count( $group );
}

if ( $failures ) {
	echo implode( PHP_EOL, $failures ) . PHP_EOL;
	echo count( $failures ) . " of $total Premium dependencies broken." . PHP_EOL;
	exit( 1 );
}

echo "All $total Premium dependencies OK." . PHP_EOL;
