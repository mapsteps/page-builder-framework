<?php

namespace Kirki\Control;

// phpcs:disable Generic.Files.OneObjectStructurePerFile.MultipleFound

if ( class_exists( '\Kirki' ) ) {
	return;
}


use WP_Customize_Control;

/**
 * PBF's "fake" Kirki's Base class for compatiblity purpose.
 */
class Base extends WP_Customize_Control {}
