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

	foreach ( $customizer_links as $link_item ) {
		?>

		<li class="list-item">
			<div class="list-content">
				<a href="<?php echo esc_url( $link_item['url'] ); ?>">
					<?php echo esc_html( $link_item['text'] ); ?>
				</a>
			</div>
		</li>

		<?php
	}

}
add_action( 'wpbf_customizer_links', 'wpbf_do_customizer_links' );
?>

<div class="neatbox is-smooth has-medium-gap has-bigger-heading customizer-box">
	<h2>
		Links to Customizer Settings
	</h2>
	<ul class="neatbox-list customizer-list">

		<?php
		do_action( 'wpbf_before_customizer_links' );
		do_action( 'wpbf_customizer_links' );
		do_action( 'wpbf_after_customizer_links' );
		?>

		<li class="list-item inline-action">
			<div class="list-content">
				<h3 class="title">Launch WordPress Customizer</h3>
				<p class="description">
					Explore all of the Page Builder Framework features.
				</p>
			</div>
			<div class="list-action">
				<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" target="_blank" class="button button-primary">Customize</a>
			</div>
		</li>

	</ul>
</div><!-- .customizer-box -->
