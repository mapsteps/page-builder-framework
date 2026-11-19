<?php
/**
 * Metabox template for displaying additional resources.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Icons: Lucide (globe, book-open, git-branch, life-buoy), https://lucide.dev, ISC License; the SVG's inner markup.
$wpbf_resources = array(
	array(
		'icon'  => '<circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/>',
		'title' => __( 'Page Builder Framework Website', 'page-builder-framework' ),
		'link'  => 'https://wp-pagebuilderframework.com/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf',
	),
	array(
		'icon'  => '<path d="M12 5v16"/><path d="M20.001 19A2 2 0 0022 17V5a2 2 0 00-1.999-2L16 3.002A5 5 0 0012 5a5 5 0 00-4-2H4a2 2 0 00-2 2v12a2 2 0 001.999 2H8a5 5 0 014 2 5 5 0 014-2z"/>',
		'title' => __( 'Documentation', 'page-builder-framework' ),
		'link'  => 'https://wp-pagebuilderframework.com/docs/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf',
	),
	array(
		'icon'  => '<path d="M15 6a9 9 0 0 0-9 9V3"/><circle cx="18" cy="6" r="3"/><circle cx="6" cy="18" r="3"/>',
		'title' => __( 'Child Theme', 'page-builder-framework' ),
		'link'  => 'https://wp-pagebuilderframework.com/child-theme-generator/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf',
	),
	array(
		'icon'  => '<circle cx="12" cy="12" r="10"/><path d="m4.93 4.93 4.24 4.24"/><path d="m14.83 9.17 4.24-4.24"/><path d="m14.83 14.83 4.24 4.24"/><path d="m9.17 14.83-4.24 4.24"/><circle cx="12" cy="12" r="4"/>',
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
						<svg class="wpbf-resource-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><?php echo $wpbf_resource['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Fixed SVG markup from this file. ?></svg>
						<?php echo esc_html( $wpbf_resource['title'] ); ?>
						<span class="screen-reader-text"><?php esc_html_e( '(opens in a new tab)', 'page-builder-framework' ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
