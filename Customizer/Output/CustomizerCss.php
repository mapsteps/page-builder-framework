<?php
/**
 * Customizer CSS and Google Fonts CSS, built when their inputs change and cached.
 *
 * Page views read the cache: one cheap fingerprint of everything the CSS depends on (see key()) picks the entry.
 * When the fingerprint has no entry (settings changed in a way no hook saw: an import, a code update) the request builds
 * it once, without downloading fonts, and stores it. Saves don't build the CSS themselves (a Customizer save previews
 * every setting at its registered default, which isn't what visitors get); they schedule a refresh that runs on WordPress
 * cron, in a normal request, and downloads missing Google Fonts there. Fonts that fail get retried with a growing pause.
 *
 * "file" mode (wpbf_css_output) writes the stylesheet when the cache entry changes, never on a normal page view.
 * The Customizer preview never uses or writes the cache: it builds the CSS live, once.
 *
 * Filters:
 * - `wpbf_customizer_css_key_parts` (array): add anything else your CSS depends on, so a change refreshes the cache.
 * - `wpbf_cache_customizer_css` (bool, default true): false builds the CSS on every page view, as before (for CSS that
 *   depends on the request).
 *
 * @package Page Builder Framework
 */

namespace Mapsteps\Wpbf\Customizer\Output;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Customizer CSS cache.
 */
final class CustomizerCss {

	/**
	 * The option holding the cache: [ 'entries' => [ key => [ 'css', 'fonts' ] ], 'file' => key in the file ].
	 *
	 * @var string
	 */
	const OPTION = 'wpbf_customizer_css_cache';

	/**
	 * Bump when the cache format or the way the CSS is built changes.
	 *
	 * @var int
	 */
	const FORMAT = 9;

	/**
	 * The cron hook that refreshes the cache (after saves, for font downloads and their retries).
	 *
	 * @var string
	 */
	const REFRESH_HOOK = 'wpbf_refresh_customizer_css';

	/**
	 * How many fingerprints to keep (e.g. http and https requests of the same site).
	 *
	 * @var int
	 */
	const MAX_ENTRIES = 2;

	/**
	 * Seconds a scheduled refresh may be late before a page view runs it (WP-Cron off, no real cron).
	 *
	 * @var int
	 */
	const OVERDUE_AFTER = 600;

	/**
	 * The option used as a lock, so only one page view runs an overdue refresh.
	 *
	 * @var string
	 */
	const LOCK_OPTION = 'wpbf_customizer_css_refresh_lock';

	/**
	 * Seconds after which a lock counts as abandoned.
	 *
	 * @var int
	 */
	const LOCK_TIMEOUT = 120;

	/**
	 * This request's entry, once known.
	 *
	 * @var array|null
	 */
	private static $current = null;

	/**
	 * Set up hooks.
	 */
	public static function init() {

		add_action( self::REFRESH_HOOK, array( __CLASS__, 'refreshWithFonts' ) );

		// Changes that can change the CSS.
		add_action( 'customize_save_after', array( __CLASS__, 'scheduleRefresh' ) );
		add_action( 'update_option_wpbf_settings', array( __CLASS__, 'scheduleRefresh' ) );
		add_action( 'add_option_wpbf_settings', array( __CLASS__, 'scheduleRefresh' ) );
		add_action( 'switch_theme', array( __CLASS__, 'scheduleRefresh' ) );
		add_action( 'upgrader_process_complete', array( __CLASS__, 'scheduleRefresh' ) );
		add_action( 'activated_plugin', array( __CLASS__, 'scheduleRefresh' ) );
		add_action( 'deactivated_plugin', array( __CLASS__, 'scheduleRefresh' ) );

		// Downloaded fonts cleared (theme settings, font system update): the cached font CSS points to deleted files.
		add_action( 'delete_option_wpbf_downloaded_google_fonts_css', array( __CLASS__, 'invalidate' ) );

	}

	/**
	 * Whether the cache is used for this request.
	 *
	 * @return bool
	 */
	public static function enabled() {

		return ! is_customize_preview() && apply_filters( 'wpbf_cache_customizer_css', true );

	}

	/**
	 * The fingerprint of everything the CSS depends on. Cheap: no CSS is built.
	 *
	 * @return string
	 */
	public static function key() {

		$parts = array(
			'format'    => self::FORMAT,
			'theme'     => defined( 'WPBF_VERSION' ) ? WPBF_VERSION : '',
			'premium'   => defined( 'WPBF_PREMIUM_VERSION' ) ? WPBF_PREMIUM_VERSION : '',
			'mods'      => get_theme_mods(),
			// Premium's settings page: breakpoints, color palette, blog layouts (archives), CSS file mode.
			'settings'  => get_option( 'wpbf_settings' ),
			'template'  => get_template(),
			'child'     => get_stylesheet(),
			// A child theme's CSS hooks change with its code.
			'child_php' => is_child_theme() ? (int) @filemtime( get_stylesheet_directory() . '/functions.php' ) : 0, // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
			'plugins'   => get_option( 'active_plugins' ),
			'network'   => is_multisite() ? get_site_option( 'active_sitewide_plugins' ) : '',
			// Media URLs in the CSS (Premium's custom fonts) follow the site URL and the request's scheme.
			'url'       => get_option( 'siteurl' ),
			'ssl'       => is_ssl(),
			// Downloaded Google Fonts: once missing fonts arrive (cron, Customizer preview), every fingerprint's entry is rebuilt
			// with them. Without this, an entry built while fonts were missing kept lacking them when the download ran under
			// another fingerprint (e.g. a server cron without https).
			'fonts'     => md5( maybe_serialize( get_option( 'wpbf_downloaded_google_fonts_css' ) ) ),
		);

		return md5( maybe_serialize( apply_filters( 'wpbf_customizer_css_key_parts', $parts ) ) );

	}

	/**
	 * This request's entry: from the cache, or built now (without font downloads) and stored.
	 *
	 * @return array [ 'css' => Customizer CSS, 'fonts' => Google Fonts CSS ]
	 */
	public static function current() {

		if ( null !== self::$current ) {
			return self::$current;
		}

		// Cache switched off by the filter (not in the preview, which prints its own CSS): build per request, as before.
		if ( ! self::enabled() ) {
			self::$current = self::build( true );

			if ( ! is_customize_preview() && 'file' === apply_filters( 'wpbf_css_output', 'inline' ) && ( ! file_exists( self::filePath() ) || file_get_contents( self::filePath() ) !== self::$current['css'] ) ) { // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
				self::writeFile( self::$current['css'] );
			}

			return self::$current;
		}

		$key   = self::key();
		$cache = self::cache();

		if ( isset( $cache['entries'][ $key ] ) ) {
			self::$current = $cache['entries'][ $key ];
		} else {
			self::$current = self::refresh( false, $key );
		}

		self::syncFile( $key );

		// WP-Cron that never runs (DISABLE_WP_CRON without a real cron): a page view runs the refresh, after its output.
		$next = wp_next_scheduled( self::REFRESH_HOOK );

		if ( false !== $next && $next < time() - self::OVERDUE_AFTER && apply_filters( 'wpbf_customizer_css_store', true ) ) {
			add_action( 'shutdown', array( __CLASS__, 'runOverdueRefresh' ), 1000 );
		}

		return self::$current;

	}

	/**
	 * Run an overdue scheduled refresh in this request (on shutdown), if no other request does already.
	 *
	 * Takes a lock first (add_option() only succeeds once), drops the overdue event so it can't run twice, ends the response
	 * to the visitor where the server allows it, then refreshes with font downloads. Paused fonts stay paused; a failure schedules the next retry as usual.
	 */
	public static function runOverdueRefresh() {

		$next = wp_next_scheduled( self::REFRESH_HOOK );

		if ( false === $next || $next >= time() - self::OVERDUE_AFTER ) {
			return;
		}

		if ( ! add_option( self::LOCK_OPTION, time() + self::LOCK_TIMEOUT, '', false ) ) {
			// Someone else holds it. Take it over only if it's abandoned.
			if ( (int) get_option( self::LOCK_OPTION ) > time() ) {
				return;
			}

			delete_option( self::LOCK_OPTION );

			if ( ! add_option( self::LOCK_OPTION, time() + self::LOCK_TIMEOUT, '', false ) ) {
				return;
			}
		}

		wp_unschedule_event( $next, self::REFRESH_HOOK );

		// Hand the page to the visitor first, where the server allows it (as wp-cron.php does).
		if ( function_exists( 'fastcgi_finish_request' ) ) {
			fastcgi_finish_request();
		} elseif ( function_exists( 'litespeed_finish_request' ) ) {
			litespeed_finish_request();
		}

		self::refreshWithFonts();

		delete_option( self::LOCK_OPTION );

	}

	/**
	 * Build and store the entry for this request's fingerprint.
	 *
	 * @param bool        $download_fonts Whether missing Google Fonts may be downloaded now.
	 * @param string|null $key The fingerprint, if known.
	 *
	 * @return array The entry.
	 */
	public static function refresh( $download_fonts, $key = null ) {

		$key   = null === $key ? self::key() : $key;
		$entry = self::build( $download_fonts );
		$cache = self::cache();

		// Newest first, a few at most.
		unset( $cache['entries'][ $key ] );
		$cache['entries'] = array_slice( array( $key => $entry ) + $cache['entries'], 0, self::MAX_ENTRIES, true );

		self::store( $cache );

		return $entry;

	}

	/**
	 * Cron: rebuild with font downloads, and write the file in "file" mode.
	 */
	public static function refreshWithFonts() {

		$key = self::key();

		self::refresh( true, $key );
		self::syncFile( $key );

	}

	/**
	 * Drop every cached entry and schedule a refresh. Until it ran, page views build their entry once (no downloads).
	 */
	public static function invalidate() {

		$cache            = self::cache();
		$cache['entries'] = array();

		self::store( $cache );
		self::$current = null;
		self::scheduleRefresh();

	}

	/**
	 * Schedule a refresh on WordPress cron (it runs on the next request without slowing it down).
	 *
	 * @param int $delay Seconds from now.
	 */
	public static function scheduleRefresh( $delay = 0 ) {

		// Dev tools (bin/snapshot) keep the database untouched.
		if ( ! apply_filters( 'wpbf_customizer_css_store', true ) ) {
			return;
		}

		$delay = is_int( $delay ) ? max( 0, $delay ) : 0;
		$next  = wp_next_scheduled( self::REFRESH_HOOK );

		if ( false !== $next && $next <= time() + $delay ) {
			return;
		}

		if ( false !== $next ) {
			wp_unschedule_event( $next, self::REFRESH_HOOK );
		}

		wp_schedule_single_event( time() + $delay, self::REFRESH_HOOK );

	}

	/**
	 * Build the CSS.
	 *
	 * @param bool $download_fonts Whether missing Google Fonts may be downloaded now.
	 *
	 * @return array [ 'css' => Customizer CSS, 'fonts' => Google Fonts CSS ]
	 */
	private static function build( $download_fonts ) {

		$fonts = new FontsOutput();

		return array(
			'css'   => wpbf_generate_css(),
			'fonts' => wpbf_minify_css( $fonts->generateGoogleFontsCss( $download_fonts ) ),
		);

	}

	/**
	 * In "file" mode, make sure the stylesheet holds this entry. Writes only when it doesn't.
	 *
	 * @param string $key The fingerprint of the entry.
	 */
	private static function syncFile( $key ) {

		if ( 'file' !== apply_filters( 'wpbf_css_output', 'inline' ) || ! self::enabled() ) {
			return;
		}

		$cache = self::cache();

		if ( ! isset( $cache['entries'][ $key ] ) ) {
			return;
		}

		if ( isset( $cache['file'] ) && $key === $cache['file'] && file_exists( self::filePath() ) ) {
			return;
		}

		if ( self::writeFile( $cache['entries'][ $key ]['css'] ) ) {
			$cache['file'] = $key;
			self::store( $cache );
		}

	}

	/**
	 * Write the stylesheet.
	 *
	 * @param string $css The CSS.
	 *
	 * @return bool Whether it was written.
	 */
	public static function writeFile( $css ) {

		if ( ! apply_filters( 'wpbf_customizer_css_store', true ) ) {
			return false;
		}

		global $wp_filesystem;

		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		if ( ! $wp_filesystem && ! WP_Filesystem() ) {
			return false;
		}

		$path = self::filePath();

		if ( ! file_exists( dirname( $path ) ) && ! wp_mkdir_p( dirname( $path ) ) ) {
			return false;
		}

		return (bool) $wp_filesystem->put_contents( $path, $css, FS_CHMOD_FILE );

	}

	/**
	 * The stylesheet's path.
	 *
	 * @return string
	 */
	public static function filePath() {

		$upload_dir = wp_upload_dir( null, false );

		return trailingslashit( $upload_dir['basedir'] ) . 'page-builder-framework/wpbf-customizer-styles.css';

	}

	/**
	 * The stylesheet's URL.
	 *
	 * @return string
	 */
	public static function fileUrl() {

		$upload_dir = wp_upload_dir( null, false );

		return trailingslashit( $upload_dir['baseurl'] ) . 'page-builder-framework/wpbf-customizer-styles.css';

	}

	/**
	 * Read the cache.
	 *
	 * @return array
	 */
	private static function cache() {

		$cache = get_option( self::OPTION );

		if ( ! is_array( $cache ) || ! isset( $cache['entries'] ) || ! is_array( $cache['entries'] ) ) {
			$cache = array( 'entries' => array() );
		}

		return $cache;

	}

	/**
	 * Write the cache (loaded with every page, it's needed on every page).
	 *
	 * @param array $cache The cache.
	 */
	private static function store( $cache ) {

		// Dev tools (bin/snapshot) switch storing off to keep the database untouched.
		if ( ! apply_filters( 'wpbf_customizer_css_store', true ) ) {
			return;
		}

		update_option( self::OPTION, $cache, true );

	}

}
