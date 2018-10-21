<?php
/**
 * Logo Mobile
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$menu_alt_tag = get_theme_mod( 'menu_logo_alt', get_bloginfo( 'name' ) );
$menu_title_tag = get_theme_mod( 'menu_logo_title', get_bloginfo( 'name' ) );
$menu_logo_url = get_theme_mod( 'menu_logo_url', home_url() );

$custom_logo_id = get_theme_mod( 'custom_logo' );
$custom_logo_url = wp_get_attachment_image_src( $custom_logo_id , 'full' );
$custom_logo_url = apply_filters( 'wpbf_logo_mobile', $custom_logo_url[0] );

if ( has_custom_logo() ) { ?>

	<a class="wpbf-mobile-logo" href="<?php echo esc_url( $menu_logo_url ); ?>" itemscope="itemscope" itemtype="https://schema.org/Organization">
		<img src="<?php echo esc_url( $custom_logo_url ); ?>" alt="<?php echo esc_attr( $menu_alt_tag ); ?>" title="<?php echo esc_attr( $menu_title_tag ); ?>">
	</a>

<?php } else { ?>

	<a class="wpbf-mobile-logo" itemscope="itemscope" itemtype="https://schema.org/Organization" href="<?php echo esc_url( $menu_logo_url ); ?>">
		<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
	</a>

<?php } ?>