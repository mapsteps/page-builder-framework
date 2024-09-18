<?php
/**
 * Header builder customizer settings.
 *
 * This header-builder.php file is included in init.php
 * inside a condition where the value of `wpbf_header_builder_enabled` is true.
 *
 * @package Page Builder Framework
 */

remove_action( 'wpbf_pre_header', 'wpbf_do_pre_header' );
remove_action( 'wpbf_navigation', 'wpbf_menu' );

/**
 * Render header builder.
 */
function wpbf_do_header_builder() {

	$rows = get_theme_mod( 'wpbf_header_builder', array() );

	if ( empty( $rows ) ) {
		return;
	}

	foreach ( $rows as $row_key => $cols ) {
		if ( empty( $row_key ) || empty( $cols ) ) {
			continue;
		}

		$total_cols = count( $cols );

		$col_class = 1 === $total_cols ? 'wpbf-1-1' : '';

		echo '<div class="wpbf-grid ' . esc_attr( $row_key ) . '">';

		foreach ( $cols as $col_key => $widget_keys ) {
			$alignment_class = 'wpbf-content-center';

			if ( 'column_1' === $col_key ) {
				$alignment_class = 'wpbf-content-start';
			} elseif ( 'column_3' === $col_key ) {
				$alignment_class = 'wpbf-content-end';
			}

			echo '<div class="' . esc_attr( "$col_class $alignment_class" ) . '">';

			foreach ( $widget_keys as $widget_key ) {
				if ( $widget_key ) {
					continue;
				}

				wpbf_render_builder_widget( $widget_key );
			}

			echo '</div>';
		}

		echo '</div>';
	}

}
add_action( 'wpbf_header', 'wpbf_do_header_builder' );

/**
 * Header builder pre-header.
 */
function wpbf_do_header_builder_pre_header() {
}

/**
 * Header builder main row.
 */
function wpbf_do_header_builder_main_row() {
}

/**
 * Header builder secondary row.
 */
function wpbf_do_header_builder_secondary_row() {
}

/**
 * Render builder widget.
 *
 * @param string $widget_key The widget key.
 */
function wpbf_render_builder_widget( $widget_key ) {

	if ( empty( $widget_key ) ) {
		return;
	}

	switch ( $widget_key ) {
		case 'logo':
			wpbf_render_builder_logo_widget( $widget_key );
			break;
		case 'search':
			wpbf_render_builder_search_widget( $widget_key );
			break;
		case 'button_1':
			wpbf_render_builder_button_widget( $widget_key );
			break;
		case 'button_2':
			wpbf_render_builder_button_widget( $widget_key );
			break;
		case 'menu_1':
			wpbf_render_builder_menu_widget( $widget_key );
			break;
		case 'menu_2':
			wpbf_render_builder_menu_widget( $widget_key );
			break;
		case 'html_1':
			wpbf_render_builder_html_widget( $widget_key );
			break;
		case 'html_2':
			wpbf_render_builder_html_widget( $widget_key );
			break;
	}

}

/**
 * Render the builder logo widget.
 *
 * @param string $widget_key The widget key.
 */
function wpbf_render_builder_logo_widget( $widget_key ) {

	get_template_part( 'inc/template-parts/logo/logo' );

}

/**
 * Render the builder search widget.
 *
 * @param string $widget_key The widget key.
 */
function wpbf_render_builder_search_widget( $widget_key ) {

	wpbf_search_menu_item( false, false );

}

/**
 * Render the builder button widget.
 *
 * @param string $widget_key The widget key.
 */
function wpbf_render_builder_button_widget( $widget_key ) {

	// todo
}

/**
 * Render the builder menu widget.
 *
 * @param string $widget_key The widget key.
 */
function wpbf_render_builder_menu_widget( $widget_key ) {

	// todo
}

function wpbf_render_builder_html_widget( $widget_key ) {

	// todo
}
