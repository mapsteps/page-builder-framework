<?php
/**
 * Snapshot helper (dev only): WooCommerce test products for the page snapshot's shop, product and category pages
 * (snapshot.py FRONT): 4 simple products (one on sale, one out of stock) in the category "zz-test category".
 *
 * Usage: php -d extension=mysqli -d mysqli.default_port=10035 -d memory_limit=512M zz-test-products.php <wordpress-root> create
 *        ... zz-test-products.php <wordpress-root> delete
 *
 * Create them before a "before" and an "after" run, delete them afterwards (posts, meta and the category go; the
 * content tables' counts are as before, as login.php's dbstate shows).
 *
 * @package Page Builder Framework
 */

// phpcs:disable -- Dev tool.

$_SERVER['HTTP_HOST']   = 'pbf.local';
$_SERVER['REQUEST_URI'] = '/';
define( 'WP_USE_THEMES', false );
require $argv[1] . '/wp-load.php';
$mode = $argv[2] ?? '';
if ( 'create' === $mode ) {
	$cat = wp_insert_term( 'zz-test category', 'product_cat', array( 'slug' => 'zz-test-category' ) );
	$cat_id = is_wp_error( $cat ) ? get_term_by( 'slug', 'zz-test-category', 'product_cat' )->term_id : $cat['term_id'];
	$items = array(
		array( 'zz-test simple', 'zz-test-simple', '19.00', '', 'instock' ),
		array( 'zz-test sale', 'zz-test-sale', '30.00', '24.00', 'instock' ),
		array( 'zz-test out of stock', 'zz-test-out-of-stock', '12.00', '', 'outofstock' ),
		array( 'zz-test fourth', 'zz-test-fourth', '45.00', '39.00', 'instock' ),
	);
	foreach ( $items as $i => $it ) {
		$p = new WC_Product_Simple();
		$p->set_name( $it[0] ); $p->set_slug( $it[1] ); $p->set_status( 'publish' );
		$p->set_regular_price( $it[2] ); if ( $it[3] ) { $p->set_sale_price( $it[3] ); }
		$p->set_stock_status( $it[4] ); $p->set_category_ids( array( $cat_id ) );
		$p->set_description( 'zz-test product description.' ); $p->set_short_description( 'zz-test short description.' );
		$p->set_weight( '1' ); $p->set_menu_order( $i );
		echo $it[1], ' ', $p->save(), "\n";
	}
	echo "cat $cat_id\n";
} elseif ( 'delete' === $mode ) {
	foreach ( get_posts( array( 'post_type' => 'product', 'post_status' => 'any', 'numberposts' => -1, 's' => 'zz-test' ) ) as $post ) {
		if ( 0 === strpos( $post->post_name, 'zz-test' ) ) { wc_get_product( $post->ID )->delete( true ); echo "deleted {$post->ID}\n"; }
	}
	$t = get_term_by( 'slug', 'zz-test-category', 'product_cat' ); if ( $t ) { wp_delete_term( $t->term_id, 'product_cat' ); echo "deleted cat {$t->term_id}\n"; }
	wc_delete_product_transients();
}
