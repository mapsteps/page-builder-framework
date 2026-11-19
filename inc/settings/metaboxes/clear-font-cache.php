<?php
/**
 * Metabox template for displaying clear font cache.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// The Google Fonts stored on this site: font family => its styles ("regular", "700", "700italic" …).
$wpbf_stored_fonts = get_option( 'wpbf_downloaded_google_fonts', array() );
$wpbf_stored_fonts = is_array( $wpbf_stored_fonts ) ? $wpbf_stored_fonts : array();

// Each chip shows its font in that font: one stored style per family, from the site's own font files.
$wpbf_fonts_util = new Mapsteps\Wpbf\Customizer\Controls\Typography\FontsUtil();
$wpbf_stored_css = $wpbf_fonts_util->getDownloadedGoogleFontsCss();
$wpbf_chip_css   = '';

foreach ( $wpbf_stored_fonts as $wpbf_font_family => $wpbf_font_styles ) {
	$wpbf_font_styles = (array) $wpbf_font_styles;
	$wpbf_font_style  = (string) reset( $wpbf_font_styles );
	$wpbf_font_key    = $wpbf_fonts_util->slugifyFontFamily( $wpbf_font_family ) . '_' . ( '400' === $wpbf_font_style ? 'regular' : $wpbf_font_style );

	if ( isset( $wpbf_stored_css[ $wpbf_font_key ] ) ) {
		$wpbf_chip_css .= $wpbf_stored_css[ $wpbf_font_key ];
	}
}

// Same address scheme as the admin page (the stored rules may have http:// links).
$wpbf_fonts_url = content_url( '/fonts' );
$wpbf_chip_css  = str_replace(
	array( set_url_scheme( $wpbf_fonts_url, 'https' ), set_url_scheme( $wpbf_fonts_url, 'http' ) ),
	preg_replace( '#^https?:#i', '', $wpbf_fonts_url ),
	wp_strip_all_tags( $wpbf_chip_css )
);
?>

<?php if ( $wpbf_chip_css ) : ?>
	<style><?php echo $wpbf_chip_css; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Font-face rules the theme stored from Google's stylesheet. ?></style>
<?php endif; ?>

<div class="heatbox wpbf-remove-downloaded-fonts-metabox">
	<h2><?php esc_html_e( 'Clear Font Cache', 'page-builder-framework' ); ?></h2>
	<div class="heatbox-content">
		<p>
			<?php esc_html_e( 'Google Fonts are stored on your server. If a font doesn\'t show correctly, clear the cache. Safe on live sites.', 'page-builder-framework' ); ?>
		</p>
		<?php if ( $wpbf_stored_fonts ) : ?>
			<ul class="wpbf-font-chips" aria-label="<?php esc_attr_e( 'Stored fonts', 'page-builder-framework' ); ?>">
				<?php foreach ( $wpbf_stored_fonts as $wpbf_font_family => $wpbf_font_styles ) : ?>
					<li class="wpbf-font-chip">
						<span class="wpbf-font-chip-name" style="font-family: '<?php echo esc_attr( $wpbf_font_family ); ?>', sans-serif;"><?php echo esc_html( $wpbf_font_family ); ?></span>
						<span class="wpbf-font-chip-styles">
							<?php
							$wpbf_style_count = count( (array) $wpbf_font_styles );
							/* translators: %d: number of font styles, e.g. regular, 600, 700 */
							echo esc_html( sprintf( _n( '%d style', '%d styles', $wpbf_style_count, 'page-builder-framework' ), $wpbf_style_count ) );
							?>
						</span>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php else : ?>
			<p class="description"><?php esc_html_e( 'No Google Fonts are stored right now.', 'page-builder-framework' ); ?></p>
		<?php endif; ?>
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
