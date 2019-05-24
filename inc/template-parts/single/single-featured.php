<?php
/**
 * Featured Image
 *
 * Renders the featured image on single pages.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$options = get_post_meta( get_the_ID(), 'wpbf_options', true );

$remove_featured = $options ? in_array( 'remove-featured', $options ) : false;

// stop here if featured image has been disabled
if( $remove_featured ) return;

?>

<div class="wpbf-post-image-wrapper">

	<?php the_post_thumbnail( apply_filters( 'wpbf_single_post_thumbnail_size', 'full' ), array( 'class' => 'wpbf-post-image', 'itemprop' => 'image' ) ); ?>

</div>