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
				<?php esc_html_e( 'Premium Add-On - Compatibility Warning', 'page-builder-framework' ); ?>
			</h2>
			<p>
				<?php echo wp_kses( __( 'Your version of the <strong>Premium Add-On</strong> is outdated and no longer compatible with the latest version of <strong>Page Builder Framework.</strong>', 'page-builder-framework' ), array( 'strong' => array() ) ); ?> <br>
				<?php esc_html_e( 'Please update the Premium Add-On to the latest version.', 'page-builder-framework' ); ?> <br>
				<?php
				/* translators: 1: installed Premium Add-On version, 2: minimum version needed */
				printf( esc_html__( 'You have version %1$s, Page Builder Framework needs %2$s or newer. Until you update, some Premium Add-On features may not work.', 'page-builder-framework' ), esc_html( WPBF_PREMIUM_VERSION ), esc_html( WPBF_PREMIUM_MIN_VERSION ) );
				?>
			</p>
			<p>
				<a href="<?php echo esc_url( admin_url( 'update-core.php' ) ); ?>" class="button">
					<?php esc_html_e( 'View Updates', 'page-builder-framework' ); ?>
				</a>
				<a href="https://wp-pagebuilderframework.com/purchase-history/" class="button button-primary">
					<?php esc_html_e( 'Manage Subscription', 'page-builder-framework' ); ?>
				</a>
			</p>
		</div>
	</div>
</div>
