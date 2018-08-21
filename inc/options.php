<?php
/**
 * Options
 *
 * @package Page Builder Framework
 */

// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'load-post.php', 'wpbf_metabox_setup' );
add_action( 'load-post-new.php', 'wpbf_metabox_setup' );

/* Meta box setup function. */
function wpbf_metabox_setup() {

	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'wpbf_add_metaboxes' );

	/* Save post meta on the 'save_post' hook. */
	add_action( 'save_post', 'wpbf_meta_save', 10, 2 );

}

function wpbf_add_metaboxes() {

	// get all public post types
	$post_types = get_post_types( array( 'public' => true ) );

	// remove post types from array
	unset( $post_types['wpbf_hooks'], $post_types['elementor_library'], $post_types['fl-builder-template'] );

	add_meta_box( 'wpbf', esc_html__( 'Template Settings', 'page-builder-framework' ), 'wpbf_options_metabox', $post_types, 'side', 'default' );

	add_meta_box( 'wpbf_sidebar', esc_html__( 'Sidebar', 'page-builder-framework' ), 'wpbf_sidebar_metabox', $post_types, 'side', 'default' );

}

function wpbf_options_metabox( $post, $post_types ) {

	wp_nonce_field( basename( __FILE__ ), 'wpbf_options_nonce' );
	$wpbf_stored_meta = get_post_meta( $post->ID );

	if (!isset( $wpbf_stored_meta['wpbf_options'][0] ) ) {
		$wpbf_stored_meta['wpbf_options'][0] = false;
	}

	$mydata = $wpbf_stored_meta['wpbf_options'];

	if ( strpos( $mydata[0], 'remove-title' ) !== false ) {
		$remove_title = 'remove-title';
	} else {
		$remove_title = false;
	}

	if ( strpos( $mydata[0], 'full-width') !== false ) {
		$full_width = 'full-width';
	} else {
		$full_width = false;
	}

	if ( strpos( $mydata[0], 'remove-header') !== false ) {
		$remove_header = 'remove-header';
	} else {
		$remove_header = false;
	}

	if ( strpos( $mydata[0], 'remove-footer') !== false ) {
		$remove_footer = 'remove-footer';
	} else {
		$remove_footer = false;
	}

	?>

	<div>
		<input id="remove-title" type="checkbox" name="wpbf_options[]" value="remove-title" <?php checked( $remove_title, 'remove-title' ); ?> />
		<label for="remove-title"><?php _e( 'Hide Page Title', 'page-builder-framework' ); // WPCS: XSS ok. ?></label>
	</div>

	<div>
		<input id="full-width" type="checkbox" name="wpbf_options[]" value="full-width" <?php checked( $full_width, 'full-width' ); ?> />
		<label for="full-width"><?php _e( 'Full Width', 'page-builder-framework' ); // WPCS: XSS ok. ?></label>
	</div>

	<div>
		<input id="remove-header" type="checkbox" name="wpbf_options[]" value="remove-header" <?php checked( $remove_header, 'remove-header' ); ?> />
		<label for="remove-header"><?php _e( 'Disable Header', 'page-builder-framework' ); // WPCS: XSS ok. ?></label>
	</div>

	<div>
		<input id="remove-footer" type="checkbox" name="wpbf_options[]" value="remove-footer" <?php checked( $remove_footer, 'remove-footer' ); ?> />
		<label for="remove-footer"><?php _e( 'Disable Footer', 'page-builder-framework' ); // WPCS: XSS ok. ?></label>
	</div>

<?php }

function wpbf_sidebar_metabox( $post ) {

	wp_nonce_field( basename( __FILE__ ), 'wpbf_sidebar_nonce' );
	$wpbf_stored_meta = get_post_meta( $post->ID );

	$wpbf_sidebar_position = isset ( $wpbf_stored_meta['wpbf_sidebar_position'][0] ) ? $wpbf_stored_meta['wpbf_sidebar_position'][0] : 'global';

	?>

	<div>
		<input id="sidebar-global" type="radio" name="wpbf_sidebar_position" value="global" <?php checked( $wpbf_sidebar_position, 'global' ); ?> />
		<label for="sidebar-global"><?php _e( 'Inherit Global Settings', 'page-builder-framework' ); // WPCS: XSS ok. ?></label>
	</div>

	<div>
		<input id="sidebar-right" type="radio" name="wpbf_sidebar_position" value="right" <?php checked( $wpbf_sidebar_position, 'right' ); ?> />
		<label for="sidebar-right"><?php _e( 'Right Sidebar', 'page-builder-framework' ); // WPCS: XSS ok. ?></label>
	</div>

	<div>
		<input id="sidebar-left" type="radio" name="wpbf_sidebar_position" value="left" <?php checked( $wpbf_sidebar_position, 'left' ); ?> />
		<label for="sidebar-left"><?php _e( 'Left Sidebar', 'page-builder-framework' ); // WPCS: XSS ok. ?></label>
	</div>

	<div>
		<input id="no-sidebar" type="radio" name="wpbf_sidebar_position" value="none" <?php checked( $wpbf_sidebar_position, 'none' ); ?> />
		<label for="no-sidebar"><?php _e( 'No Sidebar', 'page-builder-framework' ); // WPCS: XSS ok. ?></label>
	</div>

<?php }

function wpbf_meta_save( $post_id ) {

	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST['wpbf_options_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['wpbf_options_nonce'] ), basename( __FILE__ ) ) ) ? true : false;
	$is_valid_sidebar_nonce = ( isset( $_POST['wpbf_sidebar_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['wpbf_sidebar_nonce'] ), basename( __FILE__ ) ) ) ? true : false;

	if ( $is_autosave || $is_revision || !$is_valid_nonce || !$is_valid_sidebar_nonce ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	// save template options
	if ( isset( $_POST['wpbf_options'] ) ) {

		$checked = array();

		// sanitizing
		if ( in_array( 'remove-title', $_POST['wpbf_options'] ) !== false ) { // WPCS: sanitization ok.
			$checked[] .= 'remove-title';
		}

		if ( in_array( 'full-width', $_POST['wpbf_options'] ) !== false ) { // WPCS: sanitization ok.
			$checked[] .= 'full-width';
		}

		if ( in_array( 'remove-header', $_POST['wpbf_options'] ) !== false ) { // WPCS: sanitization ok.
			$checked[] .= 'remove-header';
		}

		if ( in_array( 'remove-footer', $_POST['wpbf_options'] ) !== false ) { // WPCS: sanitization ok.
			$checked[] .= 'remove-footer';
		}

	} else {

		// if sanitization fails, pass an empty array.
		$checked = array();

	}

	update_post_meta( $post_id, 'wpbf_options', $checked );

	// save sidebar options
	$wpbf_sidebar_position = isset( $_POST['wpbf_sidebar_position'] ) ? sanitize_text_field( wp_unslash( $_POST['wpbf_sidebar_position'] ) ) : '';

	update_post_meta( $post_id, 'wpbf_sidebar_position', $wpbf_sidebar_position );

}