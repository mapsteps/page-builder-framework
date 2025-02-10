<?php

namespace Mapsteps\Wpbf\Customizer\HeaderBuilder;

class HeaderBuilderOutput {

	/**
	 * Associative array with row_key as key and columns as value.
	 *
	 * @var array
	 */
	private $desktop_columns = array();

	/**
	 * Associative array with row_key as key and columns as value.
	 *
	 * @var array
	 */
	private $mobile_columns = array();

	/**
	 * Setup hooks to render header builder in front area.
	 */
	public function setup_hooks() {

		$saved_values = get_theme_mod( 'wpbf_header_builder', array() );

		$desktop_values      = isset( $saved_values['desktop'] ) && is_array( $saved_values['desktop'] ) ? $saved_values['desktop'] : array();
		$desktop_rows        = isset( $desktop_values['rows'] ) && is_array( $desktop_values['rows'] ) ? $desktop_values['rows'] : array();
		$active_desktop_rows = $this->get_active_rows( $desktop_rows );

		if ( ! empty( $active_desktop_rows ) ) {
			foreach ( $active_desktop_rows as $desktop_row_key => $desktop_columns ) {
				if ( empty( $desktop_row_key ) || empty( $desktop_columns ) ) {
					continue;
				}

				$this->desktop_columns[ $desktop_row_key ] = $desktop_columns;
			}

			// Unhook functions which are supposed to be used when header builder is disabled.
			remove_action( 'wpbf_pre_header', 'wpbf_do_pre_header' );
			remove_action( 'wpbf_navigation', 'wpbf_menu' );

			// Hook functions which are supposed to be used when header builder is enabled.
			add_action( 'wpbf_pre_header', [ $this, 'do_desktop_pre_header' ] );
			add_action( 'wpbf_navigation', [ $this, 'do_desktop_navigation' ] );
		}

		$mobile_values      = isset( $saved_values['mobile'] ) && is_array( $saved_values['mobile'] ) ? $saved_values['mobile'] : array();
		$mobile_rows        = isset( $mobile_values['rows'] ) && is_array( $mobile_values['rows'] ) ? $mobile_values['rows'] : array();
		$active_mobile_rows = $this->get_active_rows( $mobile_rows );

		if ( ! empty( $active_mobile_rows ) ) {
			foreach ( $active_mobile_rows as $mobile_row_key => $mobile_columns ) {
				if ( empty( $mobile_row_key ) || empty( $mobile_columns ) ) {
					continue;
				}

				$this->mobile_columns[ $mobile_row_key ] = $mobile_columns;
			}

			// Unhook functions which are supposed to be used when header builder is disabled.
			remove_action( 'wpbf_mobile_navigation', 'wpbf_mobile_menu' );

			// Hook functions which are supposed to be used when header builder is enabled.
			add_action( 'wpbf_navigation', [ $this, 'do_mobile_navigation' ] );
		}

	}

	/**
	 * Get the active rows.
	 *
	 * @param array $rows The rows to check.
	 *
	 * @return array The active rows.
	 */
	private function get_active_rows( $rows = array() ) {

		if ( empty( $rows ) ) {
			return array();
		}

		$active_rows = [];

		foreach ( $rows as $row_key => $columns ) {
			if ( empty( $row_key ) || empty( $columns ) ) {
				continue;
			}

			foreach ( $columns as $column_key => $widget_keys ) {
				if ( empty( $widget_keys ) ) {
					continue;
				}

				if ( ! isset( $active_rows[ $row_key ] ) ) {
					$active_rows[ $row_key ] = [];
				}

				$active_rows[ $row_key ][ $column_key ] = $widget_keys;
			}
		}

		return $active_rows;

	}

	/**
	 * An action to render desktop pre-header.
	 *
	 * This action will be hooked to `wpbf_pre_header` action hook.
	 *
	 * @see self::setup_hooks()
	 */
	public function do_desktop_pre_header() {

		$pre_header_columns = isset( $this->desktop_columns['desktop_row_1'] ) ? $this->desktop_columns['desktop_row_1'] : array();

		if ( empty( $pre_header_columns ) || ! is_array( $pre_header_columns ) ) {
			return;
		}
		?>

		<div id="pre-header" class="wpbf-pre-header">
			<?php
			do_action( 'wpbf_before_pre_header' );
			$this->render_desktop_row( 'desktop_row_1', $pre_header_columns );
			do_action( 'wpbf_after_pre_header' );
			?>
		</div>

		<?php
	}

	/**
	 * An action to render desktop navigation.
	 *
	 * This action will be hooked to `wpbf_navigation` action hook.
	 *
	 * @see self::setup_hooks()
	 */
	public function do_desktop_navigation() {

		$row_2_columns = isset( $this->desktop_columns['desktop_row_2'] ) ? $this->desktop_columns['desktop_row_2'] : array();

		if ( ! empty( $row_2_columns ) && is_array( $row_2_columns ) ) {
			$this->render_desktop_row( 'desktop_row_2', $row_2_columns );
		}

		$row_3_columns = isset( $this->desktop_columns['desktop_row_3'] ) ? $this->desktop_columns['desktop_row_3'] : array();

		if ( ! empty( $row_3_columns ) && is_array( $row_3_columns ) ) {
			$this->render_desktop_row( 'desktop_row_3', $row_3_columns );
		}

	}

	/**
	 * Render desktop header builder row.
	 *
	 * @param string $row_key The row key.
	 * @param array  $columns The row columns.
	 */
	private function render_desktop_row( $row_key, $columns ) {

		$row_id_prefix = 'wpbf_header_builder_' . $row_key . '_';

		$dimensions   = [ 'large', 'medium', 'small' ];
		$visibilities = get_theme_mod( $row_id_prefix . 'visibility', null );
		$visibilities = is_array( $visibilities ) ? $visibilities : [ 'large', 'medium', 'small' ];

		// Lets only enable desktop for now.
		$visibilities = [ 'large' ];

		$hidden_dimensions = array_diff( $dimensions, $visibilities );

		$visibility_class = implode( ' ', array_map( function ( $dimension ) {
			return 'wpbf-hidden-' . esc_attr( $dimension );
		}, $hidden_dimensions ) );

		$container_class = 'wpbf-container wpbf-container-center';

		$row_class = ( 'desktop_row_1' === $row_key ? "wpbf-inner-pre-header $container_class " : '' ) . 'wpbf-header-row wpbf-header-row-' . esc_attr( $row_key ) . ' ' . esc_attr( $visibility_class );

		echo '<div class="' . esc_attr( $row_class ) . '">';

		if ( 'desktop_row_1' !== $row_key ) {
			echo '<div class="' . esc_attr( $container_class ) . '">';
		}

		echo '<div class="' . ( 'desktop_row_1' === $row_key ? 'wpbf-inner-pre-header-content ' : '' ) . 'wpbf-row-content wpbf-flex wpbf-items-center wpbf-content-center">';

		foreach ( $columns as $column_key => $widget_keys ) {
			$column_class    = 'wpbf-flex wpbf-header-column';
			$alignment_class = 'wpbf-content-center wpbf-items-center';
			$column_position = '';

			if ( false !== stripos( $column_key, '_start' ) ) {
				$alignment_class = 'wpbf-content-start';
				$column_position = 'left';
			} elseif ( false !== stripos( $column_key, '_end' ) ) {
				$alignment_class = 'wpbf-content-end';
				$column_position = 'right';
			}

			if (
			in_array( 'desktop_menu_1', $widget_keys, true )
			|| in_array( 'desktop_menu_2', $widget_keys, true )
			|| in_array( 'desktop_html_1', $widget_keys, true )
			|| in_array( 'desktop_html_2', $widget_keys, true )
			) {
				$column_class .= ' wpbf-column-grow';
			}

			echo '<div class="' . esc_attr( "$column_class $alignment_class" ) . '">';

			foreach ( $widget_keys as $widget_key ) {
				if ( empty( $widget_key ) ) {
					continue;
				}

				wpbf_render_builder_widget( 'header_builder', $widget_key, $column_position );
			}

			echo '</div>';
		}

		echo '</div>';

		if ( 'desktop_row_1' !== $row_key ) {
			echo '</div>';
		}

		echo '</div>';

	}

	/**
	 * An action to render mobile navigation.
	 *
	 * This action will be hooked to `wpbf_navigation` action hook.
	 *
	 * @see self::setup_hooks()
	 */
	public function do_mobile_navigation() {

		$row_1_columns = isset( $this->mobile_columns['mobile_row_1'] ) ? $this->mobile_columns['mobile_row_1'] : array();

		if ( ! empty( $row_1_columns ) && is_array( $row_1_columns ) ) {
			$this->render_mobile_row( 'mobile_row_1', $row_1_columns );
		}

		$row_2_columns = isset( $this->mobile_columns['mobile_row_2'] ) ? $this->mobile_columns['mobile_row_2'] : array();

		if ( ! empty( $row_2_columns ) && is_array( $row_2_columns ) ) {
			$this->render_mobile_row( 'mobile_row_2', $row_2_columns );
		}

		$row_3_columns = isset( $this->mobile_columns['mobile_row_3'] ) ? $this->mobile_columns['mobile_row_3'] : array();

		if ( ! empty( $row_3_columns ) && is_array( $row_3_columns ) ) {
			$this->render_mobile_row( 'mobile_row_3', $row_3_columns );
		}

	}

	/**
	 * Render mobile header builder row.
	 *
	 * @param string $row_key The row key.
	 * @param array  $columns The row columns.
	 */
	private function render_mobile_row( $row_key, $columns ) {

		$row_id_prefix = 'wpbf_header_builder_' . $row_key . '_';

		$dimensions   = [ 'large', 'medium', 'small' ];
		$visibilities = get_theme_mod( $row_id_prefix . 'visibility', null );
		$visibilities = is_array( $visibilities ) ? $visibilities : [ 'medium', 'small' ];

		// Lets only enable mobile for now.
		$visibilities = [ 'medium', 'small' ];

		$hidden_dimensions = array_diff( $dimensions, $visibilities );

		$visibility_class = implode( ' ', array_map( function ( $dimension ) {
			return 'wpbf-hidden-' . esc_attr( $dimension );
		}, $hidden_dimensions ) );

		$container_class = 'wpbf-container wpbf-container-center';

		$row_class = ( 'mobile_row_1' === $row_key ? "wpbf-inner-pre-header $container_class " : '' ) . 'wpbf-header-row wpbf-header-row-' . esc_attr( $row_key ) . ' ' . esc_attr( $visibility_class );

		echo '<div class="' . esc_attr( $row_class ) . '">';

		if ( 'mobile_row_1' !== $row_key ) {
			echo '<div class="' . esc_attr( $container_class ) . '">';
		}

		echo '<div class="' . ( 'mobile_row_1' === $row_key ? 'wpbf-inner-pre-header-content ' : '' ) . 'wpbf-row-content wpbf-flex wpbf-items-center wpbf-content-center">';

		foreach ( $columns as $column_key => $widget_keys ) {

			$column_class    = 'wpbf-flex wpbf-header-column';
			$alignment_class = 'wpbf-content-center wpbf-items-center';
			$column_position = '';

			if ( false !== stripos( $column_key, '_start' ) ) {
				$alignment_class = 'wpbf-content-start';
				$column_position = 'left';
			} elseif ( false !== stripos( $column_key, '_end' ) ) {
				$alignment_class = 'wpbf-content-end';
				$column_position = 'right';
			}

			// print( '<pre>' . print_r( $widget_keys, true ) . '</pre>' );

			if (
			in_array( 'mobile_menu_1', $widget_keys, true )
			|| in_array( 'mobile_menu_2', $widget_keys, true )
			|| in_array( 'mobile_html_1', $widget_keys, true )
			|| in_array( 'mobile_html_2', $widget_keys, true )
			|| in_array( 'mobile_button_1', $widget_keys, true )
			|| in_array( 'mobile_button_2', $widget_keys, true )
			|| in_array( 'mobile_search', $widget_keys, true )
			|| in_array( 'mobile_logo', $widget_keys, true )
			) {
				$column_class .= ' wpbf-column-grow';
			}

			echo '<div class="' . esc_attr( "$column_class $alignment_class" ) . '">';

			foreach ( $widget_keys as $widget_key ) {

				if ( empty( $widget_key ) ) {
					continue;
				}

				wpbf_render_builder_widget( 'header_builder', $widget_key, $column_position );
			}

			echo '</div>';
		}

		echo '</div>';

		if ( 'mobile_row_1' !== $row_key ) {
			echo '</div>';
		}

		echo '</div>';

	}

}
