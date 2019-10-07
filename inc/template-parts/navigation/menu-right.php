<?php
/**
 * Right menu.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

?>

<div class="wpbf-container wpbf-container-center wpbf-visible-large wpbf-nav-wrapper wpbf-menu-right">

	<div class="wpbf-grid wpbf-grid-collapse">

		<div class="wpbf-1-4 wpbf-logo-container">

			<?php get_template_part( 'inc/template-parts/logo/logo' ); ?>

		</div>

		<div class="wpbf-3-4 wpbf-menu-container">

			<?php do_action( 'wpbf_before_main_menu' ); ?>

			<nav id="navigation" class="wpbf-clearfix" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement" aria-label="<?php _e( 'Site Navigation', 'page-builder-framework' ); ?>">

				<?php do_action( 'wpbf_main_menu_open' ); ?>

				<?php do_action( 'wpbf_main_menu' ); ?>

				<?php do_action( 'wpbf_main_menu_close' ); ?>

			</nav>

			<?php do_action( 'wpbf_after_main_menu' ); ?>

		</div>

	</div>

</div>
