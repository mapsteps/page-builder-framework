<?php
/**
 * Article None
 *
 * being displayed if no post has been found
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>
						<?php echo '<h1 class="entry-title" itemprop="headline">' . apply_filters( 'wpbf_no_post_headline', __( "Oops, this article couldn't be found!", 'page-builder-framework' ) ) . '</h1>'; // WPCS: XSS ok. ?>

						<div class="entry-content" itemprop="text">

							<?php echo '<p>' . apply_filters( 'wpbf_no_post_content', __( "Something went wrong.", 'page-builder-framework' ) ) . '</p>'; // WPCS: XSS ok. ?>

						</div>