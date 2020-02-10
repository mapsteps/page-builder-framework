<?php
/**
 * Theme setting's customizer metabox template.
 *
 * @package Page_Builder_Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );
?>

<div class="wrap settingstuff wpbf-settings border-box">

	<h1>
		<?php echo esc_html( get_admin_page_title() ); ?>
	</h1>

	<div class="wpbf-admin-page">
		<div class="left-section">

			<?php
			do_action( 'wpbf_theme_settings_customizer_box' );
			do_action( 'wpbf_theme_settings_premium_box' );
			?>

		</div><!-- .left-section -->
		<div class="right-section">

			<?php
			do_action( 'wpbf_theme_settings_recommended_box' );
			do_action( 'wpbf_theme_settings_documentation_box' );
			do_action( 'wpbf_theme_settings_community_box' );
			do_action( 'wpbf_theme_settings_additional_box' );
			?>

		</div><!-- .right-section -->
	</div><!-- .wpbf-admin-page -->

</div>
