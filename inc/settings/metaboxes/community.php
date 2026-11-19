<?php
/**
 * Metabox template for displaying community link.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );
?>

<div class="heatbox wpbf-community-metabox">
	<h2><?php esc_html_e( 'Join the Community', 'page-builder-framework' ); ?></h2>
	<div class="heatbox-content">
		<p class="description">
			<?php esc_html_e( 'Join the community and meet 1700+ Page Builder Framework users in our Facebook group.', 'page-builder-framework' ); ?>
		</p>
		<a href="https://www.facebook.com/groups/wpagebuilderframework/" target="_blank" class="button">
			<?php esc_html_e( 'Join the Community', 'page-builder-framework' ); ?>
			<span class="screen-reader-text"><?php esc_html_e( '(opens in a new tab)', 'page-builder-framework' ); ?></span>
		</a>
	</div>
</div>
