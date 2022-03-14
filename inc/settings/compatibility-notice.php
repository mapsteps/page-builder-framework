<?php
/**
 * Premium Add-On compatibility notice template.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

?>

<div class="notice notice-error wpbf-compatibility-notice">
	<div class="notice-body">
		<div class="notice-icon">
			<img src="<?php echo esc_url( WPBF_THEME_URI ); ?>/img/page-builder-framework-logo-blue.png" alt="Page Builder Framework Logo">
		</div>
		<div class="notice-content">
			<h2>
				<?php _e( 'Premium Add-On - Compatibility Warning', 'page-builder-framework' ); ?>
			</h2>
			<p>
				<?php _e( 'Your version of the <strong>Premium Add-On</strong> is outdated and no longer compatible with Page Builder Framework.', 'page-builder-framework' ); ?> <br>
				<?php _e( 'Please update the Premium Add-On to the latest version.', 'page-builder-framework' ); ?> <br>
			</p>
			<p>
				<a href="<?php echo esc_url( admin_url( 'update-core.php' ) ); ?>" class="button">
					<?php _e( 'View Updates', 'page-builder-framework' ); ?>
				</a>
				<a href="https://wp-pagebuilderframework.com/purchase-history/" class="button button-primary">
					<?php _e( 'Manage Subscription', 'page-builder-framework' ); ?>
				</a>
			</p>
		</div>
	</div>
</div>
