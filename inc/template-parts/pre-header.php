<?php
/**
 * Pre header.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$pre_header_layout            = get_theme_mod( 'pre_header_layout' );
$layout                       = 'one' === $pre_header_layout ? ' wpbf-pre-header-one-column' : ' wpbf-pre-header-two-columns';
$inner_layout                 = 'one' === $pre_header_layout ? 'wpbf-inner-pre-header-content' : 'wpbf-inner-pre-header-left';
$pre_header_hook_open         = 'one' === $pre_header_layout ? 'wpbf_pre_header_open' : 'wpbf_pre_header_left_open';
$pre_header_hook_close        = 'one' === $pre_header_layout ? 'wpbf_pre_header_close' : 'wpbf_pre_header_left_close';
$pre_header_column_one        = get_theme_mod( 'pre_header_column_one', __( 'Column 1', 'page-builder-framework' ) );
$pre_header_column_two        = get_theme_mod( 'pre_header_column_two', __( 'Column 2', 'page-builder-framework' ) );
$pre_header_column_one_layout = get_theme_mod( 'pre_header_column_one_layout', 'text' );
$pre_header_column_two_layout = get_theme_mod( 'pre_header_column_two_layout', 'text' );

// Stop here if pre header is disabled or not set.
if ( ! $pre_header_layout || 'none' === $pre_header_layout ) {
	return;
}

?>

<div id="pre-header" class="wpbf-pre-header">

	<?php do_action( 'wpbf_before_pre_header' ); ?>

	<div class="wpbf-inner-pre-header wpbf-container wpbf-container-center<?php echo esc_attr( $layout ); ?>">

		<div class="<?php echo esc_attr( $inner_layout ); ?>">

			<?php

			do_action( $pre_header_hook_open );

			if ( 'text' === $pre_header_column_one_layout ) {

				wp_nav_menu( array(
					'theme_location' => 'pre_header_menu',
					'container'      => false,
					'menu_class'     => 'wpbf-menu wpbf-sub-menu wpbf-visible-large' . wpbf_sub_menu_alignment() . wpbf_sub_menu_animation(),
					'depth'          => '4',
					'fallback_cb'    => false,
				) );

				echo do_shortcode( $pre_header_column_one );

			} elseif ( 'menu' === $pre_header_column_one_layout ) {

				wp_nav_menu( array(
					'theme_location' => 'pre_header_menu',
					'container'      => false,
					'menu_class'     => 'wpbf-menu wpbf-sub-menu wpbf-visible-large' . wpbf_sub_menu_alignment() . wpbf_sub_menu_animation(),
					'depth'          => '4',
					'fallback_cb'    => 'wpbf_menu_fallback',
				) );

			}

			do_action( $pre_header_hook_close );

			?>

		</div>

		<?php if ( 'two' === $pre_header_layout ) { ?>

		<div class="wpbf-inner-pre-header-right">

			<?php

			do_action( 'wpbf_pre_header_right_open' );

			if ( 'text' === $pre_header_column_two_layout ) {

				echo do_shortcode( $pre_header_column_two );

				wp_nav_menu( array(
					'theme_location' => 'pre_header_menu_right',
					'container'      => false,
					'menu_class'     => 'wpbf-menu wpbf-sub-menu wpbf-visible-large' . wpbf_sub_menu_alignment() . wpbf_sub_menu_animation(),
					'depth'          => '4',
					'fallback_cb'    => false,
				) );

			} elseif ( 'menu' === $pre_header_column_two_layout ) {

				wp_nav_menu( array(
					'theme_location' => 'pre_header_menu_right',
					'container'      => false,
					'menu_class'     => 'wpbf-menu wpbf-sub-menu wpbf-visible-large' . wpbf_sub_menu_alignment() . wpbf_sub_menu_animation(),
					'depth'          => '4',
					'fallback_cb'    => 'wpbf_menu_fallback',
				) );

			}

			do_action( 'wpbf_pre_header_right_close' );

			?>

		</div>

		<?php } ?>

    </div>

    <?php do_action( 'wpbf_after_pre_header' ); ?>

</div>
