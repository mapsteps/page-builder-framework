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

// Fingerprint of the content tables, to prove a run wrote nothing.
if ( 'dbstate' === $argv[2] ) {
	global $wpdb;
	echo wp_json_encode(
		array(
			'posts'    => $wpdb->get_row( "SELECT COUNT(*) AS n, MAX(ID) AS max_id, MAX(post_modified_gmt) AS modified FROM {$wpdb->posts}" ),
			'postmeta' => $wpdb->get_row( "SELECT COUNT(*) AS n, MAX(meta_id) AS max_id FROM {$wpdb->postmeta}" ),
			'termmeta' => $wpdb->get_row( "SELECT COUNT(*) AS n, MAX(meta_id) AS max_id FROM {$wpdb->termmeta}" ),
			'comments' => $wpdb->get_row( "SELECT COUNT(*) AS n, MAX(comment_ID) AS max_id FROM {$wpdb->comments}" ),
		)
	);
	exit;
}

if ( 'destroy' === $argv[2] ) {
	$tokens->destroy( $argv[3] );
	exit;
}

$expires = time() + 3 * HOUR_IN_SECONDS;
$token   = $tokens->create( $expires );

echo AUTH_COOKIE . '=' . rawurlencode( wp_generate_auth_cookie( $user->ID, $expires, 'auth', $token ) ) . '; ' . LOGGED_IN_COOKIE . '=' . rawurlencode( wp_generate_auth_cookie( $user->ID, $expires, 'logged_in', $token ) ) . "\n" . $token;
