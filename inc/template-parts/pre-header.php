<?php
/**
 * Pre Header
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// vars
$pre_header_layout = get_theme_mod( 'pre_header_layout' );
$layout = $pre_header_layout == 'one' ? ' wpbf-pre-header-one-column' : ' wpbf-pre-header-two-columns';
$inner_layout = $pre_header_layout == 'one' ? 'wpbf-inner-pre-header-content' : 'wpbf-inner-pre-header-left';
$pre_header_hook_open = $pre_header_layout == 'one' ? 'wpbf_pre_header_open' : 'wpbf_pre_header_left_open';
$pre_header_hook_close = $pre_header_layout == 'one' ? 'wpbf_pre_header_close' : 'wpbf_pre_header_left_close';
$pre_header_column_one = get_theme_mod( 'pre_header_column_one', __( 'Column 1', 'page-builder-framework' ) );
$pre_header_column_two = get_theme_mod( 'pre_header_column_two', __( 'Column 2', 'page-builder-framework' ) );

// stop here if there's no pre-header or it has been set to none
if( ! $pre_header_layout || $pre_header_layout == 'none' ) return;

?>

			<div id="wpbf-pre-header">

				<?php do_action( 'wpbf_before_pre_header' ); ?>

				<div class="wpbf-inner-pre-header wpbf-container wpbf-container-center<?php echo esc_attr( $layout ); ?>">

					<div class="<?php echo esc_attr( $inner_layout ); ?>">

						<?php do_action( $pre_header_hook_open ); ?>

						<?php

							wp_nav_menu(array(
								'theme_location'	=>		'pre_header_menu',
								'container'			=>		false,
								'menu_class'		=>		'wpbf-menu wpbf-sub-menu wpbf-visible-large',
								'depth'				=>		'2',
								'fallback_cb'		=>		false,
							));

						?>

						<?php echo do_shortcode( $pre_header_column_one ); ?>

						<?php do_action( $pre_header_hook_close ); ?>

					</div>

					<?php if ( $pre_header_layout == 'two' ) { ?>

					<div class="wpbf-inner-pre-header-right">

						<?php do_action( 'wpbf_pre_header_right_open' ); ?>

						<?php echo do_shortcode( $pre_header_column_two ); ?>

						<?php

							wp_nav_menu(array(
								'theme_location'	=>		'pre_header_menu_right',
								'container'			=>		false,
								'menu_class'		=>		'wpbf-menu wpbf-sub-menu wpbf-visible-large',
								'depth'				=>		'2',
								'fallback_cb'		=>		false,
							));

						?>

						<?php do_action( 'wpbf_pre_header_right_close' ); ?>

					</div>

					<?php } ?>

		        </div>

		        <?php do_action( 'wpbf_after_pre_header' ); ?>

			</div>