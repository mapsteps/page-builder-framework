<?php
/**
 * Metabox template for displaying clear font cache.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// The Google Fonts stored on this site: font family => its styles.
$wpbf_stored_fonts = get_option( 'wpbf_downloaded_google_fonts', array() );
$wpbf_stored_fonts = is_array( $wpbf_stored_fonts ) ? array_keys( $wpbf_stored_fonts ) : array();
?>

<div class="heatbox wpbf-remove-downloaded-fonts-metabox">
	<h2><?php esc_html_e( 'Clear Font Cache', 'page-builder-framework' ); ?></h2>
	<div class="heatbox-content">
		<p>
			<?php esc_html_e( 'Google Fonts are stored on your server. If a font doesn\'t show correctly, clear the cache. Safe on live sites.', 'page-builder-framework' ); ?>
		</p>
		<p class="description">
			<?php
			if ( $wpbf_stored_fonts ) {
				/* translators: %s: comma-separated list of font names, e.g. "Inter, Rubik" */
				echo esc_html( sprintf( __( 'Stored now: %s', 'page-builder-framework' ), implode( ', ', $wpbf_stored_fonts ) ) );
			} else {
				esc_html_e( 'No Google Fonts are stored right now.', 'page-builder-framework' );
			}
			?>
		</p>
		<div class="wpbf-button-with-notice">
			<button
				type="button"
				class="button button-primary wpbf-remove-downloaded-fonts"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'WPBF_Clear_Font_Cache' ) ); ?>"
			>
				<?php esc_html_e( 'Clear Cache', 'page-builder-framework' ); ?>
			</button>
			<span class="heatbox-notice wpbf-remove-downloaded-fonts-notice" role="status" data-error="<?php esc_attr_e( 'Something went wrong.', 'page-builder-framework' ); ?>"></span>
		</div>
	</div>
</div>
