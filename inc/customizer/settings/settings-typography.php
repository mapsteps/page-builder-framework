<?php
/**
 * Typography customizer settings.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/* Panel */

// Typography.
wpbf_customizer_panel()
	->id( 'typo_panel' )
	->title( __( 'Typography', 'page-builder-framework' ) )
	->priority( 3 )
	->add();

/* Sections */

// Title & tagline.
wpbf_customizer_section()
	->id( 'wpbf_title_tagline_options' )
	->title( __( 'Site Title / Tagline', 'page-builder-framework' ) )
	->priority( 0 )
	->addToPanel( 'typo_panel' );

// Menu.
wpbf_customizer_section()
	->id( 'wpbf_menu_font_options' )
	->title( __( 'Navigation', 'page-builder-framework' ) )
	->priority( 50 )
	->addToPanel( 'typo_panel' );

// Sub Menu.
wpbf_customizer_section()
	->id( 'wpbf_sub_menu_font_options' )
	->title( __( 'Sub Menu', 'page-builder-framework' ) )
	->priority( 75 )
	->addToPanel( 'typo_panel' );

// Text.
wpbf_customizer_section()
	->id( 'wpbf_font_options' )
	->title( __( 'Text', 'page-builder-framework' ) )
	->priority( 100 )
	->addToPanel( 'typo_panel' );

// H1.
wpbf_customizer_section()
	->id( 'wpbf_h1_options' )
	->title( __( 'H1', 'page-builder-framework' ) )
	->priority( 200 )
	->addToPanel( 'typo_panel' );

// H2.
wpbf_customizer_section()
	->id( 'wpbf_h2_options' )
	->title( __( 'H2', 'page-builder-framework' ) )
	->priority( 300 )
	->addToPanel( 'typo_panel' );

// H3.
wpbf_customizer_section()
	->id( 'wpbf_h3_options' )
	->title( __( 'H3', 'page-builder-framework' ) )
	->priority( 400 )
	->addToPanel( 'typo_panel' );

// H4.
wpbf_customizer_section()
	->id( 'wpbf_h4_options' )
	->title( __( 'H4', 'page-builder-framework' ) )
	->priority( 500 )
	->addToPanel( 'typo_panel' );

// H5.
wpbf_customizer_section()
	->id( 'wpbf_h5_options' )
	->title( __( 'H5', 'page-builder-framework' ) )
	->priority( 600 )
	->addToPanel( 'typo_panel' );

// H6.
wpbf_customizer_section()
	->id( 'wpbf_h6_options' )
	->title( __( 'H6', 'page-builder-framework' ) )
	->priority( 700 )
	->addToPanel( 'typo_panel' );

// Footer.
wpbf_customizer_section()
	->id( 'wpbf_footer_font_options' )
	->title( __( 'Footer', 'page-builder-framework' ) )
	->priority( 800 )
	->addToPanel( 'typo_panel' );

/* Fields - Text */

// Text font toggle.
wpbf_customizer_field()
	->id( 'page_font_toggle' )
	->type( 'toggle' )
	->label( __( 'Font Settings', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 0 )
	->addToSection( 'wpbf_font_options' );

// Font family.
wpbf_customizer_field()
	->id( 'page_font_family' )
	->type( 'typography' )
	->defaultValue( array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => 'regular',
	) )
	->priority( 1 )
	->activeCallback( array(
		array(
			'id'       => 'page_font_toggle',
			'operator' => '==',
			'value'    => true,
		),
	) )
	->properties( wpbf_default_font_choices() )
	->addToSection( 'wpbf_font_options' );

// Separator.
wpbf_customizer_field()
	->id( 'page_font_toggle_separator' )
	->type( 'divider' )
	->priority( 1 )
	->addToSection( 'wpbf_font_options' );

// Color.
wpbf_customizer_field()
	->id( 'page_font_color' )
	->type( 'color' )
	->label( __( 'Color', 'page-builder-framework' ) )
	->defaultValue( '#6d7680' )
	->priority( 2 )
	->transport( 'postMessage' )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_font_options' );

// Accent color.
wpbf_customizer_field()
	->id( 'page_accent_color' )
	->type( 'color' )
	->label( __( 'Accent Color', 'page-builder-framework' ) )
	->defaultValue( '#3ba9d2' )
	->priority( 4 )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_font_options' );

// Accent color alt.
wpbf_customizer_field()
	->id( 'page_accent_color_alt' )
	->type( 'color' )
	->label( __( 'Hover', 'page-builder-framework' ) )
	->defaultValue( '#79c4e0' )
	->priority( 4 )
	->properties( [
		'mode' => 'alpha',
	] )
	->addToSection( 'wpbf_font_options' );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	wpbf_customizer_field()
		->id( 'wpbf_premium_ad_typography_text' )
		->type( 'custom' )
		->defaultValue( '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link )
		->priority( 9999 )
		->addToSection( 'wpbf_font_options' );

}

/* Fields - Title & tagline */

// Title font toggle.
wpbf_customizer_field()
	->id( 'menu_logo_font_toggle' )
	->type( 'toggle' )
	->label( __( 'Title - Font Settings', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 0 )
	->addToSection( 'wpbf_title_tagline_options' );

// Font family.
wpbf_customizer_field()
	->id( 'menu_logo_font_family' )
	->type( 'typography' )
	->label( __( 'Font Family', 'page-builder-framework' ) )
	->defaultValue( array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
		'subsets'     => array( 'latin-ext' ),
	) )
	->properties( wpbf_default_font_choices() )
	->priority( 1 )
	->activeCallback( array(
		array(
			'id'       => 'menu_logo_font_toggle',
			'operator' => '==',
			'value'    => true,
		),
	) )
	->addToSection( 'wpbf_title_tagline_options' );

// Divider.
wpbf_customizer_field()
	->id( 'menu_logo_tagline_divider' )
	->type( 'divider' )
	->priority( 2 )
	->addToSection( 'wpbf_title_tagline_options' );

// Title font toggle.
wpbf_customizer_field()
	->id( 'menu_logo_description_toggle' )
	->type( 'toggle' )
	->label( esc_html__( 'Tagline - Font Settings', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 3 )
	->addToSection( 'wpbf_title_tagline_options' );

// Font family.
wpbf_customizer_field()
	->id( 'menu_logo_description_font_family' )
	->type( 'typography' )
	->label( __( 'Font Family', 'page-builder-framework' ) )
	->defaultValue( array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
		'subsets'     => array( 'latin-ext' ),
	) )
	->properties( wpbf_default_font_choices() )
	->priority( 4 )
	->activeCallback( array(
		array(
			'id'       => 'menu_logo_description_toggle',
			'operator' => '==',
			'value'    => true,
		),
	) )
	->addToSection( 'wpbf_title_tagline_options' );


/* Fields - Menu */

// Menu font toggle.
wpbf_customizer_field()
	->id( 'menu_font_family_toggle' )
	->type( 'toggle' )
	->label( __( 'Font Settings', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 0 )
	->addToSection( 'wpbf_menu_font_options' );

// Font family.
wpbf_customizer_field()
	->id( 'menu_font_family' )
	->type( 'typography' )
	->label( __( 'Font Family', 'page-builder-framework' ) )
	->defaultValue( array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => 'regular',
	) )
	->properties( wpbf_default_font_choices() )
	->priority( 1 )
	->activeCallback( array(
		array(
			'id'       => 'menu_font_family_toggle',
			'operator' => '==',
			'value'    => true,
		),
	) )
	->addToSection( 'wpbf_menu_font_options' );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	wpbf_customizer_field()
		->id( 'wpbf_premium_ad_typography_menu' )
		->type( 'custom' )
		->defaultValue( '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link )
		->priority( 9999 )
		->addToSection( 'wpbf_menu_font_options' );

}

/* Fields - Sub Menu */

// Sub Menu font toggle.
wpbf_customizer_field()
	->id( 'sub_menu_font_family_toggle' )
	->type( 'toggle' )
	->label( __( 'Font Settings', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 0 )
	->addToSection( 'wpbf_sub_menu_font_options' );

// Font family.
wpbf_customizer_field()
	->id( 'sub_menu_font_family' )
	->type( 'typography' )
	->label( __( 'Font Family', 'page-builder-framework' ) )
	->defaultValue( array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => 'regular',
	) )
	->properties( wpbf_default_font_choices() )
	->priority( 1 )
	->activeCallback( array(
		array(
			'id'       => 'sub_menu_font_family_toggle',
			'operator' => '==',
			'value'    => true,
		),
	) )
	->addToSection( 'wpbf_sub_menu_font_options' );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	wpbf_customizer_field()
		->id( 'wpbf_premium_ad_typography_sub_menu' )
		->type( 'custom' )
		->defaultValue( '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link )
		->priority( 9999 )
		->addToSection( 'wpbf_sub_menu_font_options' );

}

/* Fields - H1 */

// Toggle.
wpbf_customizer_field()
	->id( 'page_h1_toggle' )
	->type( 'toggle' )
	->label( __( 'Font Settings', 'page-builder-framework' ) )
	->description( __( 'The settings below will apply to all headlines if not configured individually.', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 0 )
	->addToSection( 'wpbf_h1_options' );

// Font family.
wpbf_customizer_field()
	->id( 'page_h1_font_family' )
	->type( 'typography' )
	->label( __( 'Font Family', 'page-builder-framework' ) )
	->defaultValue( array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
	) )
	->properties( wpbf_default_font_choices() )
	->priority( 1 )
	->activeCallback( array(
		array(
			'id'       => 'page_h1_toggle',
			'operator' => '==',
			'value'    => true,
		),
	) )
	->addToSection( 'wpbf_h1_options' );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	wpbf_customizer_field()
		->id( 'wpbf_premium_ad_typography_h1' )
		->type( 'custom' )
		->defaultValue( '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link )
		->priority( 9999 )
		->addToSection( 'wpbf_h1_options' );

}

/* Fields - H2 */

// Toggle.
wpbf_customizer_field()
	->id( 'page_h2_toggle' )
	->type( 'toggle' )
	->label( __( 'Font Settings', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 0 )
	->addToSection( 'wpbf_h2_options' );

// Font family.
wpbf_customizer_field()
	->id( 'page_h2_font_family' )
	->type( 'typography' )
	->label( __( 'Font Family', 'page-builder-framework' ) )
	->defaultValue( array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
	) )
	->properties( wpbf_default_font_choices() )
	->priority( 1 )
	->activeCallback( array(
		array(
			'id'       => 'page_h2_toggle',
			'operator' => '==',
			'value'    => true,
		),
	) )
	->addToSection( 'wpbf_h2_options' );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	wpbf_customizer_field()
		->id( 'wpbf_premium_ad_typography_h2' )
		->type( 'custom' )
		->defaultValue( '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link )
		->priority( 9999 )
		->addToSection( 'wpbf_h2_options' );

}

/* Fields - H3 */

// Toggle.
wpbf_customizer_field()
	->id( 'page_h3_toggle' )
	->type( 'toggle' )
	->label( __( 'Font Settings', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 0 )
	->addToSection( 'wpbf_h3_options' );

// Font family.
wpbf_customizer_field()
	->id( 'page_h3_font_family' )
	->type( 'typography' )
	->label( __( 'Font Family', 'page-builder-framework' ) )
	->defaultValue( array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
	) )
	->properties( wpbf_default_font_choices() )
	->priority( 1 )
	->activeCallback( array(
		array(
			'id'       => 'page_h3_toggle',
			'operator' => '==',
			'value'    => true,
		),
	) )
	->addToSection( 'wpbf_h3_options' );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	wpbf_customizer_field()
		->id( 'wpbf_premium_ad_typography_h3' )
		->type( 'custom' )
		->defaultValue( '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link )
		->priority( 9999 )
		->addToSection( 'wpbf_h3_options' );

}

/* Fields - H4 */

// Toggle.
wpbf_customizer_field()
	->id( 'page_h4_toggle' )
	->type( 'toggle' )
	->label( __( 'Font Settings', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 0 )
	->addToSection( 'wpbf_h4_options' );

// Font family.
wpbf_customizer_field()
	->id( 'page_h4_font_family' )
	->type( 'typography' )
	->label( __( 'Font Family', 'page-builder-framework' ) )
	->defaultValue( array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
	) )
	->properties( wpbf_default_font_choices() )
	->priority( 1 )
	->activeCallback( array(
		array(
			'id'       => 'page_h4_toggle',
			'operator' => '==',
			'value'    => true,
		),
	) )
	->addToSection( 'wpbf_h4_options' );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	wpbf_customizer_field()
		->id( 'wpbf_premium_ad_typography_h4' )
		->type( 'custom' )
		->defaultValue( '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link )
		->priority( 9999 )
		->addToSection( 'wpbf_h4_options' );

}

/* Fields - H5 */

// Toggle.
wpbf_customizer_field()
	->id( 'page_h5_toggle' )
	->type( 'toggle' )
	->label( __( 'Font Settings', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 0 )
	->addToSection( 'wpbf_h5_options' );

// Font family.
wpbf_customizer_field()
	->id( 'page_h5_font_family' )
	->type( 'typography' )
	->label( __( 'Font Family', 'page-builder-framework' ) )
	->defaultValue( array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
	) )
	->properties( wpbf_default_font_choices() )
	->activeCallback( array(
		array(
			'id'       => 'page_h5_toggle',
			'operator' => '==',
			'value'    => true,
		),
	) )
	->priority( 1 )
	->addToSection( 'wpbf_h5_options' );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	wpbf_customizer_field()
		->id( 'wpbf_premium_ad_typography_h5' )
		->type( 'custom' )
		->defaultValue( '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link )
		->priority( 9999 )
		->addToSection( 'wpbf_h5_options' );

}

/* Fields - H6 */

// Toggle.
wpbf_customizer_field()
	->id( 'page_h6_toggle' )
	->type( 'toggle' )
	->label( __( 'Font Settings', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 0 )
	->addToSection( 'wpbf_h6_options' );

// Font family.
wpbf_customizer_field()
	->id( 'page_h6_font_family' )
	->type( 'typography' )
	->label( __( 'Font Family', 'page-builder-framework' ) )
	->defaultValue( array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => '700',
	) )
	->properties( wpbf_default_font_choices() )
	->priority( 1 )
	->activeCallback( array(
		array(
			'id'       => 'page_h6_toggle',
			'operator' => '==',
			'value'    => true,
		),
	) )
	->addToSection( 'wpbf_h6_options' );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	wpbf_customizer_field()
		->id( 'wpbf_premium_ad_typography_h6' )
		->type( 'custom' )
		->defaultValue( '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link )
		->priority( 9999 )
		->addToSection( 'wpbf_h6_options' );

}

/* Fields - Footer */

// Toggle.
wpbf_customizer_field()
	->id( 'footer_font_toggle' )
	->type( 'toggle' )
	->label( __( 'Font Settings', 'page-builder-framework' ) )
	->defaultValue( false )
	->priority( 0 )
	->addToSection( 'wpbf_footer_font_options' );

// Font family.
wpbf_customizer_field()
	->id( 'footer_font_family' )
	->type( 'typography' )
	->label( __( 'Font Family', 'page-builder-framework' ) )
	->defaultValue( array(
		'font-family' => 'Helvetica, Arial, sans-serif',
		'variant'     => 'regular',
	) )
	->properties( wpbf_default_font_choices() )
	->priority( 1 )
	->activeCallback( array(
		array(
			'id'       => 'footer_font_toggle',
			'operator' => '==',
			'value'    => true,
		),
	) )
	->addToSection( 'wpbf_footer_font_options' );

if ( ! wpbf_is_premium() ) {

	// Premium notice.
	$wpbf_premium_ad_link = sprintf(
		'%1$s. <a href="https://wp-pagebuilderframework.com/docs-category/typography/?utm_source=repository&utm_medium=customizer_typography_panel&utm_campaign=wpbf" target="_blank">%2$s</a>',
		__( 'Premium Features available', 'page-builder-framework' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	wpbf_customizer_field()
		->id( 'wpbf_premium_ad_typography_footer' )
		->type( 'custom' )
		->defaultValue( '<hr style="border-top: 1px solid #ccc; border-bottom: 1px solid #f8f8f8">' . $wpbf_premium_ad_link )
		->priority( 9999 )
		->addToSection( 'wpbf_footer_font_options' );

}
