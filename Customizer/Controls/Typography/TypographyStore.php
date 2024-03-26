<?php

namespace Mapsteps\Wpbf\Customizer\Controls\Typography;

final class TypographyStore {

	/**
	 * Whether the global JS objects for typography control has been printed.
	 *
	 * @var bool
	 */
	public static $control_vars_printed = false;

	/**
	 * Whether the global JS objects for typography preview has been printed.
	 *
	 * @var bool
	 */
	public static $preview_vars_printed = false;

	/**
	 * Added typography control ids.
	 *
	 * @var string[]
	 */
	public static $added_control_ids = array();

}
