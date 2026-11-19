<?php
/**
 * Theme settings page template.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$wpbf_tabs = array(
	'settings'    => __( 'Getting Started', 'page-builder-framework' ),
	'premium'     => __( 'Premium', 'page-builder-framework' ),
	'recommended' => __( 'Recommended', 'page-builder-framework' ),
);

?>

<div class="wrap heatbox-wrap wpbf-theme-settings-page">

	<div class="heatbox-header heatbox-has-tab-nav heatbox-margin-bottom">

		<div class="heatbox-container heatbox-container-center">

			<div class="logo-container">

				<div>
					<h1 class="title">
						<?php echo esc_html( get_admin_page_title() ); ?>
						<span class="version"><?php echo esc_html( WPBF_VERSION ); ?></span>
					</h1>
					<p class="subtitle"><?php esc_html_e( 'A modern, fast & minimalistic theme designed for the new WordPress era.', 'page-builder-framework' ); ?></p>
				</div>

				<div class="heatbox-logo-wide">
					<img src="<?php echo esc_url( WPBF_THEME_URI . '/img/page-builder-framework-logo.png' ); ?>" alt="">
				</div>

			</div>

			<nav aria-label="<?php esc_attr_e( 'Theme Settings', 'page-builder-framework' ); ?>">
				<ul class="heatbox-tab-nav">
					<?php foreach ( $wpbf_tabs as $wpbf_tab => $wpbf_tab_title ) : ?>
						<li class="heatbox-tab-nav-item" data-panel="<?php echo esc_attr( $wpbf_tab ); ?>">
							<a href="#<?php echo esc_attr( $wpbf_tab ); ?>"><?php echo esc_html( $wpbf_tab_title ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>

		</div>

	</div>

	<div class="heatbox-container heatbox-container-center heatbox-column-container">

		<div class="heatbox-main">

			<!-- WordPress places admin notices after this marker -->
			<hr class="wp-header-end">

			<div class="heatbox-admin-panel" data-panel="settings">
				<?php
				require __DIR__ . '/metaboxes/customizer.php';
				require __DIR__ . '/metaboxes/clear-font-cache.php';
				?>
			</div>

			<div class="heatbox-admin-panel" data-panel="premium">
				<?php require __DIR__ . '/metaboxes/premium.php'; ?>
			</div>

			<div class="heatbox-admin-panel" data-panel="recommended">
				<?php require __DIR__ . '/metaboxes/recommended.php'; ?>
			</div>

		</div>

		<div class="heatbox-sidebar">
			<?php
			require __DIR__ . '/metaboxes/review.php';
			require __DIR__ . '/metaboxes/resources.php';
			?>
		</div>

	</div>

</div>
