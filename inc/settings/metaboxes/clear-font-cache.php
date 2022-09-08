<?php
/**
 * Metabox template for displaying clear font cache.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );
?>

<div class="heatbox wpbf-remove-downloaded-fonts-metabox">
	<h2><?php _e( 'Clear Font Cache', 'page-builder-framework' ); ?></h2>
	<div class="heatbox-content">
		<p>
			<?php _e( 'In order to achieve GDPR-compliance, we store Google Fonts locally on your server.', 'page-builder-framework' ); ?><br>
			<?php _e( 'If Google Fonts selected in the Customizer are not displayed correctly, please try clearing the Font Cache.', 'page-builder-framework' ); ?>
		</p>
		<p>
			<?php _e( 'This is safe to do on production sites.', 'page-builder-framework' ); ?>
		</p>
		<button
			type="button"
			class="button button-larger button-primary wpbf-remove-downloaded-fonts"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'WPBF_Clear_Font_Cache' ) ); ?>"
		>
			<?php _e( 'Clear Cache', 'page-builder-framework' ); ?>
		</button>
		<span class="submission-status is-hidden"></span>
	</div>
</div>
