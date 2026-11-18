<?php

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Stop here if current user can't manage options.
if ( ! current_user_can( 'manage_options' ) ) {
	return;
}

// Stop here if Premium Add-On is not outdated.
if ( ! wpbf_is_premium_addon_outdated() ) {
	return;
}

ob_start();
?>

<p>
	<?php echo wp_kses_post( __( 'Your version of the <strong>Premium Add-On</strong> is outdated and no longer compatible with the latest version of <strong>Page Builder Framework.</strong>', 'page-builder-framework' ) ); ?>
	<?php echo wp_kses_post( __( 'Please update the Premium Add-On to the latest version.', 'page-builder-framework' ) ); ?>
</p>
<p>
	<?php
	/* translators: 1: installed Premium Add-On version, 2: minimum version needed */
	printf( esc_html__( 'You have version %1$s, Page Builder Framework needs %2$s or newer. Until you update, some Premium Add-On features may not work.', 'page-builder-framework' ), esc_html( WPBF_PREMIUM_VERSION ), esc_html( WPBF_PREMIUM_MIN_VERSION ) );
	?>
</p>
<p>
	<a href="<?php echo esc_url( admin_url( 'update-core.php' ) ); ?>" class="button">
		<?php echo wp_kses_post( __( 'View Updates', 'page-builder-framework' ) ); ?>
	</a>
	<a href="https://wp-pagebuilderframework.com/purchase-history/" class="button button-primary">
		<?php echo wp_kses_post( __( 'Manage Subscription', 'page-builder-framework' ) ); ?>
	</a>
</p>

<?php
$wpbf_premium_outdated_notice = ob_get_clean();

// Section.
wpbf_customizer_section()
	->id( 'wpbf_premium_addon' )
	->type( 'expanded' )
	->title( __( 'Compatibility Warning', 'page-builder-framework' ) )
	->priority( 1 )
	->add();

// Field.
wpbf_customizer_field()
	->id( 'wpbf_premium_addon_outdated_notice' )
	->type( 'custom' )
	->defaultValue( $wpbf_premium_outdated_notice )
	->priority( 1 )
	->addToSection( 'wpbf_premium_addon' );
