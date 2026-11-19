<?php
/**
 * Metabox template for displaying premium features.
 *
 * Icons: Lucide (https://lucide.dev, ISC License), the SVG's inner markup.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$wpbf_premium_url = 'https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf';

$wpbf_premium_features = array(
	array(
		'title'       => __( 'Transparent Header', 'page-builder-framework' ),
		'description' => __( 'Create a customizable Transparent Header with just a few clicks.', 'page-builder-framework' ),
		'icon'        => '<path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z"/><path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"/><path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"/>',
	),
	array(
		'title'       => __( 'Sticky Navigation', 'page-builder-framework' ),
		'description' => __( 'Create a beautiful & fully customizable Sticky Navigation in seconds.', 'page-builder-framework' ),
		'icon'        => '<path d="M12 17v5"/><path d="M9 10.76a2 2 0 0 1-1.11 1.79l-1.78.9A2 2 0 0 0 5 15.24V16a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-.76a2 2 0 0 0-1.11-1.79l-1.78-.9A2 2 0 0 1 15 10.76V7a1 1 0 0 1 1-1 2 2 0 0 0 0-4H8a2 2 0 0 0 0 4 1 1 0 0 1 1 1z"/>',
	),
	array(
		'title'       => __( 'Mega Menu', 'page-builder-framework' ),
		'description' => __( 'Easily create an advanced mega menu with up to 4 rows.', 'page-builder-framework' ),
		'icon'        => '<rect width="18" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/>',
	),
	array(
		'title'       => __( 'Off-Canvas & Full-Screen Menus', 'page-builder-framework' ),
		'description' => __( 'Menus that slide in from the side or cover the whole screen, on desktop and mobile.', 'page-builder-framework' ),
		'icon'        => '<rect width="18" height="18" x="3" y="3" rx="2"/><path d="M9 3v18"/><path d="m14 9 3 3-3 3"/>',
	),
	array(
		'title'       => __( 'Custom Sections', 'page-builder-framework' ),
		'description' => __( 'Add your own content to any part of your website, like above the header or before the footer.', 'page-builder-framework' ),
		'icon'        => '<rect width="18" height="18" x="3" y="3" rx="2"/><path d="M8 12h8"/><path d="M12 8v8"/>',
	),
	array(
		'title'       => __( 'Blog Layouts', 'page-builder-framework' ),
		'description' => __( 'Show your posts in a grid or masonry layout, set up for each archive.', 'page-builder-framework' ),
		'icon'        => '<rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/>',
	),
	array(
		'title'       => __( 'White Label Settings', 'page-builder-framework' ),
		'description' => __( 'Your theme, your branding. Fully white label Page Builder Framework & the Premium Add-On.', 'page-builder-framework' ),
		'icon'        => '<path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"/><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"/>',
	),
	array(
		'title'       => __( 'Advanced Typography', 'page-builder-framework' ),
		'description' => __( 'Customize fonts and add Adobe Fonts & custom fonts to your website.', 'page-builder-framework' ),
		'icon'        => '<path d="M12 4v16"/><path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"/><path d="M9 20h6"/>',
	),
	array(
		'title'       => __( 'Adjustable Breakpoints', 'page-builder-framework' ),
		'description' => __( 'Set custom responsive breakpoints for tablets, desktops & mobiles for a pixel perfect design.', 'page-builder-framework' ),
		'icon'        => '<path d="M18 8V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h8"/><path d="M10 19v-3.96 3.15"/><path d="M7 19h5"/><rect width="6" height="10" x="16" y="12" rx="2"/>',
	),
	array(
		'title'       => __( 'WooCommerce', 'page-builder-framework' ),
		'description' => __( 'Quick view, a cart in the menu and an off-canvas sidebar for your online store.', 'page-builder-framework' ),
		'icon'        => '<path d="M15 21v-5a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v5"/><path d="M17.774 10.31a1.12 1.12 0 0 0-1.549 0 2.5 2.5 0 0 1-3.451 0 1.12 1.12 0 0 0-1.548 0 2.5 2.5 0 0 1-3.452 0 1.12 1.12 0 0 0-1.549 0 2.5 2.5 0 0 1-3.77-3.248l2.889-4.184A2 2 0 0 1 7 2h10a2 2 0 0 1 1.653.873l2.895 4.192a2.5 2.5 0 0 1-3.774 3.244"/><path d="M4 10.95V19a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8.05"/>',
	),
);

?>

<div class="heatbox wpbf-premium-metabox">

	<div class="wpbf-premium-hero">
		<div class="wpbf-premium-hero-content">
			<p class="wpbf-premium-hero-title"><?php esc_html_e( 'Premium Add-On', 'page-builder-framework' ); ?></p>
			<p><?php esc_html_e( 'Take your website to the next level with the Premium Add-On for Page Builder Framework.', 'page-builder-framework' ); ?></p>
			<a href="<?php echo esc_url( $wpbf_premium_url ); ?>" target="_blank" class="button button-larger wpbf-premium-hero-button">
				<?php esc_html_e( 'Get Premium', 'page-builder-framework' ); ?>
				<span class="screen-reader-text"><?php esc_html_e( '(opens in a new tab)', 'page-builder-framework' ); ?></span>
			</a>
		</div>
	</div>

	<h2>
		<?php esc_html_e( 'Premium Add-On Features', 'page-builder-framework' ); ?>
		<span class="heatbox-badge">PRO</span>
	</h2>

	<div class="heatbox-content">
		<ul class="heatbox-features">
			<?php foreach ( $wpbf_premium_features as $wpbf_premium_feature ) : ?>
				<li>
					<span class="wpbf-feature-icon"><?php wpbf_theme_settings_icon( $wpbf_premium_feature['icon'], '' ); ?></span>
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
