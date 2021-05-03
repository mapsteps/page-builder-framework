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

$options         = get_post_meta( get_the_ID(), 'wpbf_options', true );
$remove_featured = $options ? in_array( 'remove-featured', $options ) : false;

// Stop here if featured image has been disabled.
if ( $remove_featured ) {
	return;
}

// Filter to allow us remove the featured image externally.
if ( apply_filters( 'wpbf_remove_featured_image', false ) ) {
	return;
}

$class = "post";

// change class if we're on a page.
if ( is_page() ) {
	$class = "page";
}

?>

<div class="wpbf-<?php echo $class; ?>-image-wrapper">
	<?php the_post_thumbnail( apply_filters( 'wpbf_single_post_thumbnail_size', 'full' ), array( 'class' => 'wpbf-' . $class . '-image', 'itemprop' => 'image' ) ); ?>
</div>
