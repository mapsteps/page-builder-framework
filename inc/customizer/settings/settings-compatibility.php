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
	<?php _e( 'Your version of the <strong>Premium Add-On</strong> is outdated and no longer compatible with the latest version of <strong>Page Builder Framework.</strong>', 'page-builder-framework' ); ?>
	<?php _e( 'Please update the Premium Add-On to the latest version.', 'page-builder-framework' ); ?>
</p>
<p>
	<a href="<?php echo esc_url( admin_url( 'update-core.php' ) ); ?>" class="button">
		<?php _e( 'View Updates', 'page-builder-framework' ); ?>
	</a>
	<a href="https://wp-pagebuilderframework.com/purchase-history/" class="button button-primary">
		<?php _e( 'Manage Subscription', 'page-builder-framework' ); ?>
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
