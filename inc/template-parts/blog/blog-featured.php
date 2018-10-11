<?php
/**
 * Featured Image
 *
 * Renders featured image on archives, category, search and index pages.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<a class="wpbf-post-image-link" href="<?php echo esc_url( get_permalink() ); ?>">
	<?php the_post_thumbnail( 'full', array( 'class' => 'wpbf-post-image', 'itemprop' => 'image' ) ); ?>
</a>