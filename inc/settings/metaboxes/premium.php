<?php
/**
 * Metabox template for displaying premium features.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$wpbf_premium_url = 'https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf';

$wpbf_premium_features = array(
	array(
		'title'       => __( 'Transparent Header', 'page-builder-framework' ),
		'description' => __( 'Create a customizable Transparent Header with just a few clicks.', 'page-builder-framework' ),
	),
	array(
		'title'       => __( 'Sticky Navigation', 'page-builder-framework' ),
		'description' => __( 'Create a beautiful & fully customizable Sticky Navigation in seconds.', 'page-builder-framework' ),
	),
	array(
		'title'       => __( 'Mega Menu', 'page-builder-framework' ),
		'description' => __( 'Easily create an advanced mega menu with up to 4 rows.', 'page-builder-framework' ),
	),
	array(
		'title'       => __( 'Off-Canvas & Full-Screen Menus', 'page-builder-framework' ),
		'description' => __( 'Menus that slide in from the side or cover the whole screen, on desktop and mobile.', 'page-builder-framework' ),
	),
	array(
		'title'       => __( 'Custom Sections', 'page-builder-framework' ),
		'description' => __( 'Add your own content to any part of your website, like above the header or before the footer.', 'page-builder-framework' ),
	),
	array(
		'title'       => __( 'Blog Layouts', 'page-builder-framework' ),
		'description' => __( 'Show your posts in a grid or masonry layout, set up for each archive.', 'page-builder-framework' ),
	),
	array(
		'title'       => __( 'White Label Settings', 'page-builder-framework' ),
		'description' => __( 'Your theme, your branding. Fully white label Page Builder Framework & the Premium Add-On.', 'page-builder-framework' ),
	),
	array(
		'title'       => __( 'Advanced Typography', 'page-builder-framework' ),
		'description' => __( 'Customize fonts and add Adobe Fonts & custom fonts to your website.', 'page-builder-framework' ),
	),
	array(
		'title'       => __( 'Adjustable Breakpoints', 'page-builder-framework' ),
		'description' => __( 'Set custom responsive breakpoints for tablets, desktops & mobiles for a pixel perfect design.', 'page-builder-framework' ),
	),
	array(
		'title'       => __( 'WooCommerce', 'page-builder-framework' ),
		'description' => __( 'Quick view, a cart in the menu and an off-canvas sidebar for your online store.', 'page-builder-framework' ),
	),
);

?>

<div class="heatbox wpbf-premium-metabox">

	<h2>
		<?php esc_html_e( 'Premium Add-On Features', 'page-builder-framework' ); ?>
		<span class="heatbox-badge">PRO</span>
	</h2>

	<div class="heatbox-content">
		<ul class="heatbox-features">
			<?php foreach ( $wpbf_premium_features as $wpbf_premium_feature ) : ?>
				<li>
					<span class="dashicons dashicons-yes"></span>
					<div>
						<h3><?php echo esc_html( $wpbf_premium_feature['title'] ); ?></h3>
						<p class="description"><?php echo esc_html( $wpbf_premium_feature['description'] ); ?></p>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>

</div>

<div class="heatbox-cta-container is-attached">
	<div class="heatbox-cta primary">
		<p>
			<?php if ( wpbf_is_bfcm_sale() ) : ?>
				<strong><?php esc_html_e( 'Black Friday: up to 25% off!', 'page-builder-framework' ); ?></strong>
				<?php esc_html_e( 'All prices are reduced. No coupon code required.', 'page-builder-framework' ); ?>
			<?php else : ?>
				<strong><?php esc_html_e( 'And much more!', 'page-builder-framework' ); ?></strong>
				<?php esc_html_e( 'Check out all the Premium Add-On features.', 'page-builder-framework' ); ?>
			<?php endif; ?>
		</p>
		<a href="<?php echo esc_url( $wpbf_premium_url ); ?>" target="_blank" class="button button-primary">
			<?php esc_html_e( 'Get Premium', 'page-builder-framework' ); ?>
			<span class="screen-reader-text"><?php esc_html_e( '(opens in a new tab)', 'page-builder-framework' ); ?></span>
		</a>
	</div>
</div>
