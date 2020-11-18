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

	<h2>
		<?php _e( 'Customizer Settings', 'page-builder-framework' ); ?>
	</h2>

	<ul class="wpbf-customizer-list">

		<?php
		do_action( 'wpbf_before_customizer_links' );
		do_action( 'wpbf_customizer_links' );
		do_action( 'wpbf_after_customizer_links' );
		?>

		<li>
			<h3>
				<?php _e( 'Launch WordPress Customizer', 'page-builder-framework' ); ?>
			</h3>
			<p>
				<?php _e( 'Explore all of the Page Builder Framework features.', 'page-builder-framework' ); ?>
			</p>
			<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" target="_blank" class="button button-larger button-primary"><?php _e( 'Customize', 'page-builder-framework' ); ?></a>
		</li>

	</ul>

</div>
