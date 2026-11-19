<?php
/**
 * Metabox template for displaying the first steps after installing the theme.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );
?>

<div class="heatbox wpbf-first-steps-metabox">
	<h2><?php esc_html_e( 'First Steps', 'page-builder-framework' ); ?></h2>
	<div class="heatbox-content">
		<ol class="heatbox-steps">
			<li>
				<h3><?php esc_html_e( 'Set up your site', 'page-builder-framework' ); ?></h3>
				<p class="description"><?php esc_html_e( 'Add your logo and pick your colors and fonts in the Customizer.', 'page-builder-framework' ); ?></p>
				<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button"><?php esc_html_e( 'Open the Customizer', 'page-builder-framework' ); ?></a>
			</li>
			<li>
				<h3><?php esc_html_e( 'Using a page builder?', 'page-builder-framework' ); ?></h3>
				<p class="description"><?php esc_html_e( 'Choose "Full Width" under "Template Settings" when editing a page, so your design can use the whole screen.', 'page-builder-framework' ); ?></p>
				<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=page' ) ); ?>" class="button"><?php esc_html_e( 'Go to your pages', 'page-builder-framework' ); ?></a>
			</li>
			<li>
				<h3><?php esc_html_e( 'Making code changes?', 'page-builder-framework' ); ?></h3>
				<p class="description"><?php esc_html_e( 'Install the child theme first, so theme updates don\'t overwrite your changes.', 'page-builder-framework' ); ?></p>
				<a href="https://wp-pagebuilderframework.com/child-theme-generator/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf" target="_blank" class="button">
					<?php esc_html_e( 'Get the child theme', 'page-builder-framework' ); ?>
					<span class="screen-reader-text"><?php esc_html_e( '(opens in a new tab)', 'page-builder-framework' ); ?></span>
				</a>
			</li>
		</ol>
	</div>
</div>
