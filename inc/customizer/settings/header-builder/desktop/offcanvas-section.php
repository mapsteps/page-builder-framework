<?php
/**
 * Header builder's desktop offcanvas section.
 *
 * @package Page Builder Framework
 * @subpackage Customizer
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$row_key = 'desktop_offcanvas';

$section_id = 'wpbf_header_builder_' . $row_key . '_section';

wpbf_customizer_section()
	->id( $section_id )
	->type( 'invisible' )
	->title( __( 'Desktop Off-Canvas', 'page-builder-framework' ) )
	->tabs( [
		'general' => [
			'label' => esc_html__( 'General', 'page-builder-framework' ),
		],
		'design'  => [
			'label' => esc_html__( 'Design', 'page-builder-framework' ),
		],
	] )
	->priority( 3 )
	->addToPanel( 'header_panel' );

$control_id_prefix = 'wpbf_header_builder_' . $row_key . '_';

$partial_refresh_key_prefix = 'headerbuilder_' . $row_key . '_';

$partial_refresh_args = array(
	'container_inclusive' => true,
	'selector'            => '#header',
	'render_callback'     => function () {
		return get_template_part( 'inc/template-parts/header' );
	},
);

// Desktop Off-Canvas is a premium feature.
// Show premium notice if Premium Add-On is not active.
if ( ! wpbf_is_premium() ) {

	$premium_ad_link = sprintf(
		'<p>%1$s</p><p><a href="%2$s" target="_blank" class="button">%3$s</a></p>',
		__( 'Desktop Off-Canvas is a Premium feature. Upgrade to the Premium Add-On to unlock this feature and many more.', 'page-builder-framework' ),
		esc_url( 'https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=customizer_header_builder&utm_campaign=wpbf#premium' ),
		__( 'Learn More', 'page-builder-framework' )
	);

	wpbf_customizer_field()
		->id( $control_id_prefix . 'premium_notice' )
		->type( 'custom' )
		->tab( 'general' )
		->defaultValue( '<div class="wpbf-premium-notice">' . $premium_ad_link . '</div>' )
		->priority( 5 )
		->addToSection( $section_id );

}
