<?php
/**
 * Metabox template for displaying review link.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );
?>

<div class="heatbox wpbf-review-metabox">
	<h2><?php esc_html_e( 'Leave us a Review', 'page-builder-framework' ); ?></h2>
	<div class="heatbox-content">
		<p class="description">
			<?php esc_html_e( 'Do you enjoy Page Builder Framework? Leave a review in the WordPress directory and spread the word!', 'page-builder-framework' ); ?>
		</p>
		<a href="https://wordpress.org/support/theme/page-builder-framework/reviews/#new-post" target="_blank" class="button">
			<?php esc_html_e( 'Leave a Review', 'page-builder-framework' ); ?>
			<span class="screen-reader-text"><?php esc_html_e( '(opens in a new tab)', 'page-builder-framework' ); ?></span>
		</a>
	</div>
</div>
