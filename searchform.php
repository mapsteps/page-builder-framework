<?php
/**
 * Search form template.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

global $wpbf_search_form_id;

if ( ! $wpbf_search_form_id ) {
	$wpbf_search_form_id = 1;
}

$prefix = 'searchform-';

?>

<form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">

	<label>

		<span class="screen-reader-text"><?php _e( 'Search for:', 'page-builder-framework' ); ?></span>
		<input type="search" id="<?php echo $prefix . (int) $wpbf_search_form_id++; ?>" name="s" value="" placeholder="<?php echo esc_attr( apply_filters( 'wpbf_search_placeholder', __( 'Search &hellip;', 'page-builder-framework' ) ) ); ?>" title="<?php echo esc_attr( apply_filters( 'wpbf_search_title', __( 'Press enter to search', 'page-builder-framework' ) ) ); ?>" />

		<?php if ( wpbf_svg_enabled() ) { ?>

			<button value="<?php _e( 'Search', 'page-builder-framework' ); ?>" class="wpbf-icon">
				<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 32 32" role="img" aria-hidden="true">
					<path d="M16 20.784c-1.094 0.463-2.259 0.698-3.462 0.698s-2.367-0.235-3.462-0.698c-1.059-0.448-2.011-1.090-2.829-1.908s-1.46-1.77-1.908-2.829c-0.463-1.094-0.698-2.259-0.698-3.462s0.235-2.367 0.698-3.462c0.448-1.059 1.090-2.011 1.908-2.829s1.77-1.46 2.829-1.908c1.094-0.463 2.259-0.698 3.462-0.698s2.367 0.235 3.462 0.698c1.059 0.448 2.011 1.090 2.829 1.908s1.46 1.77 1.908 2.829c0.463 1.094 0.698 2.259 0.698 3.462s-0.235 2.367-0.698 3.462c-0.448 1.059-1.090 2.011-1.908 2.829s-1.77 1.46-2.829 1.908zM31.661 29.088l-9.068-9.068c1.539-2.078 2.45-4.65 2.45-7.435 0-6.906-5.598-12.505-12.505-12.505s-12.505 5.598-12.505 12.505c0 6.906 5.598 12.505 12.505 12.505 2.831 0 5.442-0.941 7.537-2.526l9.055 9.055c0.409 0.409 1.073 0.409 1.482 0l1.048-1.048c0.409-0.409 0.409-1.073 0-1.482z"></path>
				</svg>
				<span class="screen-reader-text"><?php _e( 'Search', 'page-builder-framework' ); ?></span>
			</button>

		<?php } else { ?>

			<button value="<?php _e( 'Search', 'page-builder-framework' ); ?>" class="wpbff wpbff-search"></button>

		<?php } ?>

	</label>

</form>
