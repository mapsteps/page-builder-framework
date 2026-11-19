<?php
/**
 * Metabox template for displaying recommended plugins: our own first, then our partners'.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/*
 * "slug": the plugin's wordpress.org slug (one-click install), or empty for plugins that aren't on wordpress.org.
 * "files": the plugin files (folder/file.php) that count as this plugin, e.g. its free and PRO version.
 * "partner": a partner's plugin (listed in its own section after ours).
 */
$wpbf_recommended_plugins = array(
	array(
		'title'       => __( 'Swift SMTP', 'page-builder-framework' ),
		'description' => __( 'Send your emails through SMTP, log them and customize welcome emails.', 'page-builder-framework' ),
		'banner'      => 'https://ps.w.org/welcome-email-editor/assets/banner-772x250.jpg',
		'slug'        => 'welcome-email-editor',
		'files'       => array( 'welcome-email-editor/sb_welcome_email_editor.php' ),
	),
	array(
		'title'       => __( 'Ultimate Dashboard', 'page-builder-framework' ),
		'description' => __( 'Your own dashboard widgets, a custom login screen and a cleaner admin.', 'page-builder-framework' ),
		'banner'      => 'https://ps.w.org/ultimate-dashboard/assets/banner-772x250.jpg',
		'slug'        => 'ultimate-dashboard',
		'files'       => array( 'ultimate-dashboard/ultimate-dashboard.php' ),
	),
	array(
		'title'       => __( 'Better Admin Bar', 'page-builder-framework' ),
		'description' => __( 'The admin bar reimagined: a quick access panel, auto-hide and more.', 'page-builder-framework' ),
		'banner'      => 'https://ps.w.org/better-admin-bar/assets/banner-772x250.png',
		'slug'        => 'better-admin-bar',
		'files'       => array( 'better-admin-bar/better-admin-bar.php', 'swift-control-pro/swift-control-pro.php' ),
	),
	array(
		'title'       => __( 'WP Video Popup', 'page-builder-framework' ),
		'description' => __( 'Lightweight, privacy-friendly YouTube, Vimeo & Rumble video popups.', 'page-builder-framework' ),
		'banner'      => 'https://ps.w.org/responsive-youtube-vimeo-popup/assets/banner-772x250.jpg',
		'slug'        => 'responsive-youtube-vimeo-popup',
		'files'       => array( 'responsive-youtube-vimeo-popup/responsive-youtube-vimeo-popup.php', 'wp-video-popup-pro/wp-video-popup-pro.php' ),
	),
	array(
		'title'       => __( 'Media Toolkit', 'page-builder-framework' ),
		'description' => __( 'Optimize your images, convert them to WebP and set a maximum size.', 'page-builder-framework' ),
		'banner'      => 'https://ps.w.org/media-toolkit/assets/banner-772x250.jpg',
		'slug'        => 'media-toolkit',
		'files'       => array( 'media-toolkit/media-toolkit.php' ),
	),
	array(
		'title'       => __( 'Customizer Reset', 'page-builder-framework' ),
		'description' => __( 'Reset, export & import your Customizer settings in one click.', 'page-builder-framework' ),
		'banner'      => 'https://ps.w.org/customizer-reset/assets/banner-772x250.jpg',
		'slug'        => 'customizer-reset',
		'files'       => array( 'customizer-reset/customizer-reset.php' ),
	),
	array(
		'title'       => 'Weglot',
		'description' => __( 'Translate your website into other languages in minutes, no coding needed.', 'page-builder-framework' ),
		'banner'      => 'https://ps.w.org/weglot/assets/banner-772x250.png',
		'slug'        => 'weglot',
		'files'       => array( 'weglot/weglot.php' ),
		'partner'     => true,
	),
	array(
		'title'       => 'WPML',
		'description' => __( 'The popular plugin to make your website multilingual.', 'page-builder-framework' ),
		'banner'      => WPBF_THEME_URI . '/img/banner-wpml.png',
		'link'        => 'https://wpml.org/',
		'slug'        => '',
		'files'       => array( 'sitepress-multilingual-cms/sitepress.php' ),
		'partner'     => true,
	),
);

$wpbf_installed_plugins = get_plugins();

$wpbf_plugin_groups = array(
	__( 'From the makers of Page Builder Framework', 'page-builder-framework' ) => wp_list_filter( $wpbf_recommended_plugins, array( 'partner' => true ), 'NOT' ),
	__( 'Partners', 'page-builder-framework' ) => wp_list_filter( $wpbf_recommended_plugins, array( 'partner' => true ) ),
);

?>

<?php foreach ( $wpbf_plugin_groups as $wpbf_group_title => $wpbf_group_plugins ) : ?>

<h2 class="wpbf-recommended-heading"><?php echo esc_html( $wpbf_group_title ); ?></h2>

<div class="heatbox-columns wpbf-recommended-list">

	<?php
	foreach ( $wpbf_group_plugins as $wpbf_plugin ) :

		// Where the plugin stands: active, installed (switched off) or not installed.
		$wpbf_status    = 'missing';
		$wpbf_installed = '';

		foreach ( $wpbf_plugin['files'] as $wpbf_plugin_file ) {
			if ( is_plugin_active( $wpbf_plugin_file ) ) {
				$wpbf_status = 'active';
				break;
			}

			if ( ! $wpbf_installed && isset( $wpbf_installed_plugins[ $wpbf_plugin_file ] ) ) {
				$wpbf_status    = 'installed';
				$wpbf_installed = $wpbf_plugin_file;
			}
		}

		// The plugin's page: wordpress.org for plugins from there, otherwise the plugin's website.
		$wpbf_info_link = $wpbf_plugin['slug'] ? 'https://wordpress.org/plugins/' . $wpbf_plugin['slug'] . '/' : $wpbf_plugin['link'];
		?>

		<div class="heatbox">
			<a href="<?php echo esc_url( $wpbf_info_link ); ?>" target="_blank" aria-hidden="true" tabindex="-1">
				<img src="<?php echo esc_url( $wpbf_plugin['banner'] ); ?>" alt="">
			</a>
			<div class="heatbox-content">
				<h3><?php echo esc_html( $wpbf_plugin['title'] ); ?></h3>
				<p class="description"><?php echo esc_html( $wpbf_plugin['description'] ); ?></p>
				<div class="wpbf-recommended-action">
					<?php if ( 'active' === $wpbf_status ) : ?>

						<span class="button wpbf-plugin-active">
							<?php wpbf_theme_settings_icon( '<path d="M20 6 9 17l-5-5"/>', 'wpbf-plugin-active-icon' ); ?>
							<?php esc_html_e( 'Active', 'page-builder-framework' ); ?>
						</span>

					<?php elseif ( 'installed' === $wpbf_status && current_user_can( 'activate_plugins' ) ) : ?>

						<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'plugins.php?action=activate&plugin=' . rawurlencode( $wpbf_installed ) ), 'activate-plugin_' . $wpbf_installed ) ); ?>" class="button button-primary">
							<?php esc_html_e( 'Activate', 'page-builder-framework' ); ?>
							<span class="screen-reader-text"><?php echo esc_html( $wpbf_plugin['title'] ); ?></span>
						</a>

					<?php elseif ( 'missing' === $wpbf_status && $wpbf_plugin['slug'] && current_user_can( 'install_plugins' ) ) : ?>

						<a href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=' . $wpbf_plugin['slug'] ), 'install-plugin_' . $wpbf_plugin['slug'] ) ); ?>" class="button">
							<?php esc_html_e( 'Install', 'page-builder-framework' ); ?>
							<span class="screen-reader-text"><?php echo esc_html( $wpbf_plugin['title'] ); ?></span>
						</a>

					<?php else : ?>

						<a href="<?php echo esc_url( $wpbf_info_link ); ?>" target="_blank" class="button">
							<?php esc_html_e( 'Learn More', 'page-builder-framework' ); ?>
							<span class="screen-reader-text"><?php echo esc_html( $wpbf_plugin['title'] . ' ' . __( '(opens in a new tab)', 'page-builder-framework' ) ); ?></span>
						</a>

					<?php endif; ?>
				</div>
			</div>
		</div>

	<?php endforeach; ?>

</div>

<?php endforeach; ?>
