<?php
/**
 * Class autoloader.
 *
 * Loads Mapsteps\Wpbf\* classes from the theme folder (PSR-4, the namespace maps to the theme root).
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

spl_autoload_register(
	function ( $class_name ) {

		$prefix = 'Mapsteps\\Wpbf\\';

		if ( 0 !== strpos( $class_name, $prefix ) ) {
			return;
		}

		$file = dirname( __DIR__ ) . '/' . str_replace( '\\', '/', substr( $class_name, strlen( $prefix ) ) ) . '.php';

		if ( file_exists( $file ) ) {
			require $file;
		}

	}
);
