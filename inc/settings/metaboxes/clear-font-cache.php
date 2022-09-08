<?php
/**
 * Metabox template for displaying clear font cache.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );
?>

<div class="heatbox wpbf-remove-downloaded-fonts-metabox">
	<h2><?php _e( 'Remove downloaded fonts', 'page-builder-framework' ); ?></h2>
	<div class="heatbox-content">
		<p>
			<?php _e( 'Google fonts are downloaded to your site for privacy concern. If you need to remove them, then you can delete the "fonts" directory under "wp-content" directory. Or you can simply click this button.', 'page-builder-framework' ); ?>
		</p>
		<button
			type="button"
			class="button is-danger wpbf-remove-downloaded-fonts"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'WPBF_Clear_Font_Cache' ) ); ?>"
		>
			<?php _e( 'Remove downloaded fonts', 'page-builder-framework' ); ?>
		</button>
		<span class="submission-status is-hidden"></span>
	</div>
</div>
