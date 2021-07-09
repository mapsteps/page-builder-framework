<?php
/**
 * Theme setting's template.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

?>

<div class="wrap heatbox-wrap wpbf-theme-settings-page">

	<div class="heatbox-header heatbox-has-tab-nav heatbox-margin-bottom">

		<div class="heatbox-container heatbox-container-center">

			<div class="logo-container">

				<div>
					<span class="title">
						<?php echo esc_html( get_admin_page_title() ); ?>
						<span class="version"><?php echo esc_html( WPBF_VERSION ); ?></span>
					</span>
				</div>

				<div class="heatbox-logo-wide">
					<img src="<?php echo esc_url( WPBF_THEME_URI ); ?>/img/page-builder-framework-logo.png">
				</div>

			</div>

			<nav>
				<ul class="heatbox-tab-nav">
					<li class="heatbox-tab-nav-item settings-panel"><a href="#settings"><?php _e( 'Getting Started', 'page-builder-framework' ); ?></a></li>
					<li class="heatbox-tab-nav-item premium-panel"><a href="#premium"><?php _e( 'Premium Add-On', 'page-builder-framework' ); ?></a></li>
					<li class="heatbox-tab-nav-item recommended-panel"><a href="#recommended"><?php _e( 'Recommended Plugins', 'page-builder-framework' ); ?></a></li>
					<li class="heatbox-tab-nav-item documentation-panel"><a href="#documentation"><?php _e( 'Help', 'page-builder-framework' ); ?></a></li>
				</ul>
			</nav>

		</div>

	</div>

	<div class="heatbox-container heatbox-container-center heatbox-column-container">

		<div class="heatbox-main">

			<div class="heatbox-admin-panel wpbf-settings-panel">
				<!-- Faking H1 tag to place admin notices -->
				<h1 style="display: none;"></h1>
				<?php require __DIR__ . '/metaboxes/customizer.php'; ?>
			</div>

			<div class="heatbox-admin-panel wpbf-premium-panel">
				<?php require __DIR__ . '/metaboxes/premium.php'; ?>
			</div>

			<div class="heatbox-admin-panel wpbf-recommended-panel">
				<?php require __DIR__ . '/metaboxes/recommended.php'; ?>
			</div>

			<div class="heatbox-admin-panel wpbf-documentation-panel">
				<?php require __DIR__ . '/metaboxes/documentation.php'; ?>
			</div>

		</div>

		<div class="heatbox-sidebar">

			<?php
			require __DIR__ . '/metaboxes/community.php';
			require __DIR__ . '/metaboxes/review.php';
			require __DIR__ . '/metaboxes/resources.php';
			?>

		</div>

	</div>

</div>
