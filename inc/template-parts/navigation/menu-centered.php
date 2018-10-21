<?php
/**
 * Centered Menu
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<div class="wpbf-container wpbf-container-center wpbf-visible-large wpbf-nav-wrapper wpbf-menu-centered">

	<li class="menu-item logo-container">

	<?php get_template_part( 'inc/template-parts/logo/logo' ); ?>
	<?php get_template_part( 'inc/template-parts/logo/tagline' ); ?>

	</li>

	<?php do_action( 'wpbf_before_main_menu' ); ?>

	<nav id="navigation" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement">

		<?php do_action( 'wpbf_main_menu_open' ); ?>

		<?php do_action( 'wpbf_main_menu' ); ?>

		<?php do_action( 'wpbf_main_menu_close' ); ?>

	</nav>

	<?php do_action( 'wpbf_after_main_menu' ); ?>

</div>