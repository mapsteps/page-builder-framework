<?php
/**
 * Metabox template for displaying additional resources.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$wpbf_resources = array(
	array(
		'icon'  => 'dashicons-admin-site-alt',
		'title' => __( 'Page Builder Framework Website', 'page-builder-framework' ),
		'link'  => 'https://wp-pagebuilderframework.com/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf',
	),
	array(
		'icon'  => 'dashicons-download',
		'title' => __( 'Child Theme', 'page-builder-framework' ),
		'link'  => 'https://wp-pagebuilderframework.com/child-theme-generator/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf',
	),
	array(
		'icon'  => 'dashicons-sos',
		'title' => __( 'Support Forum', 'page-builder-framework' ),
		'link'  => 'https://wordpress.org/support/theme/page-builder-framework/',
	),
);
?>

<div class="heatbox wpbf-resources-metabox">
	<h2><?php esc_html_e( 'Additional Resources', 'page-builder-framework' ); ?></h2>
	<div class="heatbox-content">
		<ul class="wpbf-resources-list">
			<?php foreach ( $wpbf_resources as $wpbf_resource ) : ?>
				<li>
					<a href="<?php echo esc_url( $wpbf_resource['link'] ); ?>" target="_blank">
						<span class="dashicons <?php echo esc_attr( $wpbf_resource['icon'] ); ?>" aria-hidden="true"></span>
						<?php echo esc_html( $wpbf_resource['title'] ); ?>
						<span class="screen-reader-text"><?php esc_html_e( '(opens in a new tab)', 'page-builder-framework' ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
