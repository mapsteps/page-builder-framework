<?php
/**
 * Snapshot helper (dev only): prints a login cookie for the first administrator, or ends that login again.
 *
 * Usage: php login.php <wordpress-root> create   → prints "<cookie header>\n<token>"
 *        php login.php <wordpress-root> destroy <token>
 *
 * @package Page Builder Framework
 */

// phpcs:disable -- Dev tool.

$_SERVER['HTTP_HOST'] = 'pbf.local';
define( 'WP_USE_THEMES', false );
require $argv[1] . '/wp-load.php';

$user   = get_users( array( 'role' => 'administrator', 'number' => 1, 'orderby' => 'ID' ) )[0];
$tokens = WP_Session_Tokens::get_instance( $user->ID );

if ( 'destroy' === $argv[2] ) {
	$tokens->destroy( $argv[3] );
	exit;
}

$expires = time() + 3 * HOUR_IN_SECONDS;
$token   = $tokens->create( $expires );

echo AUTH_COOKIE . '=' . rawurlencode( wp_generate_auth_cookie( $user->ID, $expires, 'auth', $token ) ) . '; ' . LOGGED_IN_COOKIE . '=' . rawurlencode( wp_generate_auth_cookie( $user->ID, $expires, 'logged_in', $token ) ) . "\n" . $token;
