<?php
/**
 * Header builder customizer settings.
 *
 * This header-builder.php file is included in init.php
 * inside a condition where the value of `wpbf_enable_header_builder` is true.
 *
 * @package Page Builder Framework
 */

/**
 * Render header builder.
 */
function wpbf_do_header_builder() {

	$rows = get_theme_mod( 'wpbf_header_builder', array() );

	if ( empty( $rows ) ) {
		return;
	}

	$active_rows = [];

	foreach ( $rows as $row_key => $cols ) {
		if ( empty( $row_key ) || empty( $cols ) ) {
			continue;
		}

		foreach ( $cols as $col_key => $widget_keys ) {
			if ( empty( $widget_keys ) ) {
				continue;
			}

			if ( ! isset( $active_rows[ $row_key ] ) ) {
				$active_rows[ $row_key ] = [];
			}

			$active_rows[ $row_key ][ $col_key ] = $widget_keys;
		}
	}

	if ( empty( $active_rows ) ) {
		return;
	}

	foreach ( $active_rows as $row_key => $cols ) {
		if ( empty( $row_key ) || empty( $cols ) ) {
			continue;
		}

		$row_id_prefix = 'wpbf_header_builder_' . $row_key . '_';

		$dimensions   = [ 'large', 'medium', 'small' ];
		$visibilities = get_theme_mod( $row_id_prefix . 'visibility', null );
		$visibilities = is_array( $visibilities ) ? $visibilities : [ 'large', 'medium', 'small' ];

		$hidden_dimensions = array_diff( $dimensions, $visibilities );

		$visibility_class = implode( ' ', array_map( function ( $dimension ) {
			return 'wpbf-hidden-' . esc_attr( $dimension );
		}, $hidden_dimensions ) );

		$use_container = get_theme_mod( $row_id_prefix . 'use_container', null );
		$use_container = is_null( $use_container ) ? true : boolval( $use_container );

		echo '<div class="wpbf-header-row wpbf-header-row-' . esc_attr( $row_key ) . ' ' . esc_attr( $visibility_class ) . '">';

		if ( $use_container ) {
			echo '<div class="wpbf-container wpbf-container-center">';
		}

		echo '<div class="wpbf-row-content wpbf-flex wpbf-items-center wpbf-content-center">';

		$col_class = 'wpbf-flex';

		foreach ( $cols as $col_key => $widget_keys ) {
			$alignment_class = 'wpbf-content-center';

			if ( false !== stripos( $col_key, '_start' ) ) {
				$alignment_class = 'wpbf-content-start';
			} elseif ( false !== stripos( $col_key, '_end' ) ) {
				$alignment_class = 'wpbf-content-end';
			}

			echo '<div class="' . esc_attr( "$col_class $alignment_class" ) . '">';

			foreach ( $widget_keys as $widget_key ) {
				if ( empty( $widget_key ) ) {
					continue;
				}

				wpbf_render_builder_widget( $widget_key );
			}

			echo '</div>';
		}

		echo '</div>';

		if ( $use_container ) {
			echo '</div>';
		}

		echo '</div>';
	}

}
add_action( 'wpbf_header_builder', 'wpbf_do_header_builder' );

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
		case 'html_2':
			wpbf_render_builder_html_widget( 'wpbf_header_builder_' . $widget_key . '_content' );
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

/**
 * Render the builder html widget.
 *
 * @param string $setting_id The setting id.
 */
function wpbf_render_builder_html_widget( $setting_id ) {

	$content = get_theme_mod( $setting_id, '' );

	if ( empty( $content ) ) {
		return;
	}
	?>

	<div class="wpbf-html-widget">
		<?php echo wp_kses_post( $content ); ?>
	</div>

	<?php
}
