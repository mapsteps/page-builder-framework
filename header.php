<?php
/**
 * Theme Header
 *
 * @package Page Builder Framework
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?><!doctype html>

<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0"/>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
	<a class="screen-reader-text skip-link" href="#content" title="<?php echo esc_attr__( 'Skip to content', 'page-builder-framework' ); ?>"><?php _e( 'Skip to content', 'page-builder-framework' ); // WPCS: XSS ok. ?></a>

	<?php do_action( 'wpbf_body_open' ); ?>

	<div id="container" class="wpbf-page">

		<?php do_action( 'wpbf_before_header' ); ?>

		<?php do_action('wpbf_header'); ?>
		
		<?php do_action( 'wpbf_after_header' ); ?>