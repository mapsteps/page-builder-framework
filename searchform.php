<?php
/**
 * Search Form Template
 *
 * @package Page Builder Framework
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">

	<input type="search" id="s" name="s" value="" placeholder="<?php echo esc_attr( apply_filters( 'wpbf_search_placeholder', __( 'Search &hellip;', 'page-builder-framework' ) ) ); // WPCS: XSS ok. ?>" title="<?php echo esc_attr( apply_filters( 'wpbf_search_title', __( 'Press enter to search', 'page-builder-framework' ) ) ); // WPCS: XSS ok. ?>" />

</form>