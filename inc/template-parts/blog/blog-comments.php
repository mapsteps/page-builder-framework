<?php
/**
 * Comments
 *
 * Renders comments on archives, category, search, index & single pages.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<p class="footer-comment-count">
	<?php comments_number( __( '<span>No</span> Comments', 'page-builder-framework' ), __( '<span>One</span> Comment', 'page-builder-framework' ), __( '<span>%</span> Comments', 'page-builder-framework' ) );?>
</p>