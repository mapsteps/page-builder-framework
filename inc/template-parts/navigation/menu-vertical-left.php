<?php
/**
 * Vertical menu left.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

?>

<div class="wpbf-menu-vertical wpbf-menu-vertical-left wpbf-visible-large">

	<div class="wpbf-1-4 wpbf-logo-container">

		<?php get_template_part( 'inc/template-parts/logo/logo' ); ?>

	</div>

	<?php do_action( 'wpbf_before_main_menu' ); ?>

	<nav id="navigation" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement">

		<?php do_action( 'wpbf_main_menu_open' ); ?>

		<?php do_action( 'wpbf_main_menu' ); ?>

		<?php do_action( 'wpbf_main_menu_close' ); ?>

	</nav>

	<?php do_action( 'wpbf_after_main_menu' ); ?>

</div>
