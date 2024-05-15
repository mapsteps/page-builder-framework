<?php

defined( 'ABSPATH' ) || die( "Can't access directly" );

if ( ! wpbf_is_premium_addon_outdated() ) {
	return;
}

