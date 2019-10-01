<?php
/**
 * Search Form Template
 *
 * @package Page Builder Framework
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

global $wpbf_search_form_id;

if ( ! $wpbf_search_form_id ) {
	$wpbf_search_form_id = 1;
}

$prefix  = 'searchform-';

?>

<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php _e( 'Search for:', 'page-builder-framework' ); ?></span>
		<input type="search" id="<?php echo $prefix . (int) $wpbf_search_form_id++; ?>" name="s" value="" placeholder="<?php echo esc_attr( apply_filters( 'wpbf_search_placeholder', __( 'Search &hellip;', 'page-builder-framework' ) ) ); // WPCS: XSS ok. ?>" title="<?php echo esc_attr( apply_filters( 'wpbf_search_title', __( 'Press enter to search', 'page-builder-framework' ) ) ); // WPCS: XSS ok. ?>" />
	</label>
</form>