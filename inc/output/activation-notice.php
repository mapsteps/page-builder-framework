<?php
/**
 * Theme activation notice's template.
 *
 * @package Page_Builder_Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

global $wpbf_activation_notice_dismissal_nonce;

$screen = get_current_screen();
?>

<div class="notice notice-info nice-notice wpbf-activation-notice is-dismissible">
	<div class="notice-body has-icon">
		<div class="notice-icon">
			<img src="<?php echo esc_url( WPBF_THEME_URI ); ?>/img/page-builder-framework-logo-blue.png" alt="Page Builder Framework Logo">
		</div>
		<div class="notice-content">
			<h2>
				<?php _e( 'Thanks for choosing Page Builder Framework!', 'page-builder-framework' ); ?>
			</h2>

			<p>

				<?php
				_e(
					'We strongly recommend you to activate the <strong>Premium Add-On</strong>.<br>
					This way you will have more powerful customization and some other nice features.',
					'page-builder-framework'
				);
				?>

			</p>

			<?php if ( 'appearance_page_wpbf-premium' !== $screen->id ) : ?>
			<p class="buttons">
				<a href="<?php echo esc_url( admin_url( 'themes.php?page=wpbf-premium&tab=customizer&action=wpbf_activation_notice_dismissal&dismiss=1&nonce=' . $wpbf_activation_notice_dismissal_nonce ) ); ?>" class="button">
					<?php _e( 'Theme Settings', 'page-builder-framework' ); ?>
				</a>
			</p>
			<?php endif; ?>
		</div>
	</div>
</div>
