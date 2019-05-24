<?php
/**
 * Featured Image
 *
 * Renders featured image on archives.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// stop if there's no thumbnail
if( !has_post_thumbnail() ) return;

?>

<div class="wpbf-post-image-wrapper">
	<a class="wpbf-post-image-link" href="<?php echo esc_url( get_permalink() ); ?>">
		<span class="screen-reader-text"><?php the_title() ?></span>
		<?php the_post_thumbnail( apply_filters( 'wpbf_blog_post_thumbnail_size', 'full' ), array( 'class' => 'wpbf-post-image', 'itemprop' => 'image' ) ); ?>
	</a>
</div>