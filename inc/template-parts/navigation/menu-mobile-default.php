<?php
/**
 * Mobile Menu - Default
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<div class="wpbf-mobile-menu-default wpbf-hidden-large">

	<div class="wpbf-mobile-nav-wrapper wpbf-container">
		
		<div class="wpbf-mobile-logo-container">

			<?php get_template_part( 'inc/template-parts/logo/logo-mobile' ); ?>

		</div>

		<div class="wpbf-menu-toggle-container">

			<span class="wpbf-mobile-menu-toggle wpbf-button wpbf-button-full"><?php echo apply_filters( 'wpbf_mobile_menu_text', __( 'Menu', 'page-builder-framework' ) ); // WPCS: XSS ok. ?></span>

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