<?php
/**
 * Theme setting's customizer metabox template.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );
?>

<div class="wrap settingstuff">

	<h1>
		<?php echo esc_html( get_admin_page_title() ); ?>
	</h1>

	<div class="wpbf-admin-page">
		<div class="left-section">

			<?php
			require __DIR__ . '/metaboxes/customizer.php';
			require __DIR__ . '/metaboxes/premium.php';
			?>

		</div><!-- .left-section -->
		<div class="right-section">

			<?php
			require __DIR__ . '/metaboxes/recommended.php';
			require __DIR__ . '/metaboxes/documentation.php';
			require __DIR__ . '/metaboxes/community.php';
			require __DIR__ . '/metaboxes/additional.php';
			?>

		</div><!-- .right-section -->
	</div><!-- .wpbf-admin-page -->

</div>
