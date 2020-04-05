<?php
/**
 * Footer.
 *
 * Construct the theme footer.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Stop here if footer bar is disabled.
if ( 'none' === get_theme_mod( 'footer_layout' ) ) {
	return;
}

$theme_author = apply_filters(
	'wpbf_theme_author',
	array(
		'name' => __( 'Page Builder Framework', 'page-builder-framework' ),
		'url'  => 'https://wp-pagebuilderframework.com/',
	)
);

$footer_layout            = get_theme_mod( 'footer_layout', 'two' );
$layout                   = 'one' === $footer_layout ? ' wpbf-footer-one-column' : ' wpbf-footer-two-columns';
$inner_layout             = 'one' === $footer_layout ? 'wpbf-inner-footer-content' : 'wpbf-inner-footer-left';
$footer_column_one        = get_theme_mod( 'footer_column_one', '&copy; [year] - [blogname] | All rights reserved' );
$footer_column_two        = get_theme_mod( 'footer_column_two', 'Powered by [theme_author]' );
$search_for               = array( '[year]', '[blogname]', '[theme_author]' );
$replace_with             = array( date( 'Y' ), get_option( 'blogname' ), '<a href="' . esc_url( $theme_author['url'] ) . '">' . $theme_author['name'] . '</a>' );
$footer_column_one        = str_replace( $search_for, $replace_with, $footer_column_one );
$footer_column_two        = str_replace( $search_for, $replace_with, $footer_column_two );
$footer_column_one_layout = get_theme_mod( 'footer_column_one_layout', 'text' );
$footer_column_two_layout = get_theme_mod( 'footer_column_two_layout', 'text' );

?>

<footer id="footer" class="wpbf-page-footer" itemscope="itemscope" itemtype="https://schema.org/WPFooter">

	<?php do_action( 'wpbf_footer_open' ); ?>

	<div class="wpbf-inner-footer wpbf-container wpbf-container-center<?php echo esc_attr( $layout ); ?>">

		<div class="<?php echo esc_attr( $inner_layout ); ?>">

			<?php

			if ( 'text' === $footer_column_one_layout ) {

				wp_nav_menu( array(
					'theme_location' => 'footer_menu',
					'container'      => false,
					'menu_class'     => 'wpbf-menu',
					'depth'          => '1',
					'fallback_cb'    => false,
				) );

				echo do_shortcode( apply_filters( 'footer-column-left', $footer_column_one ) );

			} elseif ( 'menu' === $footer_column_one_layout ) {

				wp_nav_menu( array(
					'theme_location' => 'footer_menu',
					'container'      => false,
					'menu_class'     => 'wpbf-menu',
					'depth'          => '1',
					'fallback_cb'    => 'wpbf_menu_fallback',
				) );

			}

			?>

		</div>

		<?php if ( 'two' === $footer_layout ) { ?>

		<div class="wpbf-inner-footer-right">

			<?php

			if ( 'text' === $footer_column_two_layout ) {

				echo do_shortcode( apply_filters( 'footer-column-right', $footer_column_two ) );

				wp_nav_menu( array(
					'theme_location' => 'footer_menu_right',
					'container'      => false,
					'menu_class'     => 'wpbf-menu',
					'depth'          => '1',
					'fallback_cb'    => false,
				) );

			} elseif ( 'menu' === $footer_column_two_layout ) {

				wp_nav_menu( array(
					'theme_location' => 'footer_menu_right',
					'container'      => false,
					'menu_class'     => 'wpbf-menu',
					'depth'          => '1',
					'fallback_cb'    => 'wpbf_menu_fallback',
				) );

			}

			?>

		</div>

		<?php } ?>

	</div>

	<?php do_action( 'wpbf_footer_close' ); ?>

</footer>
