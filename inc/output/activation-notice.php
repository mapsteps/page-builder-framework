<?php
/**
 * Theme activation notice's template.
 *
 * @package Page_Builder_Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$screen = get_current_screen();
?>

<div class="notice notice-info nice-notice wpbf-activation-notice is-dismissible">
	<div class="notice-body has-icon">
		<div class="notice-icon">
			<img src="<?php echo esc_url( WPBF_THEME_URI ); ?>/img/page-builder-framework-logo-blue.png" alt="Page Builder Framework Logo">
		</div>
		<div class="notice-content">
			<h2>
				<?php _e( 'Thanks for activating Page Builder Framework!', 'page-builder-framework' ); ?>
			</h2>

			<p>
				<?php if ( wpbf_is_premium() ) : ?>

					<?php
					_e(
						"We see that you also have the <strong>Premium Add-On</strong> active which means that you have powerful theme customization.<br>
						Let's get started and enjoy building your theme!",
						'page-builder-framework'
					);
					?>

				<?php else : ?>

					<?php
					_e(
						'We strongly recommend you to activate the <strong>Premium Add-On</strong>.<br>
						This way you will have more powerful customization and some other nice features.',
						'page-builder-framework'
					);
					?>

				<?php endif; ?>
			</p>

			<?php if ( wpbf_is_premium() ) : ?>

			<?php else : ?>

			<?php endif; ?>

			<p class="buttons">
				<?php if ( wpbf_is_premium() ) : ?>

					<?php if ( 'appearance_page_wpbf-premium' !== $screen->id ) : ?>
						<a href="<?php echo esc_url( admin_url( 'themes.php?page=wpbf-premium&tab=customizer' ) ); ?>" class="button button-primary">
							<?php _e( 'Theme Settings', 'page-builder-framework' ); ?>
						</a>
					<?php endif; ?>

				<?php else : ?>

					<a href="https://wp-pagebuilderframework.com/premium/" target="_blank" class="button button-primary">
						<?php _e( 'Buy Premium Add-On', 'page-builder-framework' ); ?>
					</a>

					<?php if ( 'appearance_page_wpbf-premium' !== $screen->id ) : ?>
						<a href="<?php echo esc_url( admin_url( 'themes.php?page=wpbf-premium&tab=customizer' ) ); ?>" class="button">
							<?php _e( 'Theme Settings', 'page-builder-framework' ); ?>
						</a>
					<?php endif; ?>

				<?php endif; ?>
			</p>
		</div>
		</div>
</div>
