<?php
/**
 * Options.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Load metaboxes.
 */
function wpbf_metabox_setup() {

	add_action( 'add_meta_boxes', 'wpbf_metaboxes' );

}
add_action( 'load-post.php', 'wpbf_metabox_setup' );
add_action( 'load-post-new.php', 'wpbf_metabox_setup' );

/**
 * Metaboxes.
 */
function wpbf_metaboxes() {

	// Get public post types.
	$post_types = get_post_types( array( 'public' => true ) );

	// Remove post types from array.
	unset( $post_types['wpbf_hooks'], $post_types['elementor_library'], $post_types['fl-builder-template'] );

	// Add options metabox.
	add_meta_box( 'wpbf', __( 'Template Settings', 'page-builder-framework' ), 'wpbf_options_metabox_callback', $post_types, 'side', 'default' );

	// Add sidebar metabox.
	add_meta_box( 'wpbf_sidebar', __( 'Sidebar', 'page-builder-framework' ), 'wpbf_sidebar_metabox_callback', $post_types, 'side', 'default' );

}

/**
 * Options metabox callback.
 *
 * @param object $post The post oject.
 */
function wpbf_options_metabox_callback( $post ) {

	wp_nonce_field( "wpbf_post_{$post->ID}_options_nonce", 'wpbf_options_nonce' );

	$wpbf_stored_meta = get_post_meta( $post->ID, 'wpbf_options', true );
	$wpbf_stored_meta = is_array( $wpbf_stored_meta ) ? $wpbf_stored_meta : array();

	if ( in_array( 'remove-title', $wpbf_stored_meta, true ) ) {
		$remove_title = 'remove-title';
	} else {
		$remove_title = false;
	}

	if ( in_array( 'full-width', $wpbf_stored_meta, true ) ) {
		$width_type = 'full-width';
	} elseif ( in_array( 'contained', $wpbf_stored_meta, true ) ) {
		$width_type = 'contained';
	} elseif ( in_array( 'custom-width', $wpbf_stored_meta, true ) ) {
		$width_type = 'custom-width';
	} else {
		$width_type = 'layout-global';
	}

	if ( in_array( 'remove-featured', $wpbf_stored_meta, true ) ) {
		$remove_featured = 'remove-featured';
	} else {
		$remove_featured = false;
	}

	if ( in_array( 'remove-header', $wpbf_stored_meta, true ) ) {
		$remove_header = 'remove-header';
	} else {
		$remove_header = false;
	}

	if ( in_array( 'remove-footer', $wpbf_stored_meta, true ) ) {
		$remove_footer = 'remove-footer';
	} else {
		$remove_footer = false;
	}

	$custom_width_value = isset( $wpbf_stored_meta['custom_width_value'] ) ? $wpbf_stored_meta['custom_width_value'] : '';

	?>

	<h4><?php _e( 'Layout', 'page-builder-framework' ); ?></h4>

	<div>
		<input id="layout-global" type="radio" name="wpbf_options[]" value="layout-global" class="wpbf-layout-option" <?php checked( $width_type, 'layout-global' ); ?> />
		<label for="layout-global"><?php _e( 'Inherit Global Settings', 'page-builder-framework' ); ?></label>
		<?php
		if ( ! wpbf_is_premium() ) {
			echo '<a style="text-decoration: none; box-shadow: none;" href="https://wp-pagebuilderframework.com/docs/global-template-settings/" target="_blank"><i style="font-size: 18px; margin-top: -3px; width: 15px; height: 15px;" class="dashicons dashicons-editor-help"></i></a>';
		}
		?>
	</div>

	<div>
		<input id="layout-full-width" type="radio" name="wpbf_options[]" value="full-width" class="wpbf-layout-option" <?php checked( $width_type, 'full-width' ); ?> />
		<label for="layout-full-width"><?php _e( 'Full Width', 'page-builder-framework' ); ?></label>
	</div>

	<div>
		<input id="layout-contained" type="radio" name="wpbf_options[]" value="contained" class="wpbf-layout-option" <?php checked( $width_type, 'contained' ); ?> />
		<label for="layout-contained"><?php _e( 'Contained', 'page-builder-framework' ); ?></label>
	</div>

	<div>
		<input id="layout-custom-width" type="radio" name="wpbf_options[]" value="custom-width" class="wpbf-layout-option" <?php checked( $width_type, 'custom-width' ); ?> />
		<label for="layout-custom-width"><?php _e( 'Custom Width', 'page-builder-framework' ); ?></label>
	</div>

	<div class="wpbf-layout-custom-width-field-wrapper<?php echo esc_attr( 'custom-width' === $width_type ? '' : ' wpbf-is-hidden' ); ?>">
		<input id="layout-custom-width-value" name="wpbf_options[custom_width_value]" value="<?php echo esc_attr( $custom_width_value ); ?>" />
	</div>

	<h4><?php _e( 'Disable Elements', 'page-builder-framework' ); ?></h4>

	<div>
		<input id="remove-title" type="checkbox" name="wpbf_options[]" value="remove-title" <?php checked( $remove_title, 'remove-title' ); ?> />
		<label for="remove-title"><?php _e( 'Page Title', 'page-builder-framework' ); ?></label>
	</div>

	<div>
		<input id="remove-featured" type="checkbox" name="wpbf_options[]" value="remove-featured" <?php checked( $remove_featured, 'remove-featured' ); ?> />
		<label for="remove-featured"><?php _e( 'Featured Image', 'page-builder-framework' ); ?></label>
	</div>

	<div>
		<input id="remove-header" type="checkbox" name="wpbf_options[]" value="remove-header" <?php checked( $remove_header, 'remove-header' ); ?> />
		<label for="remove-header"><?php _e( 'Header', 'page-builder-framework' ); ?></label>
	</div>

	<div>
		<input id="remove-footer" type="checkbox" name="wpbf_options[]" value="remove-footer" <?php checked( $remove_footer, 'remove-footer' ); ?> />
		<label for="remove-footer"><?php _e( 'Footer', 'page-builder-framework' ); ?></label>
	</div>

	<?php

}

/**
 * Sidebar metabox callback.
 *
 * @param object $post The post object.
 */
function wpbf_sidebar_metabox_callback( $post ) {

	wp_nonce_field( "wpbf_post_{$post->ID}_sidebar_nonce", 'wpbf_sidebar_nonce' );

	$wpbf_sidebar_position = get_post_meta( $post->ID, 'wpbf_sidebar_position', true );
	$wpbf_sidebar_position = ! empty( $wpbf_sidebar_position ) ? $wpbf_sidebar_position : 'global';

	?>

	<div>
		<input id="sidebar-global" type="radio" name="wpbf_sidebar_position" value="global" <?php checked( $wpbf_sidebar_position, 'global' ); ?> />
		<label for="sidebar-global"><?php _e( 'Inherit Global Settings', 'page-builder-framework' ); ?></label>
	</div>

	<div>
		<input id="sidebar-right" type="radio" name="wpbf_sidebar_position" value="right" <?php checked( $wpbf_sidebar_position, 'right' ); ?> />
		<label for="sidebar-right"><?php _e( 'Right Sidebar', 'page-builder-framework' ); ?></label>
	</div>

	<div>
		<input id="sidebar-left" type="radio" name="wpbf_sidebar_position" value="left" <?php checked( $wpbf_sidebar_position, 'left' ); ?> />
		<label for="sidebar-left"><?php _e( 'Left Sidebar', 'page-builder-framework' ); ?></label>
	</div>

	<div>
		<input id="no-sidebar" type="radio" name="wpbf_sidebar_position" value="none" <?php checked( $wpbf_sidebar_position, 'none' ); ?> />
		<label for="no-sidebar"><?php _e( 'No Sidebar', 'page-builder-framework' ); ?></label>
	</div>

	<?php

}

/**
 * Save metadata.
 *
 * @param integer $post_id The post ID.
 * @param WP_Post $post The Instance of WP_Post object.
 * @param bool    $update Whether this is an existing post being updated.
 */
function wpbf_save_metadata( $post_id, $post, $update ) {

	$is_autosave            = wp_is_post_autosave( $post_id );
	$is_revision            = wp_is_post_revision( $post_id );
	$is_valid_nonce         = ( isset( $_POST['wpbf_options_nonce'] ) && wp_verify_nonce( $_POST['wpbf_options_nonce'], "wpbf_post_{$post_id}_options_nonce" ) ) ? true : false;
	$is_valid_sidebar_nonce = ( isset( $_POST['wpbf_sidebar_nonce'] ) && wp_verify_nonce( $_POST['wpbf_sidebar_nonce'], "wpbf_post_{$post_id}_sidebar_nonce" ) ) ? true : false;

	// Stop here if autosave, revision or nonce is invalid.
	if ( $is_autosave || $is_revision || ! $is_valid_nonce || ! $is_valid_sidebar_nonce ) {
		return;
	}

	// Stop if current user can't edit posts.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	// Save options metadata.
	$checked = array();

	if ( isset( $_POST['wpbf_options'] ) ) {

		if ( in_array( 'remove-title', $_POST['wpbf_options'], true ) ) {
			$checked[] = 'remove-title';
		}

		if ( in_array( 'full-width', $_POST['wpbf_options'], true ) ) {
			$checked[] = 'full-width';
		}

		if ( in_array( 'contained', $_POST['wpbf_options'], true ) ) {
			$checked[] = 'contained';
		}

		if ( in_array( 'custom-width', $_POST['wpbf_options'], true ) ) {
			$checked[] = 'custom-width';
		}

		if ( isset( $_POST['wpbf_options']['custom_width_value'] ) ) {
			$checked['custom_width_value'] = $_POST['wpbf_options']['custom_width_value'];
		}

		if ( in_array( 'layout-global', $_POST['wpbf_options'], true ) ) {
			$checked[] = 'layout-global';
		}

		if ( in_array( 'remove-featured', $_POST['wpbf_options'], true ) ) {
			$checked[] = 'remove-featured';
		}

		if ( in_array( 'remove-header', $_POST['wpbf_options'], true ) ) {
			$checked[] = 'remove-header';
		}

		if ( in_array( 'remove-footer', $_POST['wpbf_options'], true ) ) {
			$checked[] = 'remove-footer';
		}
	}

	update_post_meta( $post_id, 'wpbf_options', $checked );

	// Save sidebar metadata.
	$wpbf_sidebar_position = isset( $_POST['wpbf_sidebar_position'] ) ? $_POST['wpbf_sidebar_position'] : '';

	update_post_meta( $post_id, 'wpbf_sidebar_position', $wpbf_sidebar_position );

}
add_action( 'save_post', 'wpbf_save_metadata', 10, 3 );

/**
 * Prepare custom column(s) setup.
 */
function wpbf_prepare_post_list_custom_columns() {

	$post_types = get_post_types( array( 'public' => true ) );

	foreach ( $post_types as $post_type ) {

		add_filter( "manage_{$post_type}_posts_columns", 'wpbf_post_list_columns' );
		add_action( "manage_{$post_type}_posts_custom_column", 'wpbf_post_list_custom_column', 10, 2 );

	}

}
add_action( 'admin_init', 'wpbf_prepare_post_list_custom_columns' );

/**
 * Manage posts columns.
 *
 * At least 1 custom column is needed for us to be able
 * to add custom fields to quick edit box in post list screen.
 *
 * @param array $columns The existing columns.
 * @return array The modified columns.
 */
function wpbf_post_list_columns( $columns ) {

	$columns['wpbf_layout'] = __( 'Layout', 'page-builder-framework' );

	return $columns;

}

/**
 * Manage posts custom column content.
 *
 * @param string $column_name The name of the column to display.
 * @param int    $post_id The current post ID.
 */
function wpbf_post_list_custom_column( $column_name, $post_id ) {

	if ( 'wpbf_layout' !== $column_name ) {
		return;
	}

	$post_options = get_post_meta( $post_id, 'wpbf_options', true );
	$post_options = is_array( $post_options ) ? $post_options : array();
	$column_value = '';

	if ( in_array( 'full-width', $post_options, true ) ) {
		$layout = 'full-width';

		$column_value = __( 'Full Width', 'page-builder-framework' );
	} elseif ( in_array( 'contained', $post_options, true ) ) {
		$layout = 'contained';

		$column_value = __( 'Contained', 'page-builder-framework' );
	} else {
		$layout = 'layout-global';

		$column_value = __( 'Inherit Global Settings', 'page-builder-framework' );
	}

	$checked_removals = array();

	if ( in_array( 'remove-title', $post_options, true ) ) {
		array_push( $checked_removals, 'remove-title' );
	}

	if ( in_array( 'remove-featured', $post_options, true ) ) {
		array_push( $checked_removals, 'remove-featured' );
	}

	if ( in_array( 'remove-header', $post_options, true ) ) {
		array_push( $checked_removals, 'remove-header' );
	}

	if ( in_array( 'remove-footer', $post_options, true ) ) {
		array_push( $checked_removals, 'remove-footer' );
	}

	$removals = implode( ',', $checked_removals );

	$sidebar_position = get_post_meta( $post_id, 'wpbf_sidebar_position', true );
	$sidebar_position = ! empty( $sidebar_position ) ? $sidebar_position : 'global';

	$options_nonce = wp_create_nonce( "wpbf_post_{$post_id}_options_nonce" );
	$sidebar_nonce = wp_create_nonce( "wpbf_post_{$post_id}_sidebar_nonce" );

	$custom_data_attr = apply_filters( 'wpbf_post_list_quick_edit_preset_data_attr', '', $post_id );
	?>

	<span class="wpbf-quick-edit-column-value"><?php echo esc_html( $column_value ); ?></span>

	<input
		type="hidden"
		class="wpbf-quick-edit-preset-values"
		data-wpbf-layout="<?php echo $layout; ?>"
		data-wpbf-checked-removals="<?php echo esc_attr( $removals ); ?>"
		data-wpbf-sidebar-position="<?php echo esc_attr( $sidebar_position ); ?>"
		data-wpbf-options-nonce="<?php echo esc_attr( $options_nonce ); ?>"
		data-wpbf-sidebar-nonce="<?php echo esc_attr( $sidebar_nonce ); ?>"
		<?php echo $custom_data_attr; ?>
	>

	<?php

}
