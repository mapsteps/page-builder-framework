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

						<article id="post-not-found" class="wpbf-post">

							<header class="article-header">
								<h1 class="entry-title"><?php echo apply_filters( 'wpbf_no_post_headline', __( "Oops, this article couldn't be found!", 'page-builder-framework' ) ); // WPCS: XSS ok. ?></h1>
							</header>

							<section class="article-content">
								<p><?php echo apply_filters( 'wpbf_no_post_content', __( 'Something went wrong.', 'page-builder-framework' ) ); // WPCS: XSS ok. ?></p>
							</section>

						</article>
