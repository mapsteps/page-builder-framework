<?php
/**
 * Header builder customizer styles.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$header_builder_rows = get_theme_mod( 'wpbf_header_builder', array() );

$rows = array();

if ( is_array( $header_builder_rows ) && ! empty( $header_builder_rows ) ) {
	foreach ( $header_builder_rows as $row_key => $columns ) {
		if ( empty( $row_key ) || empty( $columns ) ) {
			continue;
		}

		foreach ( $columns as $column_key => $widget_keys ) {
			if ( empty( $column_key ) || empty( $widget_keys ) ) {
				continue;
			}

			if ( ! isset( $rows[ $row_key ] ) ) {
				$rows[ $row_key ] = array();
			}

			if ( ! isset( $rows[ $row_key ][ $column_key ] ) ) {
				$rows[ $row_key ][ $column_key ] = array();
			}

			foreach ( $widget_keys as $widget_key ) {
				if ( empty( $widget_key ) ) {
					continue;
				}

				$rows[ $row_key ][ $column_key ][] = $widget_key;
			}
		}
	}
}

foreach ( $rows as $row_key => $columns ) {
	$row_id_prefix = 'wpbf_header_builder_' . $row_key . '_';

	echo '.wpbf-header-row-' . esc_attr( $row_key ) . '{';

	$min_heights = get_theme_mod( $row_id_prefix . 'min_height', [] );
	$min_heights = ! is_array( $min_heights ) ? [] : $min_heights;

	if ( $min_heights ) {
		if ( isset( $min_heights['desktop'] ) ) {
			echo sprintf( 'min-height: %s;', esc_attr( $min_heights['desktop'] ) );
		}

		if ( isset( $min_heights['tablet'] ) ) {
			echo '@media screen and (max-width: ' . esc_attr( $breakpoint_medium ) . ') {';
			echo sprintf( 'min-height: %s;', esc_attr( $min_heights['tablet'] ) );
			echo '}';
		}

		if ( isset( $min_heights['mobile'] ) ) {
			echo '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ') {';
			echo sprintf( 'min-height: %s;', esc_attr( $min_heights['mobile'] ) );
			echo '}';
		}
	}

	$v_paddings = get_theme_mod( $row_id_prefix . 'vertical_padding', [] );
	$v_paddings = ! is_array( $v_paddings ) ? [] : $v_paddings;

	if ( $v_paddings ) {
		if ( isset( $v_paddings['desktop'] ) ) {
			echo sprintf( 'padding-top: %s;', esc_attr( $v_paddings['desktop'] ) );
			echo sprintf( 'padding-bottom: %s;', esc_attr( $v_paddings['desktop'] ) );
		}

		if ( isset( $v_paddings['tablet'] ) ) {
			echo '@media screen and (max-width: ' . esc_attr( $breakpoint_medium ) . ') {';
			echo sprintf( 'padding-top: %s;', esc_attr( $v_paddings['tablet'] ) );
			echo sprintf( 'padding-bottom: %s;', esc_attr( $v_paddings['tablet'] ) );
			echo '}';
		}

		if ( isset( $v_paddings['mobile'] ) ) {
			echo '@media screen and (max-width: ' . esc_attr( $breakpoint_mobile ) . ') {';
			echo sprintf( 'padding-top: %s;', esc_attr( $v_paddings['mobile'] ) );
			echo sprintf( 'padding-bottom: %s;', esc_attr( $v_paddings['mobile'] ) );
			echo '}';
		}
	}

	$bg_color = get_theme_mod( $row_id_prefix . 'bg_color', '' );

	if ( $bg_color ) {
		echo sprintf( 'background-color: %s;', esc_attr( $bg_color ) );
	}

	echo '}';
}
