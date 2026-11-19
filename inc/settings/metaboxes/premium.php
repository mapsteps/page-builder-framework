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
		'title'       => __( 'White Label Settings', 'page-builder-framework' ),
		'description' => __( 'Your theme, your branding. Fully white label Page Builder Framework & the Premium Add-On.', 'page-builder-framework' ),
	),
	array(
		'title'       => __( 'Advanced Typography', 'page-builder-framework' ),
		'description' => __( 'Customize fonts and add Typekit- & Custom Fonts to your website.', 'page-builder-framework' ),
	),
	array(
		'title'       => __( 'Adjustable Breakpoints', 'page-builder-framework' ),
		'description' => __( 'Set custom responsive breakpoints for tablets, desktops & mobiles for a pixel perfect design.', 'page-builder-framework' ),
	),
	array(
		'title'       => __( 'Advanced WooCommerce Features', 'page-builder-framework' ),
		'description' => __( 'Take full control over the design of your online store with more advanced WooCommerce features.', 'page-builder-framework' ),
	),
	array(
		'title'       => __( 'Mega Menu', 'page-builder-framework' ),
		'description' => __( 'Easily create an advanced mega menu with up to 4 rows.', 'page-builder-framework' ),
	),
	array(
		'title'       => __( 'Call to Action Button', 'page-builder-framework' ),
		'description' => __( 'Add a customizable Call to Action Button to your navigation with just a few clicks.', 'page-builder-framework' ),
	),
);

?>

<div class="heatbox wpbf-premium-metabox">

	<a href="<?php echo esc_url( $wpbf_premium_url ); ?>" target="_blank" aria-hidden="true" tabindex="-1">
		<img src="<?php echo esc_url( WPBF_THEME_URI . '/img/premium-add-on-banner.jpg' ); ?>" alt="">
	</a>

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
			<strong><?php esc_html_e( 'And much more!', 'page-builder-framework' ); ?></strong>
			<?php esc_html_e( 'Check out all the Premium Add-On features.', 'page-builder-framework' ); ?>
		</p>
		<a href="<?php echo esc_url( $wpbf_premium_url ); ?>" target="_blank" class="button button-primary">
			<?php esc_html_e( 'Upgrade Now', 'page-builder-framework' ); ?>
			<span class="screen-reader-text"><?php esc_html_e( '(opens in a new tab)', 'page-builder-framework' ); ?></span>
		</a>
	</div>
</div>
