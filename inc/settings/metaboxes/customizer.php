<?php
/**
 * Metabox template for displaying customizer settings.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Output customizer links.
 *
 * Icons: Lucide (https://lucide.dev, ISC License), the SVG's inner markup.
 */
function wpbf_do_customizer_links() {

	$customizer_links = array(
		array(
			'text' => __( 'Logo', 'page-builder-framework' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bsection%5D=title_tagline' ),
			'icon' => '<rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>',
		),
		array(
			'text' => __( 'Site Navigation', 'page-builder-framework' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bsection%5D=wpbf_menu_options' ),
			'icon' => '<path d="M4 5h16"/><path d="M4 12h16"/><path d="M4 19h16"/>',
		),
		array(
			'text' => __( 'Mobile Menu', 'page-builder-framework' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bsection%5D=wpbf_mobile_menu_options' ),
			'icon' => '<rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><path d="M12 18h.01"/>',
		),
		array(
			'text' => __( 'Header', 'page-builder-framework' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bpanel%5D=header_panel' ),
			'icon' => '<rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/>',
		),
		array(
			'text' => __( 'Footer', 'page-builder-framework' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bsection%5D=wpbf_footer_options' ),
			'icon' => '<rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 15h18"/>',
		),
		array(
			'text' => __( 'Layout', 'page-builder-framework' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bsection%5D=wpbf_page_options' ),
			'icon' => '<rect width="18" height="7" x="3" y="3" rx="1"/><rect width="9" height="7" x="3" y="14" rx="1"/><rect width="5" height="7" x="16" y="14" rx="1"/>',
		),
		array(
			'text' => __( 'Sidebar', 'page-builder-framework' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bsection%5D=wpbf_sidebar_options' ),
			'icon' => '<rect width="18" height="18" x="3" y="3" rx="2"/><path d="M15 3v18"/>',
		),
		array(
			'text' => __( 'Blog', 'page-builder-framework' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bpanel%5D=blog_panel' ),
			'icon' => '<path d="M15 18h-5"/><path d="M18 14h-8"/><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-4 0v-9a2 2 0 0 1 2-2h2"/><rect width="8" height="4" x="10" y="6" rx="1"/>',
		),
		array(
			'text' => __( 'Post Layout', 'page-builder-framework' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bsection%5D=wpbf_single_options' ),
			'icon' => '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/>',
		),
		array(
			'text' => __( 'Typography', 'page-builder-framework' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bpanel%5D=typo_panel' ),
			'icon' => '<path d="M12 4v16"/><path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"/><path d="M9 20h6"/>',
		),
		array(
			'text' => __( 'Theme Buttons', 'page-builder-framework' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bsection%5D=wpbf_button_options' ),
			'icon' => '<path d="M14 4.1 12 6"/><path d="m5.1 8-2.9-.8"/><path d="m6 12-1.9 2"/><path d="M7.2 2.2 8 5.1"/><path d="M9.037 9.69a.498.498 0 0 1 .653-.653l11 4.5a.5.5 0 0 1-.074.949l-4.349 1.041a1 1 0 0 0-.74.739l-1.04 4.35a.5.5 0 0 1-.95.074z"/>',
		),
	);

	if ( class_exists( 'WooCommerce' ) ) {
		$customizer_links[] = array(
			'text' => __( 'WooCommerce', 'page-builder-framework' ),
			'url'  => admin_url( 'customize.php?autofocus%5Bpanel%5D=woocommerce' ),
			'icon' => '<path d="M15 21v-5a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v5"/><path d="M17.774 10.31a1.12 1.12 0 0 0-1.549 0 2.5 2.5 0 0 1-3.451 0 1.12 1.12 0 0 0-1.548 0 2.5 2.5 0 0 1-3.452 0 1.12 1.12 0 0 0-1.549 0 2.5 2.5 0 0 1-3.77-3.248l2.889-4.184A2 2 0 0 1 7 2h10a2 2 0 0 1 1.653.873l2.895 4.192a2.5 2.5 0 0 1-3.774 3.244"/><path d="M4 10.95V19a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8.05"/>',
		);
	}

	foreach ( $customizer_links as $link_item ) {
		?>
		<li>
			<a href="<?php echo esc_url( $link_item['url'] ); ?>">
				<?php wpbf_theme_settings_icon( $link_item['icon'], 'wpbf-customizer-link-icon' ); ?>
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
