<?php
/**
 * LifterLMS custom wrapper (start).
 *
 * @package Page Builder Framework
 * @subpackage Integration/LifterLMS
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$grid_gap = get_theme_mod( 'sidebar_gap', 'medium' );

?>

<div id="content">

<?php do_action( 'wpbf_content_open' ); ?>

<?php wpbf_inner_content(); ?>

<?php do_action( 'wpbf_inner_content_open' ); ?>

<div class="wpbf-grid wpbf-main-grid wpbf-grid-<?php echo esc_attr( $grid_gap ); ?>">

<?php do_action( 'wpbf_sidebar_left' ); ?>

<main id="main" class="wpbf-main wpbf-medium-2-3<?php echo wpbf_archive_class(); ?>">
