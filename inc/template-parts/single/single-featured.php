<?php
/**
 * Featured image.
 *
 * Renders the featured image on posts & pages.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Stop if there's no thumbnail.
if ( ! has_post_thumbnail() ) {
	return;
}

$options = get_post_meta( get_the_ID(), 'wpbf_options', true );
$class   = "post";

$remove_featured = $options ? in_array( 'remove-featured', $options ) : false;

// Stop here if featured image has been disabled.
if ( $remove_featured ) {
	return;
}

// change class if we're on a page.
if ( is_page() ) {
	$class = "page";
}

// Filter to allow us disable the featured image externally.
if ( apply_filters( 'wpbf_disable_featured_image', false ) ) {
	return;
}

?>

<div class="wpbf-<?php echo $class; ?>-image-wrapper">
	<?php the_post_thumbnail( apply_filters( 'wpbf_single_post_thumbnail_size', 'full' ), array( 'class' => 'wpbf-' . $class . '-image', 'itemprop' => 'image' ) ); ?>
</div>
