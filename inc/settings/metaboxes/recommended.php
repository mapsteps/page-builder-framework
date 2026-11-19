<?php
/**
 * Metabox template for displaying recommended plugins.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// "constants": the plugin counts as installed (active) when one of them is defined.
$wpbf_recommended_plugins = array(
	array(
		'title'       => __( 'Premium Add-On', 'page-builder-framework' ),
		'description' => __( 'Take your website to the next level with the Premium Add-On for Page Builder Framework.', 'page-builder-framework' ),
		'banner'      => WPBF_THEME_URI . '/img/premium-add-on-banner-2.jpg',
		'link'        => 'https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf',
		'repo'        => false,
		'constants'   => array( 'WPBF_PREMIUM_VERSION' ),
	),
	array(
		'title'       => __( 'Better Admin Bar', 'page-builder-framework' ),
		'description' => __( 'Quickly access all important areas of your WordPress website & provide your clients with the user experience they deserve.', 'page-builder-framework' ),
		'banner'      => 'https://ps.w.org/better-admin-bar/assets/banner-772x250.png',
		'link'        => admin_url( 'plugin-install.php?s=better+admin+bar&tab=search&type=term' ),
		'repo'        => true,
		'constants'   => array( 'SWIFT_CONTROL_PLUGIN_VERSION', 'SWIFT_CONTROL_PRO_PLUGIN_VERSION' ),
	),
	array(
		'title'       => __( 'WP Video Popup', 'page-builder-framework' ),
		'description' => __( 'Add beautiful WordPress video lightbox popups to your website without sacrificing performance.', 'page-builder-framework' ),
		'banner'      => 'https://ps.w.org/responsive-youtube-vimeo-popup/assets/banner-772x250.jpg',
		'link'        => admin_url( 'plugin-install.php?s=wp+video+popup&tab=search&type=term' ),
		'repo'        => true,
		'constants'   => array( 'WP_VIDEO_POPUP_PLUGIN_VERSION' ),
	),
	array(
		'title'       => __( 'Ultimate Dashboard', 'page-builder-framework' ),
		'description' => __( 'Ultimate Dashboard is the #1 plugin to customize your WordPress Dashboard.', 'page-builder-framework' ),
		'banner'      => 'https://ps.w.org/ultimate-dashboard/assets/banner-772x250.jpg',
		'link'        => admin_url( 'plugin-install.php?s=ultimate+dashboard&tab=search&type=term' ),
		'repo'        => true,
		'constants'   => array( 'ULTIMATE_DASHBOARD_PLUGIN_URL' ),
	),
	array(
		'title'       => __( 'Customizer Reset - Export & Import', 'page-builder-framework' ),
		'description' => __( 'Reset, Export & Import your WordPress customizer settings with a simple click of a button.', 'page-builder-framework' ),
		'banner'      => 'https://ps.w.org/customizer-reset/assets/banner-772x250.jpg',
		'link'        => admin_url( 'plugin-install.php?s=customizer+reset+export+import&tab=search&type=term' ),
		'repo'        => true,
		'constants'   => array( 'CUSTOMIZER_RESET_PLUGIN_VERSION' ),
	),
	array(
		'title'       => __( 'Toolset', 'page-builder-framework' ),
		'description' => __( 'A set of plugins to help you build dynamic, advanced websites without programming.', 'page-builder-framework' ),
		'banner'      => WPBF_THEME_URI . '/img/toolset-banner.png',
		'link'        => 'https://toolset.com/',
		'repo'        => false,
		'constants'   => array( 'WPV_VERSION' ),
	),
	array(
		'title'       => 'Weglot',
		'description' => __( 'The Weglot translation plugin gives you a reliable and easy way to take your WordPress website from local to global in minutes. No coding required and no developer time needed.', 'page-builder-framework' ),
		'banner'      => 'https://ps.w.org/weglot/assets/banner-772x250.png',
		'link'        => admin_url( 'plugin-install.php?s=weglot&tab=search&type=term' ),
		'repo'        => true,
		'constants'   => array( 'WEGLOT_VERSION' ),
	),
	array(
		'title'       => __( 'WPML', 'page-builder-framework' ),
		'description' => __( 'WPML is a popular translation plugin that helps you create a multilingual website for your business or blog.', 'page-builder-framework' ),
		'banner'      => WPBF_THEME_URI . '/img/banner-wpml.png',
		'link'        => 'https://wpml.org/',
		'repo'        => false,
		'constants'   => array( 'WPML_PLUGIN_BASENAME' ),
	),
);

?>

<div class="heatbox-columns wpbf-recommended-list">

	<?php
	foreach ( $wpbf_recommended_plugins as $wpbf_plugin ) :

		$wpbf_installed = false;

		foreach ( $wpbf_plugin['constants'] as $wpbf_constant ) {
			if ( defined( $wpbf_constant ) ) {
				$wpbf_installed = true;
			}
		}

		// Plugins from wordpress.org open the "Add Plugins" screen, the others their website in a new tab.
		$wpbf_new_tab = ! $wpbf_plugin['repo'];
		?>

		<div class="heatbox">
			<a href="<?php echo esc_url( $wpbf_plugin['link'] ); ?>"<?php echo $wpbf_new_tab ? ' target="_blank"' : ''; ?> aria-hidden="true" tabindex="-1">
				<img src="<?php echo esc_url( $wpbf_plugin['banner'] ); ?>" alt="">
			</a>
			<div class="heatbox-content">
				<h3><?php echo esc_html( $wpbf_plugin['title'] ); ?></h3>
				<p class="description"><?php echo esc_html( $wpbf_plugin['description'] ); ?></p>
				<div class="wpbf-recommended-action">
					<?php if ( $wpbf_installed ) : ?>
						<span class="heatbox-badge is-success"><?php esc_html_e( 'Installed', 'page-builder-framework' ); ?></span>
					<?php else : ?>
						<a href="<?php echo esc_url( $wpbf_plugin['link'] ); ?>"<?php echo $wpbf_new_tab ? ' target="_blank"' : ''; ?> class="button">
							<?php
							if ( $wpbf_plugin['repo'] ) {
								esc_html_e( 'Install', 'page-builder-framework' );
							} else {
								esc_html_e( 'Learn More', 'page-builder-framework' );
							}
							?>
							<span class="screen-reader-text">
								<?php
								echo esc_html( $wpbf_plugin['title'] );

								if ( $wpbf_new_tab ) {
									echo ' ';
									esc_html_e( '(opens in a new tab)', 'page-builder-framework' );
								}
								?>
							</span>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>

	<?php endforeach; ?>

</div>
