<?php
/**
 * Metabox template for displaying premium features.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );
?>

<a href="https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf" target="_blank" class="wpbf-premium-add-on-banner-link">
	<img class="wpbf-premium-add-on-banner" src="<?php echo esc_url( WPBF_THEME_URI ); ?>/img/premium-add-on-banner.jpg" alt="Page Builder Framework Premium Add-On">
</a>

<div class="heatbox wpbf-premium-metabox">

	<h2>
		<?php _e( 'Premium Add-On Features', 'page-builder-framework' ); ?>
		<a href="https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf" target="_blank" style="float: right;"><?php _e( 'Upgrade Now', 'page-builder-framework' ); ?></a>
	</h2>

	<ul class="wpbf-premium-list">

		<?php

			$premium_features = array(
				array(
					'title'       => __( 'Transparent Header', 'page-builder-framework' ),
					'description' => __( 'Create a customizable Transparent Header with just a few clicks.', 'page-builder-framework' ),
					'link'        => 'https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf',
				),
				array(
					'title'       => __( 'Sticky Navigation', 'page-builder-framework' ),
					'description' => __( 'Create a beautiful & fully customizable Sticky Navigation in seconds.', 'page-builder-framework' ),
					'link'        => 'https://wp-pagebuilderframework.com/premium/?video=stickynav&utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf#premium',
				),
				array(
					'title'       => __( 'White Label Settings', 'page-builder-framework' ),
					'description' => __( 'Your theme, your branding. Fully white label Page Builder Framework & the Premium Add-On.', 'page-builder-framework' ),
					'link'        => 'https://wp-pagebuilderframework.com/docs/white-label/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf',
				),
				array(
					'title'       => __( 'Advanced Typography', 'page-builder-framework' ),
					'description' => __( 'Customize fonts and add Typekit- & Custom Fonts to your website.', 'page-builder-framework' ),
					'link'        => 'https://wp-pagebuilderframework.com/docs/advanced-typography/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf',
				),
				array(
					'title'       => __( 'Adjustable Breakpoints', 'page-builder-framework' ),
					'description' => __( 'Set custom responsive breakpoints for tablets, desktops & mobiles for a pixel perfect design.', 'page-builder-framework' ),
					'link'        => 'https://wp-pagebuilderframework.com/docs/custom-responsive-breakpoints/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf',
				),
				array(
					'title'       => __( 'Advanced WooCommerce Features', 'page-builder-framework' ),
					'description' => __( 'Take full control over the design of your online store with more advanced WooCommerce features.', 'page-builder-framework' ),
					'link'        => 'https://wp-pagebuilderframework.com/free-woocommerce-theme/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf#premium',
				),
				array(
					'title'       => __( 'Mega Menu', 'page-builder-framework' ),
					'description' => __( 'Easily create an advanced mega menu with up to 4 rows.', 'page-builder-framework' ),
					'link'        => 'https://wp-pagebuilderframework.com/docs/mega-menu/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf',
				),
				array(
					'title'       => __( 'Call to Action Button', 'page-builder-framework' ),
					'description' => __( 'Add a customizable Call to Action Button to your navigation with just a few clicks.', 'page-builder-framework' ),
					'link'        => 'https://wp-pagebuilderframework.com/docs/call-to-action-button/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf',
				),
			);

			foreach ( $premium_features as $premium_feature ) {

				?>

				<li>
					<div class="wpbf-premium-list-content">
						<h3>
							<?php echo esc_html( $premium_feature['title'] ); ?>
						</h3>
						<div class="tooltip">
							<i class="dashicons dashicons-editor-help"></i>
							<p><?php echo esc_html( $premium_feature['description'] ); ?></p>
						</div>
					</div>
					<div class="wpbf-premium-list-icon">
						<i class="dashicons dashicons-yes-alt"></i>
					</div>
				</li>

				<?php

			}

		?>

		<li>
			<div class="wpbf-premium-list-content">
				<h3>
					<strong><?php _e( 'And much more!', 'page-builder-framework' ); ?></strong>
				</h3>
				<p>
					<?php _e( 'Check out all the Premium Add-On features.', 'page-builder-framework' ); ?>
				</p>
			</div>
			<div class="wpbf-premium-list-icon">
				<a href="https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf" target="_blank" class="button button-larger button-primary"><?php _e( 'Learn More', 'page-builder-framework' ); ?></a>
			</div>
		</li>

	</ul>

</div>
