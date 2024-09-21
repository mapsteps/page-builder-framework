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

		$col_class = 'wpbf-flex wpbf-header-column';

		$column_position = '';

		foreach ( $cols as $col_key => $widget_keys ) {
			$alignment_class = 'wpbf-content-center';

			if ( false !== stripos( $col_key, '_start' ) ) {
				$alignment_class = 'wpbf-content-start';
				$column_position = 'left';
			} elseif ( false !== stripos( $col_key, '_end' ) ) {
				$alignment_class = 'wpbf-content-end';
				$column_position = 'right';
			}

			echo '<div class="' . esc_attr( "$col_class $alignment_class" ) . '">';

			foreach ( $widget_keys as $widget_key ) {
				if ( empty( $widget_key ) ) {
					continue;
				}

				wpbf_render_builder_widget( 'header_builder', $widget_key, $column_position );
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
 * @param string $builder_type The builder type. Accepts 'header_builder' or 'footer_builder'.
 * @param string $widget_key The widget key.
 * @param string $column_position The column position.
 */
function wpbf_render_builder_widget( $builder_type, $widget_key, $column_position = '' ) {

	if ( empty( $widget_key ) ) {
		return;
	}

	$setting_group = "wpbf_$builder_type" . '_' . $widget_key;

	switch ( $widget_key ) {
		case 'logo':
			wpbf_render_builder_logo_widget( $setting_group );
			break;
		case 'search':
			wpbf_render_builder_search_widget( $setting_group );
			break;
		case 'button_1':
		case 'button_2':
			wpbf_render_builder_button_widget( $setting_group );
			break;
		case 'menu_1':
		case 'menu_2':
			wpbf_render_builder_menu_widget( $setting_group, $column_position );
			break;
		case 'html_1':
		case 'html_2':
			wpbf_render_builder_html_widget( $setting_group );
			break;
	}

}

/**
 * Render the builder logo widget.
 *
 * @param string $setting_group The setting group key.
 */
function wpbf_render_builder_logo_widget( $setting_group ) {

	get_template_part( 'inc/template-parts/logo/logo' );

}

/**
 * Render the builder search widget.
 *
 * @param string $setting_group The setting group key.
 */
function wpbf_render_builder_search_widget( $setting_group ) {

	wpbf_search_menu_item( false, false );

}

/**
 * Render the builder button widget.
 *
 * @param string $setting_group The setting group key.
 */
function wpbf_render_builder_button_widget( $setting_group ) {

	// todo
}

/**
 * Render the builder menu widget.
 *
 * @param string $setting_group The setting group key.
 * @param string $column_position The column position. Accepts 'left', 'center', 'right', or empty string.
 */
function wpbf_render_builder_menu_widget( $setting_group, $column_position = '' ) {

	$menu_id = get_theme_mod( $setting_group . '_menu_id', '' );

	if ( empty( $menu_id ) ) {
		return;
	}

	$menu_position_class = 'wpbf-menu-' . $column_position;
	?>

	<nav class="navigation wpbf-clearfix <?php echo esc_attr( $menu_position_class ); ?>" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement" aria-label="<?php _e( 'Site Navigation', 'page-builder-framework' ); ?>">

		<?php
		wp_nav_menu(
			array(
				'menu'        => $menu_id,
				'container'   => false,
				'menu_class'  => 'wpbf-menu wpbf-sub-menu' . wpbf_sub_menu_alignment() . wpbf_sub_menu_animation() . wpbf_menu_hover_effect(),
				'depth'       => 4,
				'fallback_cb' => false,
			)
		);
		?>

	</nav>

	<?php
}

/**
 * Render the builder html widget.
 *
 * @param string $setting_group The setting group key.
 */
function wpbf_render_builder_html_widget( $setting_group ) {

	$content = get_theme_mod( $setting_group . '_content', '' );
	?>

	<div class="wpbf-html-widget">
		<?php echo wp_kses_post( $content ); ?>
	</div>

	<?php
}
