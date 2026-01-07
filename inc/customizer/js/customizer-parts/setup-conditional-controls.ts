import { WpbfCheckboxControl } from "../../../../Customizer/Controls/Checkbox/src/checkbox-interface";

/**
 * Initializes additional visibility conditions for Customizer controls
 * that are not covered by their default `active_callback` settings.
 *
 * Use case:
 * When the header builder is enabled, some existing controls are moved
 * into header builder sections. These controls already have their own
 * `active_callback` logic, but in some cases we need to apply extra
 * or different visibility conditions beyond those defaults.
 *
 * This function allows defining such custom conditional behaviors.
 *
 * @export
 */
export function setupConditionalControls() {
	init();

	function init() {
		listenToHeaderBuilderToggleValue();
		listenToFooterBuilderToggleValue();
		setupMobileMenuTriggerVisibility();
		setupMobileMenuWidthVisibility();
		setupMobileMenuOverlayVisibility();
		setupMobileMenuOverlayColorVisibility();
		setupDesktopMenuOverlayVisibility();
		setupDesktopMenuOverlayColorVisibility();
	}

	/**
	 * Listen to the header builder toggle control's value change.
	 */
	function listenToHeaderBuilderToggleValue() {
		wp.customize?.control(
			"wpbf_header_builder_enabled",
			(control: WpbfCheckboxControl | undefined) => {
				if (!control) return;

				if (control.setting?.get()) {
					setupDesktopMenuPaddingVisibility(control, true);
				}

				control.setting?.bind(function (enabled) {
					/**
					 * Only handle when the header builder is enabled.
					 * When disabled, it will be handled by its default active callback rules.
					 */
					if (enabled) {
						setupDesktopMenuPaddingVisibility(control, enabled);
					}
				});
			},
		);
	}

	function setupDesktopMenuPaddingVisibility(
		control: WpbfCheckboxControl,
		enabled?: boolean,
	) {
		control.container.toggle(!!enabled);
	}

	/**
	 * Listen to the footer builder toggle control's value change.
	 * When footer builder is enabled, hide the old footer settings.
	 */
	function listenToFooterBuilderToggleValue() {
		const footerBuilderSettingId = "wpbf_enable_footer_builder";

		// Controls to hide when footer builder is enabled.
		const footerControlsToToggle = [
			"footer_layout",
			"footer_column_one_layout",
			"footer_column_one",
			"footer_column_two_separator",
			"footer_column_two_layout",
			"footer_column_two",
			"footer_width",
			"footer_height",
			"footer_bg_color",
			"footer_font_color",
			"footer_accent_color",
			"footer_accent_color_alt",
			"footer_font_size",
		];

		function applyFooterControlsVisibility(enabled: boolean) {
			footerControlsToToggle.forEach((controlId) => {
				try {
					window.wp.customize?.control(controlId, function (control) {
						if (!control || !control.container) return;
						control.container.toggle(!enabled);
					});
				} catch (e) {
					// ignore if control doesn't exist yet
				}
			});
		}

		// Bind to changes
		window.wp.customize?.(footerBuilderSettingId, function (setting) {
			setting.bind(function (val: boolean) {
				applyFooterControlsVisibility(val);
			});
		});

		// Initial apply
		const initial = window.wp.customize?.(footerBuilderSettingId)?.get();
		applyFooterControlsVisibility(!!initial);
	}

	/**
	 * Toggles visibility of mobile menu trigger controls based on the selected menu style.
	 * Only applies when header builder is enabled.
	 */
	function setupMobileMenuTriggerVisibility() {
		const headerBuilderSettingId = "wpbf_enable_header_builder";
		const styleSettingId = "wpbf_header_builder_mobile_menu_trigger_style";

		const controlsToToggle = [
			"mobile_menu_hamburger_bg_color",
			"mobile_menu_hamburger_border_radius",
		];

		function applyVisibility(buttonStyle: string) {
			// Only apply this JS visibility logic when header builder is enabled.
			// When disabled, let the PHP activeCallback handle visibility.
			const isHeaderBuilderEnabled = window.wp
				.customize?.(headerBuilderSettingId)
				?.get();

			if (!isHeaderBuilderEnabled) {
				return;
			}

			const shouldShow = buttonStyle === "outline" || buttonStyle === "solid";

			controlsToToggle.forEach((controlId) => {
				try {
					window.wp.customize?.control(controlId, function (control) {
						if (!control || !control.container) return;
						control.container.toggle(!!shouldShow);
					});
				} catch (e) {
					// ignore if control doesn't exist yet
				}
			});
		}

		// Bind to changes
		window.wp.customize?.(styleSettingId, function (setting) {
			setting.bind(function (val: string) {
				applyVisibility(val);
			});
		});

		// Initial apply (call even when initial is empty string to hide controls for 'simple')
		const initial = window.wp.customize?.(styleSettingId)?.get();
		applyVisibility(typeof initial !== "undefined" ? initial : "");
	}

	/**
	 * Toggles visibility of mobile menu width control based on the selected reveal type.
	 * Only show when reveal type is 'off-canvas'.
	 * Only applies when header builder is enabled.
	 */
	function setupMobileMenuWidthVisibility() {
		const headerBuilderSettingId = "wpbf_enable_header_builder";
		const revealAsSettingId = "wpbf_header_builder_mobile_offcanvas_reveal_as";
		const controlIdToToggle = "mobile_menu_width";

		function applyVisibility(revealType: string) {
			// Only apply this JS visibility logic when header builder is enabled.
			// When disabled, let the PHP activeCallback handle visibility.
			const isHeaderBuilderEnabled = window.wp
				.customize?.(headerBuilderSettingId)
				?.get();

			if (!isHeaderBuilderEnabled) {
				return;
			}

			const shouldShow = revealType === "off-canvas";

			try {
				window.wp.customize?.control(controlIdToToggle, function (control) {
					if (!control || !control.container) return;
					control.container.toggle(!!shouldShow);
				});
			} catch (e) {
				// ignore if control doesn't exist yet
			}
		}

		// Bind to changes
		window.wp.customize?.(revealAsSettingId, function (setting) {
			setting.bind(function (val: string) {
				applyVisibility(val);
			});
		});

		// Initial apply.
		const initial = window.wp.customize?.(revealAsSettingId)?.get();
		applyVisibility(typeof initial !== "undefined" ? initial : "dropdown");
	}

	/**
	 * Toggles visibility of mobile menu overlay controls based on the selected reveal type.
	 * Only show when reveal type is 'off-canvas'.
	 * Only applies when header builder is enabled.
	 */
	function setupMobileMenuOverlayVisibility() {
		const headerBuilderSettingId = "wpbf_enable_header_builder";
		const revealAsSettingId = "wpbf_header_builder_mobile_offcanvas_reveal_as";
		const controlIdToToggle = "mobile_menu_overlay";

		function applyVisibility(revealType: string) {
			// Only apply this JS visibility logic when header builder is enabled.
			// When disabled, let the PHP activeCallback handle visibility.
			const isHeaderBuilderEnabled = window.wp
				.customize?.(headerBuilderSettingId)
				?.get();

			if (!isHeaderBuilderEnabled) {
				return;
			}

			const shouldShow = revealType === "off-canvas";

			try {
				window.wp.customize?.control(controlIdToToggle, function (control) {
					if (!control || !control.container) return;
					control.container.toggle(!!shouldShow);
				});
			} catch (e) {
				// ignore if control doesn't exist yet
			}
		}

		// Bind to changes
		window.wp.customize?.(revealAsSettingId, function (setting) {
			setting.bind(function (val: string) {
				applyVisibility(val);
			});
		});

		// Initial apply.
		const initial = window.wp.customize?.(revealAsSettingId)?.get();
		applyVisibility(typeof initial !== "undefined" ? initial : "dropdown");
	}

	/**
	 * Toggles visibility of mobile menu overlay color control based on:
	 * 1. The selected reveal type (must be 'off-canvas')
	 * 2. The mobile_menu_overlay toggle (must be enabled)
	 * Only applies when header builder is enabled.
	 */
	function setupMobileMenuOverlayColorVisibility() {
		const headerBuilderSettingId = "wpbf_enable_header_builder";
		const revealAsSettingId = "wpbf_header_builder_mobile_offcanvas_reveal_as";
		const overlayToggleSettingId = "mobile_menu_overlay";
		const controlIdToToggle = "mobile_menu_overlay_color";

		function applyVisibility() {
			// Only apply this JS visibility logic when header builder is enabled.
			// When disabled, let the PHP activeCallback handle visibility.
			const isHeaderBuilderEnabled = window.wp
				.customize?.(headerBuilderSettingId)
				?.get();

			if (!isHeaderBuilderEnabled) {
				return;
			}

			const revealType = window.wp.customize?.(revealAsSettingId)?.get();
			const overlayEnabled = window.wp
				.customize?.(overlayToggleSettingId)
				?.get();

			const isOffCanvas = revealType === "off-canvas";
			const shouldShow = isOffCanvas && overlayEnabled;

			try {
				window.wp.customize?.control(controlIdToToggle, function (control) {
					if (!control || !control.container) return;
					control.container.toggle(!!shouldShow);
				});
			} catch (e) {
				// ignore if control doesn't exist yet
			}
		}

		// Bind to reveal type changes
		window.wp.customize?.(revealAsSettingId, function (setting) {
			setting.bind(function () {
				applyVisibility();
			});
		});

		// Bind to overlay toggle changes
		window.wp.customize?.(overlayToggleSettingId, function (setting) {
			setting.bind(function () {
				applyVisibility();
			});
		});

		// Initial apply
		applyVisibility();
	}

	/**
	 * Toggles visibility of desktop menu_overlay control based on the selected reveal type.
	 * Hide when reveal type is 'fullscreen'. Show when 'off-canvas' (or off-canvas-left/right).
	 */
	function setupDesktopMenuOverlayVisibility() {
		const revealAsSettingId = "wpbf_header_builder_desktop_offcanvas_reveal_as";
		const controlIdToToggle = "menu_overlay";

		function applyVisibility(revealType: string) {
			// treat any off-canvas variant as visible
			const shouldShow =
				revealType === "off-canvas" ||
				revealType === "off-canvas-left" ||
				revealType === "off-canvas-right";

			try {
				window.wp.customize?.control(controlIdToToggle, function (control) {
					if (!control || !control.container) return;
					control.container.toggle(!!shouldShow);
				});
			} catch (e) {
				// ignore if control doesn't exist yet
			}
		}

		// Bind to changes
		window.wp.customize?.(revealAsSettingId, function (setting) {
			setting.bind(function (val: string) {
				applyVisibility(val);
			});
		});

		// Initial apply
		const initial = window.wp.customize?.(revealAsSettingId)?.get();
		applyVisibility(typeof initial !== "undefined" ? initial : "dropdown");
	}

	/**
	 * Toggles visibility of desktop menu overlay color control based on two conditions:
	 * 1) reveal type must be an off-canvas variant
	 * 2) the menu_overlay toggle must be enabled
	 */
	function setupDesktopMenuOverlayColorVisibility() {
		const revealAsSettingId = "wpbf_header_builder_desktop_offcanvas_reveal_as";
		const overlayToggleSettingId = "menu_overlay";
		const controlIdToToggle = "menu_overlay_color";

		function applyVisibility() {
			const revealType = window.wp.customize?.(revealAsSettingId)?.get();
			const overlayEnabled = window.wp
				.customize?.(overlayToggleSettingId)
				?.get();

			const isOffCanvas =
				revealType === "off-canvas" ||
				revealType === "off-canvas-left" ||
				revealType === "off-canvas-right";
			const shouldShow = !!isOffCanvas && !!overlayEnabled;

			try {
				window.wp.customize?.control(controlIdToToggle, function (control) {
					if (!control || !control.container) return;
					control.container.toggle(!!shouldShow);
				});
			} catch (e) {
				// ignore if control doesn't exist yet
			}
		}

		// Bind to reveal type changes
		window.wp.customize?.(revealAsSettingId, function (setting) {
			setting.bind(function () {
				applyVisibility();
			});
		});

		// Bind to overlay toggle changes
		window.wp.customize?.(overlayToggleSettingId, function (setting) {
			setting.bind(function () {
				applyVisibility();
			});
		});

		// Initial apply
		applyVisibility();
	}
}
