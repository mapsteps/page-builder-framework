<?php
/**
 * Sidebar
 *
 * @package Page Builder Framework
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$sidebar = apply_filters( 'wpbf_do_sidebar', 'sidebar-1' );

?>

	<div class="wpbf-medium-1-3 wpbf-sidebar-wrapper">

		<?php do_action( 'wpbf_before_sidebar' ); ?>

		<aside id="sidebar" class="wpbf-sidebar" itemscope="itemscope" itemtype="https://schema.org/WPSideBar">

		<?php do_action( 'wpbf_sidebar_open' ); ?>

		<?php if ( !dynamic_sidebar( $sidebar ) ) { ?>

			<?php if( current_user_can( 'edit_theme_options' ) ) { ?>

				<div class="widget no-widgets">
					<?php _e( 'Your Sidebar Widgets will appear here.', 'page-builder-framework' ); // WPCS: XSS ok. ?><br>
					<a href='<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>'><?php _e( 'Add Widgets', 'page-builder-framework' ); // WPCS: XSS ok. ?></a>
				</div>

			<?php } ?>

		<?php } ?>

		<?php do_action( 'wpbf_sidebar_close' ); ?>

		</aside>
		
		<?php do_action( 'wpbf_after_sidebar' ); ?>

	</div>