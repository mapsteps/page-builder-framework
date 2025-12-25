<?php
/**
 * Typography headings fields (H1-H6).
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

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
	->properties( wpbf_typography_field_properties() )
	->priority( 1 )
	->activeCallback( array(
		array(
			'setting'  => 'page_h1_toggle',
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
	->properties( wpbf_typography_field_properties() )
	->priority( 1 )
	->activeCallback( array(
		array(
			'setting'  => 'page_h2_toggle',
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
	->properties( wpbf_typography_field_properties() )
	->priority( 1 )
	->activeCallback( array(
		array(
			'setting'  => 'page_h3_toggle',
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
	->properties( wpbf_typography_field_properties() )
	->priority( 1 )
	->activeCallback( array(
		array(
			'setting'  => 'page_h4_toggle',
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
	->properties( wpbf_typography_field_properties() )
	->activeCallback( array(
		array(
			'setting'  => 'page_h5_toggle',
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
	->properties( wpbf_typography_field_properties() )
	->priority( 1 )
	->activeCallback( array(
		array(
			'setting'  => 'page_h6_toggle',
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
