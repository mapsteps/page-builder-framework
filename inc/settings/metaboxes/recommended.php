<?php
/**
 * Metabox template for displaying recommended plugins.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );
?>

<div class="wpbf-recommended-metabox">

	<ul class="wpbf-recommended-list">

		<?php

			$recommended_plugins = array(
				array(
					'title'       => __( 'Premium Add-On', 'page-builder-framework' ),
					'description' => __( 'Take your website to the next level with the Premium Add-On.', 'page-builder-framework' ),
					'banner'      => '',
					'link'        => 'https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf#premium',
					'repo'        => false,
					'constant'    => 'WPBF_PREMIUM_VERSION',
				),
				array(
					'title'       => __( 'Ultimate Dashboard', 'page-builder-framework' ),
					'description' => __( 'Create a customizable Transparent Header with just a few clicks.', 'page-builder-framework' ),
					'banner'      => 'https://ps.w.org/ultimate-dashboard/assets/banner-772x250.jpg',
					'link'        => admin_url( 'plugin-install.php?s=ultimate+dashboard&tab=search&type=term' ),
					'repo'        => true,
					'constant'    => 'ULTIMATE_DASHBOARD_PLUGIN_URL',
				),
				array(
					'title'       => __( 'Customizer Reset - Export & Import', 'page-builder-framework' ),
					'description' => __( 'Reset, Export & Import your customizer settings with a simple click of a button.', 'page-builder-framework' ),
					'banner'      => 'https://ps.w.org/customizer-reset/assets/banner-772x250.jpg',
					'link'        => admin_url( 'plugin-install.php?s=customizer+reset+export+import&tab=search&type=term' ),
					'repo'        => true,
					'constant'    => 'CUSTOMIZER_RESET_PLUGIN_VERSION',
				),
				array(
					'title'       => __( 'Swift Control', 'page-builder-framework' ),
					'description' => __( 'Quickly access all important areas of your WordPress website.', 'page-builder-framework' ),
					'banner'      => 'https://ps.w.org/swift-control/assets/banner-772x250.jpg',
					'link'        => 'https://wpswiftcontrol.com/',
					'repo'        => false,
					'constant'    => 'SWIFT_CONTROL_PRO_PLUGIN_VERSION',
				),
			);

			foreach ( $recommended_plugins as $recommended_plugin ) {

				?>

				<li class="heatbox">
					<a href="<?php echo esc_url( $recommended_plugin['link'] ); ?>" target="_blank">
						<img src="<?php echo esc_html( $recommended_plugin['banner'] ); ?>" alt="<?php echo esc_html( $recommended_plugin['title'] ); ?>">
					</a>
					<div class="wpbf-recommended-content">
						<h3>
							<?php echo esc_html( $recommended_plugin['title'] ); ?>
						</h3>
						<p>
							<?php echo esc_html( $recommended_plugin['description'] ); ?>
						</p>
					</div>
					<div class="wpbf-recommended-status">
						<?php if ( defined( $recommended_plugin['constant'] ) ) : ?>
							<div class="wpbf-recommended-status-action">
								<a href="<?php echo admin_url( 'plugins.php' ); ?>" class="button button-large"><?php _e( 'Installed', 'page-builder-framework' ); ?></i></a>
							</div>
							<div class="wpbf-recommended-status-icon green">
								<i class="dashicons dashicons-yes-alt"></i>
							</div>
						<?php else : ?>
							<div class="wpbf-recommended-status-action">
								<a href="<?php echo esc_url( $recommended_plugin['link'] ); ?>" target="_blank" class="button button-primary button-large">
									<?php
										if ( $recommended_plugin['repo'] ) {
											_e( 'Install', 'page-builder-framework' );
										} else {
											_e( 'Learn More', 'page-builder-framework' );
										}
									?>
								</a>
							</div>
							<div class="wpbf-recommended-status-icon">
								<i class="dashicons dashicons-yes-alt"></i>
							</div>
						<?php endif; ?>
					</div>
				</li>

				<?php

			}

		?>

	</ul>

</div>
