<?php
/**
 * Local Gravatars.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Filter the HTML for the user avatar.
 *
 * @param string $avatar The HTML for the user avatar.
 *
 * @return string The updated HTML for the user avatar.
 */
function wpbf_local_gravatars( $avatar ) {

	if ( true !== apply_filters( 'wpbf_local_gravatars', false ) ) {
		return $avatar;
	}

	preg_match_all( '/srcset=["\']?((?:.(?!["\']?\s+(?:\S+)=|\s*\/?[>"\']))+.)["\']?/', $avatar, $srcset );
	if ( isset( $srcset[1] ) && isset( $srcset[1][0] ) ) {
		$url            = explode( ' ', $srcset[1][0] )[0];
		$local_gravatar = wpbf_get_local_gravatar( $url );
		$avatar         = str_replace( $url, $local_gravatar, $avatar );
	}

	preg_match_all( '/src=["\']?((?:.(?!["\']?\s+(?:\S+)=|\s*\/?[>"\']))+.)["\']?/', $avatar, $src );
	if ( isset( $src[1] ) && isset( $src[1][0] ) ) {
		$url            = explode( ' ', $src[1][0] )[0];
		$local_gravatar = wpbf_get_local_gravatar( $url );
		$avatar         = str_replace( $url, $local_gravatar, $avatar );
	}

	return $avatar;

}
add_filter( 'get_avatar', 'wpbf_local_gravatars' );

/**
 * Create & get local gravatars.
 *
 * @param string $url The gravatar url.
 *
 * @return string The local gravatar url.
 */
function wpbf_get_local_gravatar( $url ) {

	global $wp_filesystem;

	if ( ! $wp_filesystem ) {
		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}
	}

	WP_Filesystem();

	$upload_dir = wp_upload_dir();
	$pbf_dir    = $upload_dir['basedir'] . '/page-builder-framework/';
	$avatar_dir = $upload_dir['basedir'] . '/page-builder-framework/gravatar/';
	$avatar_url = $upload_dir['baseurl'] . '/page-builder-framework/gravatar/';

	// Create page-builder-framework folder if it doesn't exist.
	if ( ! file_exists( $pbf_dir ) ) {
		$wp_filesystem->mkdir( $pbf_dir );
	} 

	// Create gravatar folder if it doesn't exist.
	if ( ! file_exists( $avatar_dir ) ) {
		$wp_filesystem->mkdir( $avatar_dir );
	} 

	$filename  = basename( wp_parse_url( $url, PHP_URL_PATH ) );
	$file_path = $avatar_dir . $filename;
	$file_url  = $avatar_url . $filename;

	// Check if the file already exists.
	if ( ! file_exists( $file_path ) ) {

		// Download file to temporary location.
		$tmp_path = download_url( $url );

		if ( ! is_wp_error( $tmp_path ) ) {
			// Move temp file to final destination.
			$success = $wp_filesystem->move( $tmp_path, $file_path, true );
			// Return Gravatar url if we couldn't store locally.
			if ( ! $success ) {
				return $url;
			}
		}

	}

	return $file_url;

}
