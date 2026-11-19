<?php
/**
 * Customizer CSS: General (page layout, boxed layout, scroll to top, accent color, theme buttons, sidebar, breadcrumbs).
 *
 * Plain PHP, included from styles.php with wpbf_css_area( 'general' ). How to write it:
 *
 * wpbf_css( $selector, $declarations, $args ) writes one CSS block.
 * - Declaration values hold option values as {option_id}, or {option_id.key} for one part of a JSON option
 *   (like {page_padding.desktop_top}). Text around it is kept: '{button_border_radius}px'. {option_id|px} adds px only
 *   when the value is a plain number (for options saved with or without a unit, like '14px' or '14').
 * - A declaration prints when its options are set and at least one differs from its default. Values with several
 *   parts (padding) compare as a whole; when they differ, every part that has a value prints.
 * - Declarations without an option ('border-style' => 'solid') print along with the others in the block.
 * - $args: 'media' => 'max-desktop' | 'max-medium' | 'max-mobile' | 'min-desktop' | 'min-medium' | 'min-mobile'
 *   (built from Premium's breakpoints) or any media query; 'always' => true prints the block even at the defaults;
 *   'when' => 'option_id' prints it only while that option is on (or not 0), 'option_id.key' while one part is.
 * - For CSS that old code printed differently (see styles/header.php): 'saved' => true prints a declaration whenever
 *   its options are saved, even as their defaults, and nothing while they aren't; 'unless' => '20' (with 'saved') not
 *   when saved exactly as that text (old `=== '20'` checks); 'parts' => true compares each part of a JSON option
 *   ({padding.top}) with the default's part on its own, exactly (old per-side / per-device checks).
 *
 * In the Customizer preview, changing an option used in wpbf_css() updates instantly. Changing an option read
 * anywhere else in this file (an if, a calculation, an echo) redraws this file's CSS through PHP, which takes a moment.
 * Plain echo works as before.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Page padding.
$wpbf_devices = array(
	'desktop' => '',
	'tablet'  => 'max-desktop',
	'mobile'  => 'max-mobile',
);

foreach ( $wpbf_devices as $wpbf_device => $wpbf_media ) {
	wpbf_css(
		'#inner-content',
		array(
			'padding-top'    => '{page_padding.' . $wpbf_device . '_top}px',
			'padding-right'  => '{page_padding.' . $wpbf_device . '_right}px',
			'padding-bottom' => '{page_padding.' . $wpbf_device . '_bottom}px',
			'padding-left'   => '{page_padding.' . $wpbf_device . '_left}px',
		),
		array( 'media' => $wpbf_media )
	);
}

foreach ( $wpbf_devices as $wpbf_device => $wpbf_media ) {
	wpbf_css(
		'.wpbf-container',
		array(
			'padding-right' => '{page_padding.' . $wpbf_device . '_right}px',
			'padding-left'  => '{page_padding.' . $wpbf_device . '_left}px',
		),
		array( 'media' => $wpbf_media )
	);
}

// Page width.
wpbf_css( '.wpbf-container', array( 'max-width' => '{page_max_width}' ) );

// Boxed layout.
if ( wpbf_mod( 'page_boxed' ) ) {

	wpbf_css(
		'.wpbf-container',
		array(
			'padding-left'  => '{page_boxed_padding}px',
			'padding-right' => '{page_boxed_padding}px',
		)
	);

	wpbf_css(
		'.wpbf-page',
		array(
			'max-width'        => '{page_max_width}',
			'margin'           => '0 auto',
			'background-color' => '{page_boxed_background}',
		),
		array( 'always' => true )
	);

	wpbf_css(
		'.wpbf-page',
		array(
			'margin-top'    => '{page_boxed_margin}px',
			'margin-bottom' => '{page_boxed_margin}px',
		)
	);

	wpbf_css(
		'#container',
		array(
			'box-shadow' => '{page_boxed_box_shadow_horizontal}px {page_boxed_box_shadow_vertical}px {page_boxed_box_shadow_blur}px {page_boxed_box_shadow_spread}px {page_boxed_box_shadow_color}',
		),
		array(
			'always' => true,
			'when'   => 'page_boxed_box_shadow',
		)
	);

}

// Scroll to top.
if ( wpbf_mod( 'layout_scrolltop' ) ) {

	$wpbf_scrolltop_position = wpbf_mod( 'scrolltop_position' );

	if ( 'left' === $wpbf_scrolltop_position ) {

		wpbf_css(
			'.scrolltop',
			array(
				'right' => 'auto',
				'left'  => '20px',
			),
			array( 'always' => true )
		);

		wpbf_css(
			'.scrolltop',
			array(
				'left'   => '10px',
				'bottom' => '10px',
			),
			array(
				'media'  => 'max-medium',
				'always' => true,
			)
		);

	} elseif ( 'right' === $wpbf_scrolltop_position ) {

		wpbf_css(
			'.scrolltop',
			array(
				'right'  => '10px',
				'bottom' => '10px',
			),
			array(
				'media'  => 'max-medium',
				'always' => true,
			)
		);

	}

	wpbf_css(
		'.scrolltop',
		array(
			'background-color' => '{scrolltop_bg_color}',
			'border-radius'    => '{scrolltop_border_radius}px',
		)
	);

	wpbf_css( '.scrolltop, .scrolltop:hover', array( 'color' => '{scrolltop_icon_color}' ) );

	wpbf_css(
		'.scrolltop:hover',
		array(
			'background-color' => '{scrolltop_bg_color_alt}',
			'color'            => '{scrolltop_icon_color_alt}',
		)
	);

}

// Background (backwards compatibility: options from old versions, no longer in the Customizer).
$wpbf_background_color = get_theme_mod( 'page_background_color' );
$wpbf_background_image = get_theme_mod( 'page_background_image' );

if ( $wpbf_background_color || $wpbf_background_image ) {

	echo 'body{';

	if ( $wpbf_background_color ) {
		echo sprintf( 'background-color: %s;', esc_attr( $wpbf_background_color ) );
	}

	if ( $wpbf_background_image ) {
		echo sprintf( 'background-image: url(%s);', esc_url( $wpbf_background_image ) );
	}

	foreach ( array( 'attachment', 'position', 'repeat', 'size' ) as $wpbf_property ) {
		$wpbf_value = get_theme_mod( 'page_background_' . $wpbf_property );

		if ( $wpbf_value ) {
			echo sprintf( 'background-%s: %s;', esc_attr( $wpbf_property ), esc_attr( $wpbf_value ) );
		}
	}

	echo '}';

}

// Accent color.
wpbf_css( 'a', array( 'color' => '{page_accent_color}' ) );
wpbf_css( '.bypostauthor', array( 'border-color' => '{page_accent_color}' ) );
wpbf_css( '.wpbf-button-primary', array( 'background' => '{page_accent_color}' ) );
wpbf_css( 'a:hover', array( 'color' => '{page_accent_color_alt}' ) );
wpbf_css( '.wpbf-button-primary:hover', array( 'background' => '{page_accent_color_alt}' ) );
wpbf_css( '.wpbf-menu > .current-menu-item > a', array( 'color' => '{page_accent_color_alt}!important' ) );

// Theme buttons: border (only with a border width).
wpbf_css(
	'.wpbf-button, input[type="submit"]',
	array(
		'border-width' => '{button_border_width}px',
		'border-style' => 'solid',
		'border-color' => '{button_border_color}',
	),
	array( 'when' => 'button_border_width' )
);

wpbf_css( '.wpbf-button:hover, input[type="submit"]:hover', array( 'border-color' => '{button_border_color_alt}' ), array( 'when' => 'button_border_width' ) );
wpbf_css( '.wpbf-button-primary', array( 'border-color' => '{button_primary_border_color}' ), array( 'when' => 'button_border_width' ) );
wpbf_css( '.wpbf-button-primary:hover', array( 'border-color' => '{button_primary_border_color_alt}' ), array( 'when' => 'button_border_width' ) );

// Theme buttons: shape and colors.
wpbf_css(
	'.wpbf-button, input[type="submit"]',
	array(
		'border-radius' => '{button_border_radius}px',
		'background'    => '{button_bg_color}',
		'color'         => '{button_text_color}',
	)
);

wpbf_css(
	'.wpbf-button:hover, input[type="submit"]:hover',
	array(
		'background' => '{button_bg_color_alt}',
		'color'      => '{button_text_color_alt}',
	)
);

wpbf_css(
	'.wpbf-button-primary',
	array(
		'background' => '{button_primary_bg_color}',
		'color'      => '{button_primary_text_color}',
	)
);

wpbf_css(
	'.wpbf-button-primary:hover',
	array(
		'background' => '{button_primary_bg_color_alt}',
		'color'      => '{button_primary_text_color_alt}',
	)
);

// Block editor buttons. Gutenberg sets the hover text color to white, so a custom color is repeated for hover.
wpbf_css( '.wp-block-button__link:not(.has-text-color)', array( 'color' => '{button_primary_text_color}' ) );
wpbf_css( '.wp-block-button__link:not(.has-text-color):hover', array( 'color' => '{button_primary_text_color}' ) );
wpbf_css( '.wp-block-button__link:not(.has-background)', array( 'background' => '{button_primary_bg_color}' ) );

wpbf_css(
	'.is-style-outline .wp-block-button__link:not(.has-text-color)',
	array(
		'border-color' => '{button_primary_bg_color}',
		'color'        => '{button_primary_bg_color}',
	)
);

wpbf_css(
	'.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background):not(.has-text-color):hover',
	array(
		'background' => '{button_primary_bg_color_alt}',
		'color'      => '{button_primary_text_color_alt}',
	)
);

wpbf_css(
	'.is-style-outline .wp-block-button__link:not(.has-text-color):not(.has-background):hover',
	array(
		'border-color' => '{button_primary_bg_color_alt}',
		'color'        => '{button_primary_bg_color_alt}',
	)
);

// Page width of cover and group block contents.
wpbf_css( '.wp-block-cover .wp-block-cover__inner-container, .wp-block-group .wp-block-group__inner-container', array( 'max-width' => '{page_max_width}' ) );

// Sidebar.
wpbf_css( '.wpbf-sidebar .widget, .elementor-widget-sidebar .widget', array( 'background' => '{sidebar_bg_color}' ) );

foreach ( $wpbf_devices as $wpbf_device => $wpbf_media ) {
	wpbf_css(
		'.wpbf-sidebar .widget, .elementor-widget-sidebar .widget',
		array(
			'padding-top'    => '{sidebar_widget_padding.' . $wpbf_device . '_top}px',
			'padding-right'  => '{sidebar_widget_padding.' . $wpbf_device . '_right}px',
			'padding-bottom' => '{sidebar_widget_padding.' . $wpbf_device . '_bottom}px',
			'padding-left'   => '{sidebar_widget_padding.' . $wpbf_device . '_left}px',
		),
		array( 'media' => $wpbf_media )
	);
}

wpbf_css( 'body:not(.wpbf-no-sidebar) .wpbf-sidebar-wrapper.wpbf-medium-1-3', array( 'width' => '{sidebar_width}%' ), array( 'media' => 'min-medium' ) );
wpbf_css( 'body:not(.wpbf-no-sidebar) .wpbf-main.wpbf-medium-2-3', array( 'width' => 'calc(100% - {sidebar_width}%)' ), array( 'media' => 'min-medium' ) );

// Breadcrumbs.
wpbf_css( '.wpbf-breadcrumbs-container', array( 'text-align' => '{breadcrumbs_alignment}' ) );
wpbf_css( '.wpbf-breadcrumbs-container', array( 'background' => '{breadcrumbs_background_color}' ) );
wpbf_css( '.wpbf-breadcrumbs', array( 'color' => '{breadcrumbs_font_color}' ) );
wpbf_css( '.wpbf-breadcrumbs a', array( 'color' => '{breadcrumbs_accent_color}' ) );
wpbf_css( '.wpbf-breadcrumbs a:hover', array( 'color' => '{breadcrumbs_accent_color_alt}' ) );
