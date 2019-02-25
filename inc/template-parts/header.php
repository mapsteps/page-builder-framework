<?php
/**
 * Header
 *
 * Construct the Theme Header
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>

		<header id="header" class="wpbf-page-header" itemscope="itemscope" itemtype="https://schema.org/WPHeader">

			<?php do_action( 'wpbf_header_open' ); ?>

			<?php do_action( 'wpbf_pre_header' ); ?>

			<!-- Navigation -->
			<div class="wpbf-navigation<?php if ( function_exists( 'wpbf_transparent_header' ) ) wpbf_transparent_header(); ?>" <?php wpbf_navigation_attributes() ?> <?php if ( function_exists( 'wpbf_sticky_navigation' ) ) wpbf_sticky_navigation(); ?>>

				<?php do_action( 'wpbf_before_main_navigation' ); ?>

				<!-- Main Navigation -->
				<?php get_template_part( 'inc/template-parts/navigation/' . wpbf_menu() ); ?>

				<!-- Mobile Navigation -->
				<?php get_template_part( 'inc/template-parts/navigation/' . wpbf_mobile_menu() ); ?>

				<?php do_action( 'wpbf_after_main_navigation' ); ?>

			</div>

			<?php do_action( 'wpbf_header_close' ); ?>

		</header>