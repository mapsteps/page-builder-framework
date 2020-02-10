<?php
/**
 * Metabox template for displaying documentation link.
 *
 * @package Page_Builder_Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );
?>

<div class="neatbox is-smooth has-medium-gap has-bigger-heading documentation-box">
	<h2>
		<?php _e( 'Documentation', 'page-builder-framework' ); ?>
	</h2>
	<div class="neatbox-content">
		<p class="description">
			<?php _e( 'Not sure how something works? Our extensive Documentation is a great place to learn more about Page Builder Framework.', 'page-builder-framework' ); ?>
		</p>
		<a href="https://wp-pagebuilderframework.com/docs/" target="_blank" class="button button-primary">
			<?php _e( 'Documentation', 'page-builder-framework' ); ?>
		</a>
	</div>
</div><!-- .documentation-box -->
