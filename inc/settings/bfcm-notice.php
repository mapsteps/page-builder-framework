<?php
/**
 * Theme activation notice's template.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$bfcm_url = 'https://mailoptin.io/pricing/?utm_source=wp-admin&utm_medium=admin-notice&utm_id=bf2021';
?>

<div class="notice notice-info wpbf-activation-notice is-dismissible">
	<div class="notice-body">
		<div class="notice-icon">
			<img src="<?php echo esc_url( WPBF_THEME_URI ); ?>/img/page-builder-framework-logo-blue.png" alt="Page Builder Framework Logo">
		</div>
		<div class="notice-content">
			<h2>
				<?php _e( 'Huge Black Friday Sale - Up to 30% Off!*', 'page-builder-framework' ); ?>
			</h2>
			<p>
				<?php _e( 'Upgrade to the <strong>Premium Add-On</strong> for Page Builder Framework today!', 'page-builder-framework' ); ?>
			</p>
			<p>
				<?php _e( 'Hurry up! The deal will expire soon!', 'page-builder-framework' ); ?><br>
				<em><?php _e( 'All prices are reduced. No coupon code required.', 'page-builder-framework' ); ?></em>
			</p>
			<p>
				<a href="<?php echo esc_url( $bfcm_url ); ?>" class="button button-primary">
					<?php _e( 'Get the Deal', 'page-builder-framework' ); ?>
				</a>
				<small><?php _e( '*Only Administrators will see this message!', 'page-builder-framework' ); ?></small>
			</p>
		</div>
	</div>
</div>
