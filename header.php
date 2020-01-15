<?php
/**
 * Theme Header.
 *
 * See also inc/template-parts/header.php.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

?><!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php wpbf_body_schema_markup(); ?>>

	<a class="screen-reader-text skip-link" href="#content" title="<?php echo esc_attr__( 'Skip to content', 'page-builder-framework' ); ?>"><?php _e( 'Skip to content', 'page-builder-framework' ); ?></a>

	<?php do_action( 'wp_body_open' ); ?>

	<?php do_action( 'wpbf_body_open' ); ?>

	<div id="container" class="hfeed wpbf-page">

		<?php do_action( 'wpbf_before_header' ); ?>

		<?php do_action( 'wpbf_header' ); ?>

		<?php do_action( 'wpbf_after_header' ); ?>
