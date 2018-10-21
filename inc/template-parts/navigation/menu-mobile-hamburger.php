<?php
/**
 * Mobile Menu - Hamburger
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<div class="wpbf-mobile-menu-hamburger wpbf-hidden-large">

	<div class="wpbf-mobile-nav-wrapper wpbf-container">
		
		<div class="wpbf-mobile-logo-container wpbf-2-3">

			<?php get_template_part( 'inc/template-parts/logo/logo-mobile' ); ?>

		</div>

		<div class="wpbf-menu-toggle-container wpbf-1-3">

			<?php do_action( 'wpbf_before_mobile_toggle' ); ?>

			<i class="wpbf-mobile-menu-toggle wpbff wpbff-hamburger" aria-hidden="true"></i>

			<?php do_action( 'wpbf_after_mobile_toggle' ); ?>

		</div>

	</div>

	<div class="wpbf-mobile-menu-container">

		<nav id="navigation" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement">

			<?php wp_nav_menu(array(
				'theme_location'	=>		'mobile_menu',
				'container'			=>		false,
				'menu_class'		=>		'wpbf-mobile-menu',
				'depth'				=>		'3',
				'fallback_cb'		=>		'wpbf_menu_fallback'
			)); ?>

		</nav>

	</div>

</div>