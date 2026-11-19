<?php
/**
 * Metabox template for displaying customizer settings.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Output customizer links.
 */
function wpbf_do_customizer_links() {

	$customizer_links = array(
		array(
			'text' => __( 'Logo', 'page-builder-framework' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bsection%5D=title_tagline' ),
		),
		array(
			'text' => __( 'Site Navigation', 'page-builder-framework' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bsection%5D=wpbf_menu_options' ),
		),
		array(
			'text' => __( 'Mobile Menu', 'page-builder-framework' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bsection%5D=wpbf_mobile_menu_options' ),
		),
		array(
			'text' => __( 'Header', 'page-builder-framework' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bpanel%5D=header_panel' ),
		),
		array(
			'text' => __( 'Footer', 'page-builder-framework' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bsection%5D=wpbf_footer_options' ),
		),
		array(
			'text' => __( 'Layout', 'page-builder-framework' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bsection%5D=wpbf_page_options' ),
		),
		array(
			'text' => __( 'Sidebar', 'page-builder-framework' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bsection%5D=wpbf_sidebar_options' ),
		),
		array(
			'text' => __( 'Blog', 'page-builder-framework' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bpanel%5D=blog_panel' ),
		),
		array(
			'text' => __( 'Post Layout', 'page-builder-framework' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bsection%5D=wpbf_single_options' ),
		),
		array(
			'text' => __( 'Typography', 'page-builder-framework' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bpanel%5D=typo_panel' ),
		),
		array(
			'text' => __( 'Theme Buttons', 'page-builder-framework' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bsection%5D=wpbf_button_options' ),
		),
	);

	if ( class_exists( 'WooCommerce' ) ) {
		$customizer_links[] = array(
			'text' => __( 'WooCommerce', 'page-builder-framework' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bpanel%5D=woocommerce' ),
		);
	}

	foreach ( $customizer_links as $link_item ) {
		?>
		<li>
			<a href="<?php echo esc_url( $link_item['url'] ); ?>">
				<?php echo esc_html( $link_item['text'] ); ?>
			</a>
		</li>
		<?php
	}

}
add_action( 'wpbf_customizer_links', 'wpbf_do_customizer_links' );

?>

<div class="heatbox wpbf-customizer-metabox">

	<h2><?php esc_html_e( 'Customize your Site', 'page-builder-framework' ); ?></h2>

	<div class="heatbox-content">
		<ul class="wpbf-customizer-list">
			<?php
			do_action( 'wpbf_before_customizer_links' );
			do_action( 'wpbf_customizer_links' );
			do_action( 'wpbf_after_customizer_links' );
			?>
		</ul>
	</div>

</div>

<div class="heatbox-cta-container is-attached">
	<div class="heatbox-cta primary">
		<p><?php esc_html_e( 'Explore all of the Page Builder Framework features.', 'page-builder-framework' ); ?></p>
		<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Launch WordPress Customizer', 'page-builder-framework' ); ?></a>
	</div>
</div>
