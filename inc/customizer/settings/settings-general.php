<?php
/**
 * General customizer settings.
 *
 * @package    Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Panel */

// General.
wpbf_customizer_panel()
	->id( 'layout_panel' )
	->title( __( 'General', 'page-builder-framework' ) )
	->priority( 2 )
	->add();

/* Sections */

// Layout.
wpbf_customizer_section()
	->id( 'wpbf_page_options' )
	->title( __( 'Layout', 'page-builder-framework' ) )
	->priority( 100 )
	->addToPanel( 'layout_panel' );

// Sidebar.
wpbf_customizer_section()
	->id( 'wpbf_sidebar_options' )
	->title( __( 'Sidebar', 'page-builder-framework' ) )
	->priority( 300 )
	->addToPanel( 'layout_panel' );

// 404.
wpbf_customizer_section()
	->id( 'wpbf_404_options' )
	->title( __( '404 Page', 'page-builder-framework' ) )
	->priority( 400 )
	->addToPanel( 'layout_panel' );

// Breadcrumbs.
wpbf_customizer_section()
	->id( 'wpbf_breadcrumb_settings' )
	->title( __( 'Breadcrumbs', 'page-builder-framework' ) )
	->priority( 500 )
	->addToPanel( 'layout_panel' );

// Buttons.
wpbf_customizer_section()
	->id( 'wpbf_button_options' )
	->title( __( 'Theme Buttons', 'page-builder-framework' ) )
	->priority( 600 )
	->addToPanel( 'layout_panel' );

// ScrollTop.
wpbf_customizer_section()
	->id( 'wpbf_scrolltop_options' )
	->title( __( 'Scroll to Top Button', 'page-builder-framework' ) )
	->priority( 700 )
	->addToPanel( 'layout_panel' );

/* Fields - Layout */

// Max width.
wpbf_customizer_field()
	->id( 'page_max_width' )
	->label( __( 'Page Width', 'page-builder-framework' ) )
	->description( __( 'Default: 1200px', 'page-builder-framework' ) )
	->priority( 0 )
	->transport( 'postMessage' )
	->addToSection( 'wpbf_page_options' );

// Padding.
wpbf_customizer_field()
	->id( 'page_padding' )
	->label( __( 'Page Padding', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( [
		'dont_save_unit' => true,
	] )
	->addToSection( 'wpbf_page_options' );

// Boxed.
wpbf_customizer_field()
	->id( 'page_boxed' )
	->label( __( 'Boxed Layout', 'page-builder-framework' ) )
	->priority( 2 )
	->addToSection( 'wpbf_page_options' );

// Boxed margin.
wpbf_customizer_field()
	->id( 'page_boxed_margin' )
	->label( __( 'Margin', 'page-builder-framework' ) )
	->priority( 3 )
	->transport( 'postMessage' )
	->properties( array(
		'min'  => 0,
		'max'  => 80,
		'step' => 1,
	) )
	->activeCallback( [
		array(
			'id'       => 'page_boxed',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_page_options' );

// Boxed padding.
wpbf_customizer_field()
	->id( 'page_boxed_padding' )
	->label( __( 'Padding', 'page-builder-framework' ) )
	->priority( 4 )
	->transport( 'postMessage' )
	->properties( array(
		'min'  => 20,
		'max'  => 100,
		'step' => 1,
	) )
	->activeCallback( [
		array(
			'id'       => 'page_boxed',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_page_options' );

// Background color.
wpbf_customizer_field()
	->id( 'page_boxed_background' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->priority( 5 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'page_boxed',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_page_options' );

// Box shadow.
wpbf_customizer_field()
	->id( 'page_boxed_box_shadow' )
	->transport( 'postMessage' )
	->label( __( 'Box Shadow', 'page-builder-framework' ) )
	->priority( 6 )
	->activeCallback( [
		array(
			'id'       => 'page_boxed',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_page_options' );

// Box shadow blur.
wpbf_customizer_field()
	->id( 'page_boxed_box_shadow_blur' )
	->transport( 'postMessage' )
	->label( __( 'Blur', 'page-builder-framework' ) )
	->priority( 7 )
	->properties( array(
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	) )
	->activeCallback( [
		array(
			'id'       => 'page_boxed',
			'operator' => '==',
			'value'    => true,
		),
		array(
			'id'       => 'page_boxed_box_shadow',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_page_options' );

// Box shadow spread.
wpbf_customizer_field()
	->id( 'page_boxed_box_shadow_spread' )
	->transport( 'postMessage' )
	->label( __( 'Spread', 'page-builder-framework' ) )
	->priority( 8 )
	->properties( array(
		'min'  => - 100,
		'max'  => 100,
		'step' => 1,
	) )
	->activeCallback( [
		array(
			'id'       => 'page_boxed',
			'operator' => '==',
			'value'    => true,
		),
		array(
			'id'       => 'page_boxed_box_shadow',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_page_options' );

// Box shadow horizontal.
wpbf_customizer_field()
	->id( 'page_boxed_box_shadow_horizontal' )
	->transport( 'postMessage' )
	->label( __( 'Horizontal', 'page-builder-framework' ) )
	->priority( 9 )
	->properties( array(
		'min'  => - 100,
		'max'  => 100,
		'step' => 1,
	) )
	->activeCallback( [
		array(
			'id'       => 'page_boxed',
			'operator' => '==',
			'value'    => true,
		),
		array(
			'id'       => 'page_boxed_box_shadow',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_page_options' );

// Box shadow vertical.
wpbf_customizer_field()
	->id( 'page_boxed_box_shadow_vertical' )
	->transport( 'postMessage' )
	->label( __( 'Vertical', 'page-builder-framework' ) )
	->priority( 10 )
	->properties( array(
		'min'  => - 100,
		'max'  => 100,
		'step' => 1,
	) )
	->activeCallback( [
		array(
			'id'       => 'page_boxed',
			'operator' => '==',
			'value'    => true,
		),
		array(
			'id'       => 'page_boxed_box_shadow',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_page_options' );

// Box shadow color.
wpbf_customizer_field()
	->id( 'page_boxed_box_shadow_color' )
	->label( __( 'Color', 'page-builder-framework' ) )
	->priority( 11 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'page_boxed',
			'operator' => '==',
			'value'    => true,
		),
		array(
			'id'       => 'page_boxed_box_shadow',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_page_options' );

/* Fields - Background */

// Background color.
/**
 * The idea was to replace the old WordPress color picker with our new interface.
 * But it doesn't work as expected.
wpbf_customizer_field()
	->id( 'background_color' )
	->type( 'color' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->defaultValue( '#ffffff' )
	->priority( 100 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'background_image' );
*/

/* Fields - Sidebar */

wpbf_customizer_field()
	->id( 'sidebar_position' )
	->label( __( 'Position (Global)', 'page-builder-framework' ) )
	->priority( 1 )
	->choices( array(
		'right' => __( 'Right', 'page-builder-framework' ),
		'left'  => __( 'Left', 'page-builder-framework' ),
		'none'  => __( 'No Sidebar', 'page-builder-framework' ),
	) )
	->addToSection( 'wpbf_sidebar_options' );

wpbf_customizer_field()
	->id( 'sidebar_gap' )
	->label( __( 'Gap', 'page-builder-framework' ) )
	->priority( 2 )
	->choices( array(
		'divider'  => __( 'Divider', 'page-builder-framework' ),
		'xlarge'   => __( 'xLarge', 'page-builder-framework' ),
		'large'    => __( 'Large', 'page-builder-framework' ),
		'medium'   => __( 'Medium', 'page-builder-framework' ),
		'small'    => __( 'Small', 'page-builder-framework' ),
		'collapse' => __( 'Collapse', 'page-builder-framework' ),
	) )
	->addToSection( 'wpbf_sidebar_options' );

wpbf_customizer_field()
	->id( 'sidebar_width' )
	->transport( 'postMessage' )
	->label( __( 'Width', 'page-builder-framework' ) )
	->priority( 2 )
	->properties( array(
		'min'  => 20,
		'max'  => 40,
		'step' => 0.1,
	) )
	->activeCallback( [
		array(
			'id'       => 'sidebar_position',
			'operator' => '!=',
			'value'    => 'none',
		),
	] )
	->addToSection( 'wpbf_sidebar_options' );

// Headline.
wpbf_customizer_field()
	->id( 'widget_headline' )
	->type( 'headline' )
	->label( __( 'Sidebar Widgets', 'page-builder-framework' ) )
	->priority( 2 )
	->addToSection( 'wpbf_sidebar_options' );

// Padding.
wpbf_customizer_field()
	->id( 'sidebar_widget_padding' )
	->transport( 'postMessage' )
	->label( __( 'Padding', 'page-builder-framework' ) )
	->priority( 3 )
	->properties( [
		'dont_save_unit' => true,
	] )
	->addToSection( 'wpbf_sidebar_options' );

// Color.
wpbf_customizer_field()
	->id( 'sidebar_bg_color' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->priority( 4 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_sidebar_options' );

/* Fields - 404 Page */

// 404 title.
wpbf_customizer_field()
	->id( '404_headline' )
	->label( __( 'Title', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->addToSection( 'wpbf_404_options' );

// 404 text.
wpbf_customizer_field()
	->id( '404_text' )
	->label( __( 'Text', 'page-builder-framework' ) )
	->priority( 2 )
	->transport( 'postMessage' )
	->addToSection( 'wpbf_404_options' );

// Search form.
wpbf_customizer_field()
	->id( '404_search_form' )
	->label( __( 'Search Form', 'page-builder-framework' ) )
	->priority( 3 )
	->choices( array(
		'show' => __( 'Show', 'page-builder-framework' ),
		'hide' => __( 'Hide', 'page-builder-framework' ),
	) )
	->partialRefresh( [
		'404searchform' => array(
			'container_inclusive' => true,
			'selector'            => '.wpbf-404-content #searchform',
			'render_callback'     => function () {
				return get_search_form();
			},
		),
	] )
	->addToSection( 'wpbf_404_options' );

/* Fields - Breadcrumb Settings */

// Toggle.
wpbf_customizer_field()
	->id( 'breadcrumbs_toggle' )
	->label( __( 'Breadcrumbs', 'page-builder-framework' ) )
	->priority( 1 )
	->addToSection( 'wpbf_breadcrumb_settings' );

// Separator.
wpbf_customizer_field()
	->id( 'breadcrumbs_toggle_separator' )
	->type( 'divider' )
	->priority( 1 )
	->activeCallback( [
		array(
			'id'       => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

// Breadcrumbs.
wpbf_customizer_field()
	->id( 'breadcrumbs' )
	->label( __( 'Display Breadcrumbs on', 'page-builder-framework' ) )
	->priority( 2 )
	->choices( array(
		'front_page' => __( 'Front Page', 'page-builder-framework' ),
		'archive'    => __( 'Archives', 'page-builder-framework' ),
		'single'     => __( 'Single', 'page-builder-framework' ),
		'search'     => __( 'Search Page', 'page-builder-framework' ),
		'404'        => __( '404 Page', 'page-builder-framework' ),
		'page'       => __( 'Pages', 'page-builder-framework' ),
	) )
	->properties( array(
		'multiple'       => true,
		'max_selections' => 6,
	) )
	->activeCallback( [
		array(
			'id'       => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => 1,
		),
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

// Position.
wpbf_customizer_field()
	->id( 'breadcrumbs_position' )
	->label( __( 'Position', 'page-builder-framework' ) )
	->priority( 2 )
	->choices( array(
		'content' => __( 'Before Content', 'page-builder-framework' ),
		'header'  => __( 'Below Header', 'page-builder-framework' ),
	) )
	->activeCallback( [
		array(
			'id'       => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => 1,
		),
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

// Separator.
wpbf_customizer_field()
	->id( 'breadcrumbs_separator' )
	->label( __( 'Separator', 'page-builder-framework' ) )
	->priority( 2 )
	->activeCallback( [
		array(
			'id'       => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->partialRefresh( [
		'breadcrumbs_separator' => array(
			'container_inclusive' => true,
			'selector'            => '.wpbf-breadcrumbs',
			'render_callback'     => function () {
				return wpbf_do_breadcrumbs();
			},
		),
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

// Alignment.
wpbf_customizer_field()
	->id( 'breadcrumbs_alignment' )
	->transport( 'postMessage' )
	->label( __( 'Alignment', 'page-builder-framework' ) )
	->priority( 2 )
	->choices( array(
		'left'   => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'center' => WPBF_THEME_URI . '/inc/customizer/img/align-center.jpg',
		'right'  => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	) )
	->activeCallback( [
		array(
			'id'       => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => true,
		),
		array(
			'id'       => 'breadcrumbs_position',
			'operator' => '==',
			'value'    => 'header',
		),
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

// Headline.
wpbf_customizer_field()
	->id( 'breadcrumbs_color_divider' )
	->type( 'divider' )
	->priority( 2 )
	->activeCallback( [
		[
			'id'       => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => true,
		],
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

wpbf_customizer_field()
	->id( 'breadcrumbs_background_color' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->priority( 2 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		[
			'id'       => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => 1,
		],
		[
			'id'       => 'breadcrumbs_position',
			'operator' => '==',
			'value'    => 'header',
		],
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );


// Font color.
wpbf_customizer_field()
	->id( 'breadcrumbs_font_color' )
	->label( __( 'Font Color', 'page-builder-framework' ) )
	->priority( 2 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

// Accent color.
wpbf_customizer_field()
	->id( 'breadcrumbs_accent_color' )
	->label( __( 'Accent Color', 'page-builder-framework' ) )
	->priority( 2 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

// Accent color hover.
wpbf_customizer_field()
	->id( 'breadcrumbs_accent_color_alt' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 2 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'breadcrumbs_toggle',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_breadcrumb_settings' );

/* Fields - Buttons */

// Headline.
wpbf_customizer_field()
	->id( 'button_headline' )
	->type( 'headline' )
	->label( __( 'Theme Buttons', 'page-builder-framework' ) )
	->tooltip( __( 'Applies to default buttons such as "Read more" used throughout the theme.', 'page-builder-framework' ) )
	->priority( 0 )
	->addToSection( 'wpbf_button_options' );

// Background color.
wpbf_customizer_field()
	->id( 'button_bg_color' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_button_options' );

// Background color alt.
wpbf_customizer_field()
	->id( 'button_bg_color_alt' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_button_options' );

// Text color.
wpbf_customizer_field()
	->id( 'button_text_color' )
	->label( __( 'Font Color', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_button_options' );

// Text color alt.
wpbf_customizer_field()
	->id( 'button_text_color_alt' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_button_options' );

// Headline.
wpbf_customizer_field()
	->id( 'button_primary_headline' )
	->type( 'headline' )
	->label( __( 'Theme Buttons (Primary)', 'page-builder-framework' ) )
	->tooltip( __( 'Applies to buttons displayed in the themes accent color such as WooCommerce buttons.', 'page-builder-framework' ) )
	->priority( 1 )
	->addToSection( 'wpbf_button_options' );

// Primary background color.
wpbf_customizer_field()
	->id( 'button_primary_bg_color' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_button_options' );

// Primary background color alt.
wpbf_customizer_field()
	->id( 'button_primary_bg_color_alt' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_button_options' );

// Primary text color.
wpbf_customizer_field()
	->id( 'button_primary_text_color' )
	->label( __( 'Primary Font Color', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_button_options' );

// Primary text color alt.
wpbf_customizer_field()
	->id( 'button_primary_text_color_alt' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->addToSection( 'wpbf_button_options' );

// Divider.
wpbf_customizer_field()
	->id( 'button_border_divider' )
	->type( 'divider' )
	->priority( 1 )
	->addToSection( 'wpbf_button_options' );

// Border radius.
wpbf_customizer_field()
	->id( 'button_border_radius' )
	->label( __( 'Border Radius', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	) )
	->addToSection( 'wpbf_button_options' );

// Border width.
wpbf_customizer_field()
	->id( 'button_border_width' )
	->label( __( 'Border Width', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'min'  => 0,
		'max'  => 10,
		'step' => 1,
	) )
	->addToSection( 'wpbf_button_options' );

// Divider.
wpbf_customizer_field()
	->id( 'button_border_divider_2' )
	->type( 'divider' )
	->priority( 1 )
	->activeCallback( [
		array(
			'id'       => 'button_border_width',
			'operator' => '!=',
			'value'    => 0,
		),
	] )
	->addToSection( 'wpbf_button_options' );

// Border color.
wpbf_customizer_field()
	->id( 'button_border_color' )
	->label( __( 'Border Color', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'button_border_width',
			'operator' => '!=',
			'value'    => 0,
		),
	] )
	->addToSection( 'wpbf_button_options' );

// Border color alt.
wpbf_customizer_field()
	->id( 'button_border_color_alt' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'button_border_width',
			'operator' => '!=',
			'value'    => 0,
		),
	] )
	->addToSection( 'wpbf_button_options' );

// Primary border color.
wpbf_customizer_field()
	->id( 'button_primary_border_color' )
	->label( __( 'Primary Border Color', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'button_border_width',
			'operator' => '!=',
			'value'    => 0,
		),
	] )
	->addToSection( 'wpbf_button_options' );

// Primary border color alt.
wpbf_customizer_field()
	->id( 'button_primary_border_color_alt' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'button_border_width',
			'operator' => '!=',
			'value'    => 0,
		),
	] )
	->addToSection( 'wpbf_button_options' );

/* Fields - ScrollTop */

// Toggle.
wpbf_customizer_field()
	->id( 'layout_scrolltop' )
	->label( __( 'Scroll to Top Button', 'page-builder-framework' ) )
	->priority( 0 )
	->addToSection( 'wpbf_scrolltop_options' );

// Separator.
wpbf_customizer_field()
	->id( 'layout_scrolltop_separator' )
	->type( 'divider' )
	->priority( 0 )
	->activeCallback( [
		array(
			'id'       => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );

// Alignment.
wpbf_customizer_field()
	->id( 'scrolltop_position' )
	->label( __( 'Alignment', 'page-builder-framework' ) )
	->priority( 1 )
	->transport( 'postMessage' )
	->choices( array(
		'left'  => WPBF_THEME_URI . '/inc/customizer/img/align-left.jpg',
		'right' => WPBF_THEME_URI . '/inc/customizer/img/align-right.jpg',
	) )
	->activeCallback( [
		array(
			'id'       => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );

// Show after.
wpbf_customizer_field()
	->id( 'scrolltop_value' )
	->label( __( 'Show after (px)', 'page-builder-framework' ) )
	->priority( 2 )
	->properties( array(
		'min'  => 50,
		'max'  => 1000,
		'step' => 1,
	) )
	->activeCallback( [
		array(
			'id'       => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );

// Divider.
wpbf_customizer_field()
	->id( 'layout_scrolltop_separator_2' )
	->type( 'divider' )
	->priority( 3 )
	->activeCallback( [
		array(
			'id'       => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );

// Background color.
wpbf_customizer_field()
	->id( 'scrolltop_bg_color' )
	->label( __( 'Background Color', 'page-builder-framework' ) )
	->priority( 4 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );

// Background color hover.
wpbf_customizer_field()
	->id( 'scrolltop_bg_color_alt' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 5 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );


// Icon color.
wpbf_customizer_field()
	->id( 'scrolltop_icon_color' )
	->label( __( 'Icon Color', 'page-builder-framework' ) )
	->priority( 6 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );

// Icon color hover.
wpbf_customizer_field()
	->id( 'scrolltop_icon_color_alt' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->priority( 7 )
	->transport( 'postMessage' )
	->properties( array(
		'mode' => 'alpha',
	) )
	->activeCallback( [
		array(
			'id'       => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );

// Border radius.
wpbf_customizer_field()
	->id( 'scrolltop_border_radius' )
	->transport( 'postMessage' )
	->label( __( 'Border Radius', 'page-builder-framework' ) )
	->priority( 8 )
	->properties( array(
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	) )
	->activeCallback( [
		array(
			'id'       => 'layout_scrolltop',
			'operator' => '==',
			'value'    => true,
		),
	] )
	->addToSection( 'wpbf_scrolltop_options' );
