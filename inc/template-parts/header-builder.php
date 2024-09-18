<?php
/**
 * Header builder.
 *
 * Construct the theme header builder.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

?>

<header id="header" class="wpbf-page-header" itemscope="itemscope" itemtype="https://schema.org/WPHeader">

	<?php do_action( 'wpbf_header_open' ); ?>

	<?php do_action( 'wpbf_header_builder' ); ?>

	<?php do_action( 'wpbf_header_close' ); ?>

</header>
