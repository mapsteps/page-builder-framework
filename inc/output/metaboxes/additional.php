<?php
/**
 * Metabox template for displaying additional links.
 *
 * @package Page_Builder_Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );
?>

<div class="neatbox is-smooth has-medium-gap has-bigger-heading additional-box">
	<h2>
		<?php _e( 'Additional Resources', 'page-builder-framework' ); ?>
	</h2>
	<ul class="neatbox-list additional-list">
		<li class="list-item">
			<a href="https://wp-pagebuilderframework.com/" target="_blank">
				<span class="dashicons dashicons-admin-site-alt"></span>
				<?php _e( 'Page Builder Framework Website', 'page-builder-framework' ); ?>
			</a>
		</li>
		<li class="list-item">
			<a href="https://wordpress.org/support/theme/page-builder-framework/" target="_blank">
				<span class="dashicons dashicons-sos"></span> <?php _e( 'Support Forum', 'page-builder-framework' ); ?>
			</a>
		</li>
		<li class="list-item">
			<a href="https://wordpress.org/support/theme/page-builder-framework/reviews/#new-post" target="_blank">
				<span class="dashicons dashicons-star-filled"></span>
				<?php _e( 'Leave a Review', 'page-builder-framework' ); ?>
			</a>
		</li>
	</ul>
</div><!-- .additional-box -->
