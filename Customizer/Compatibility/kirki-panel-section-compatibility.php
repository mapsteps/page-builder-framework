<?php

namespace Kirki;

// phpcs:disable Generic.Files.OneObjectStructurePerFile.MultipleFound

if ( ! class_exists( ( '\Kirki\Panel' ) ) ) {
	/**
	 * PBF's "fake" Kirki's Panel class for compatiblity purpose.
	 */
	class Panel {

		/**
		 * PBF's "fake" Kirki\Panel constructor.
		 *
		 * @param string $id ID of the panel.
		 * @param array  $args Arguments of the panel.
		 */
		public function __construct( $id, $args = [] ) {

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_panel( $id, $args );
			}

		}

	}
}

if ( ! class_exists( ( '\Kirki\Section' ) ) ) {
	/**
	 * PBF's "fake" Kirki's Section class for compatiblity purpose.
	 */
	class Section {

		/**
		 * PBF's "fake" Kirki\Section constructor.
		 *
		 * @param string $id ID of the panel.
		 * @param array  $args Arguments of the panel.
		 */
		public function __construct( $id, $args = [] ) {

			if ( class_exists( '\Kirki' ) ) {
				\Kirki::add_section( $id, $args );
			}

		}

	}
}
