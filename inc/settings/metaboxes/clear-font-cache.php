<?php
/**
 * Metabox template for displaying clear font cache.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );
?>

<div class="heatbox wpbf-remove-downloaded-fonts-metabox">
	<h2><?php esc_html_e( 'Clear Font Cache', 'page-builder-framework' ); ?></h2>
	<div class="heatbox-content">
		<p>
			<?php esc_html_e( 'In order to achieve GDPR-compliance, we store Google Fonts locally on your server.', 'page-builder-framework' ); ?>
			<?php esc_html_e( 'If Google Fonts selected in the Customizer are not displayed correctly, please try clearing the Font Cache.', 'page-builder-framework' ); ?>
		</p>
		<p class="description">
			<?php esc_html_e( 'This is safe to do on production sites.', 'page-builder-framework' ); ?>
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
