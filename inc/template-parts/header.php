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

wpbf_header_builder_hooks();

do_action( 'wpbf_after_header_builder_hooks' );

?>

<header id="header" class="wpbf-page-header" itemscope="itemscope" itemtype="https://schema.org/WPHeader">

	<?php do_action( 'wpbf_header_open' ); ?>

	<?php do_action( 'wpbf_pre_header' ); ?>

	<?php do_action( 'wpbf_mobile_pre_navigation' ); ?>

	<div class="<?php wpbf_navigation_classes(); ?>" <?php wpbf_navigation_attributes(); ?>>

		<?php do_action( 'wpbf_before_main_navigation' ); ?>

		<?php do_action( 'wpbf_navigation' ); ?>

		<?php do_action( 'wpbf_mobile_navigation' ); ?>

		<?php do_action( 'wpbf_after_main_navigation' ); ?>

	</div>

	<?php do_action( 'wpbf_header_close' ); ?>

</header>
