<?php
/**
 * Meta
 *
 * Renders author metadata on single pages.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

do_action( 'wpbf_before_article_meta' );

?>

<p class="article-meta vcard">

	<?php

		echo '<span class="posted-on">'. __( 'Posted on', 'page-builder-framework' ) .'</span> <time class="article-time" datetime="'. get_the_time() .'" itemprop="datePublished">'. get_the_time( get_option( 'date_format' ) ) .'</time>'; // WPCS: XSS ok.

		$blog_author = get_theme_mod( 'blog_author' );

		if( !$blog_author || $blog_author == 'show' ) {

		echo ' <span class="by">'. __( 'by', 'page-builder-framework' ) .'</span> <span class="article-author author" itemprop="author" itemscope itemptype="http://schema.org/Person">'. get_the_author_link( get_the_author_meta( 'ID' ) ) .'</span>'; // WPCS: XSS ok.

		}

	?>

</p>

<?php do_action( 'wpbf_after_article_meta' ); ?>