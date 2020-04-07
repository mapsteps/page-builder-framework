<?php
/**
 * Theme activation notice's template.
 *
 * @package Page Builder Framework
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
				<?php _e( 'Welcome to Page Builder Framework!', 'page-builder-framework' ); ?>
			</h2>

			<p>
				<?php _e( 'Thank you for choosing Page Builder Framework! Please visit the theme settings page to get started.', 'page-builder-framework' ); ?>
			</p>

			<?php if ( 'appearance_page_wpbf-premium' !== $screen->id ) : ?>
			<p class="buttons">
				<a href="<?php echo esc_url( admin_url( 'themes.php?page=wpbf-premium' ) ); ?>" class="button button-primary">
					<?php _e( 'Get Started', 'page-builder-framework' ); ?>
				</a>
			</p>
			<?php endif; ?>
		</div>
	</div>
</div>
