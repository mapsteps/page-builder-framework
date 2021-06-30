<?php
/**
 * Quick edit.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Add layout options to quick edit box.
 *
 * @see https://developer.wordpress.org/reference/hooks/quick_edit_custom_box/
 *
 * @param string $column_name Name of the column to edit.
 * @param string $post_type The post type slug, or current screen name if this is a taxonomy list table.
 * @param string $taxonomy The taxonomy name, if any.
 */
function wpbf_quick_edit_layout( $column_name, $post_type, $taxonomy ) {

	if ( 'wpbf_layout' !== $column_name ) {
		return;
	}

	?>

	<div class="wpbf-quick-edit">
		<div class="wpbf-quick-edit-row has-4">

			<div class="wpbf-quick-edit-col">
				<h4>
					<?php _e( 'Layout', 'page-builder-framework' ); ?>
				</h4>

				<div class="wpbf-quick-edit-fields-area" data-wpbf-fields-group-name="layout" data-wpbf-fields-group-type="radio">

					<div class="wpbf-quick-edit-field wpbf-quick-edit-radio-field">
						<div class="wpbf-quick-edit-control">
							<input type="radio" name="wpbf_options[]" value="layout-global" class="wpbf-quick-edit-use-preset" data-wpbf-preset-name="layout" />
						</div>
						<label for="" class="wpbf-quick-edit-label">
							<?php _e( 'Inherit Global Settings', 'page-builder-framework' ); ?>
						</label>
					</div>

					<div class="wpbf-quick-edit-field wpbf-quick-edit-radio-field">
						<div class="wpbf-quick-edit-control">
							<input type="radio" name="wpbf_options[]" value="full-width" class="wpbf-quick-edit-use-preset" data-wpbf-preset-name="layout" />
						</div>
						<label for="" class="wpbf-quick-edit-label">
							<?php _e( 'Full Width', 'page-builder-framework' ); ?>
						</label>
					</div>

					<div class="wpbf-quick-edit-field wpbf-quick-edit-radio-field">
						<div class="wpbf-quick-edit-control">
							<input type="radio" name="wpbf_options[]" value="contained" class="wpbf-quick-edit-use-preset" data-wpbf-preset-name="layout" />
						</div>
						<label for="" class="wpbf-quick-edit-label">
							<?php _e( 'Contained', 'page-builder-framework' ); ?>
						</label>
					</div>

				</div>

				<?php do_action( 'wpbf_post_list_quick_edit_column_1', $column_name, $post_type, $taxonomy ); ?>

			</div>

			<div class="wpbf-quick-edit-col">
				<h4>
					<?php _e( 'Disable Elements', 'page-builder-framework' ); ?>
				</h4>

				<div class="wpbf-quick-edit-fields-area" data-wpbf-fields-group-name="checked-removals" data-wpbf-fields-group-type="checkbox">

					<div class="wpbf-quick-edit-field wpbf-quick-edit-checkbox-field">
						<div class="wpbf-quick-edit-control">
							<input type="checkbox" name="wpbf_options[]" value="remove-title" class="wpbf-quick-edit-use-preset" data-wpbf-preset-name="checked-removals" />
						</div>
						<label for="" class="wpbf-quick-edit-label">
							<?php _e( 'Page Title', 'page-builder-framework' ); ?>
						</label>
					</div>

					<div class="wpbf-quick-edit-field wpbf-quick-edit-checkbox-field">
						<div class="wpbf-quick-edit-control">
							<input type="checkbox" name="wpbf_options[]" value="remove-featured" class="wpbf-quick-edit-use-preset" data-wpbf-preset-name="checked-removals" />
						</div>
						<label for="" class="wpbf-quick-edit-label">
							<?php _e( 'Featured Image', 'page-builder-framework' ); ?>
						</label>
					</div>

					<div class="wpbf-quick-edit-field wpbf-quick-edit-checkbox-field">
						<div class="wpbf-quick-edit-control">
							<input type="checkbox" name="wpbf_options[]" value="remove-header" class="wpbf-quick-edit-use-preset" data-wpbf-preset-name="checked-removals" />
						</div>
						<label for="" class="wpbf-quick-edit-label">
							<?php _e( 'Header', 'page-builder-framework' ); ?>
						</label>
					</div>

					<div class="wpbf-quick-edit-field wpbf-quick-edit-checkbox-field">
						<div class="wpbf-quick-edit-control">
							<input type="checkbox" name="wpbf_options[]" value="remove-footer" class="wpbf-quick-edit-use-preset" data-wpbf-preset-name="checked-removals" />
						</div>
						<label for="" class="wpbf-quick-edit-label">
							<?php _e( 'Footer', 'page-builder-framework' ); ?>
						</label>
					</div>

				</div>

				<?php do_action( 'wpbf_post_list_quick_edit_column_2', $column_name, $post_type, $taxonomy ); ?>

			</div>

			<div class="wpbf-quick-edit-col">
				<h4>
					<?php _e( 'Sidebar', 'page-builder-framework' ); ?>
				</h4>

				<div class="wpbf-quick-edit-fields-area" data-wpbf-fields-group-name="sidebar-position" data-wpbf-fields-group-type="radio">

					<div class="wpbf-quick-edit-field wpbf-quick-edit-radio-field">
						<div class="wpbf-quick-edit-control">
							<input type="radio" name="wpbf_sidebar_position" value="global" class="wpbf-quick-edit-use-preset" data-wpbf-preset-name="sidebar-position" />
						</div>
						<label for="" class="wpbf-quick-edit-label">
							<?php _e( 'Inherit Global Settings', 'page-builder-framework' ); ?>
						</label>
					</div>

					<div class="wpbf-quick-edit-field wpbf-quick-edit-radio-field">
						<div class="wpbf-quick-edit-control">
							<input type="radio" name="wpbf_sidebar_position" value="right" class="wpbf-quick-edit-use-preset" data-wpbf-preset-name="sidebar-position" />
						</div>
						<label for="" class="wpbf-quick-edit-label">
							<?php _e( 'Right Sidebar', 'page-builder-framework' ); ?>
						</label>
					</div>

					<div class="wpbf-quick-edit-field wpbf-quick-edit-radio-field">
						<div class="wpbf-quick-edit-control">
							<input type="radio" name="wpbf_sidebar_position" value="left" class="wpbf-quick-edit-use-preset" data-wpbf-preset-name="sidebar-position" />
						</div>
						<label for="" class="wpbf-quick-edit-label">
							<?php _e( 'Left Sidebar', 'page-builder-framework' ); ?>
						</label>
					</div>

					<div class="wpbf-quick-edit-field wpbf-quick-edit-radio-field">
						<div class="wpbf-quick-edit-control">
							<input type="radio" name="wpbf_sidebar_position" value="none" class="wpbf-quick-edit-use-preset" data-wpbf-preset-name="sidebar-position" />
						</div>
						<label for="" class="wpbf-quick-edit-label">
							<?php _e( 'No Sidebar', 'page-builder-framework' ); ?>
						</label>
					</div>

				</div>

				<?php do_action( 'wpbf_post_list_quick_edit_column_3', $column_name, $post_type, $taxonomy ); ?>

			</div>

			<div class="wpbf-quick-edit-col">
				<?php do_action( 'wpbf_post_list_quick_edit_column_4', $column_name, $post_type, $taxonomy ); ?>
			</div>

		</div>

		<input type="hidden" name="wpbf_options_nonce" class="wpbf-quick-edit-nonce-field">
		<input type="hidden" name="wpbf_sidebar_nonce" class="wpbf-quick-edit-nonce-field">

		<?php do_action( 'wpbf_post_list_quick_edit_nonce_field' ); ?>

	</div>

	<?php

}
add_action( 'quick_edit_custom_box', 'wpbf_quick_edit_layout', 10, 3 );
