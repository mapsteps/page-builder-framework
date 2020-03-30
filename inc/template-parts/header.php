<?php
/**
 * Header.
 *
 * Construct the theme header.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

?>

<header id="header" class="wpbf-page-header" itemscope="itemscope" itemtype="https://schema.org/WPHeader">

	<?php do_action( 'wpbf_header_open' ); ?>

	<?php do_action( 'wpbf_pre_header' ); ?>

	<div class="wpbf-navigation<?php if ( function_exists( 'wpbf_transparent_header' ) ) wpbf_transparent_header(); ?>" <?php wpbf_navigation_attributes() ?> <?php if ( function_exists( 'wpbf_sticky_navigation' ) ) wpbf_sticky_navigation(); ?>>

		<?php do_action( 'wpbf_before_main_navigation' ); ?>

		<?php do_action( 'wpbf_navigation' ); ?>

		<?php do_action( 'wpbf_mobile_navigation' ); ?>

		<?php do_action( 'wpbf_after_main_navigation' ); ?>

	</div>

	<?php do_action( 'wpbf_header_close' ); ?>

</header>
