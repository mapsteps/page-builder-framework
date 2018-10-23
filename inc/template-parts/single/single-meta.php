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

if( get_post_type() !== 'post' ) return;

do_action( 'wpbf_before_article_meta' );

?>

<p class="article-meta">

	<?php

		echo '<span class="posted-on">'. __( 'Posted on', 'page-builder-framework' ) .'</span> <time class="article-time published" datetime="'. get_the_date( 'c' ) .'" itemprop="datePublished">'. get_the_date() .'</time>'; // WPCS: XSS ok.

		$blog_author = get_theme_mod( 'blog_author' );

		if( !$blog_author || $blog_author == 'show' ) {

			echo sprintf( ' <span class="by">%1$s</span> <span class="article-author author vcard" itemscope="itemscope" itemprop="author" itemtype="https://schema.org/Person"><a class="url fn" href="%2$s" title="%3$s" rel="author" itemprop="url"><span itemprop="name">%4$s</span></a></span>', // WPCS: XSS ok, sanitization ok.
				__( 'by', 'page-builder-framework' ),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'View all posts by %s', 'page-builder-framework' ), get_the_author() ) ),
				esc_html( get_the_author() )
			);

		}

	?>

</p>

<?php do_action( 'wpbf_after_article_meta' ); ?>