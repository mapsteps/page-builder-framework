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

	<div class="<?php wpbf_navigation_classes(); ?>" <?php wpbf_navigation_attributes(); ?>>

		<?php do_action( 'wpbf_header_builder' ); ?>

	</div>

	<?php do_action( 'wpbf_header_close' ); ?>

</header>
