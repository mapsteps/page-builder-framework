<?php
/**
 * Title
 *
 * Renders post title on archives, category, search and index pages.
 *
 * @package Page Builder Framework
 * @subpackage Template Parts
 */
 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<h3 class="entry-title" itemprop="headline"><a href="<?php esc_url( the_permalink() ) ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>