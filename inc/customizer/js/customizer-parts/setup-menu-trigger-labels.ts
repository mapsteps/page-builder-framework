/**
 * Setup dynamic label changes for menu trigger background color control.
 *
 * This changes the label based on the button style:
 * - "solid" style: "Button Background Color"
 * - "outline" style: "Button Border Color"
 */
export default function setupMenuTriggerLabels() {
	setupMenuTriggerLabelsByDevice("desktop");
	setupMenuTriggerLabelsByDevice("mobile");

	setupMobileMenuTriggerVisibility();
}

/**
 * Setup label changes for menu trigger by device.
 *
 * @param {string} device - The device type ("desktop" or "mobile").
 */
function setupMenuTriggerLabelsByDevice(device: "desktop" | "mobile") {
	const styleControlId = `wpbf_header_builder_${device}_menu_trigger_style`;
	let bgColorControlId = `wpbf_header_builder_${device}_menu_trigger_bg_color`;

	if (device == "mobile") {
		// Mobile-specific label changes can be added here
		bgColorControlId = "mobile_menu_hamburger_bg_color";
	}

	window.wp.customize?.(styleControlId, function (setting) {
		setting.bind(function (buttonStyle) {
			updateMenuTriggerBgColorLabel(bgColorControlId, buttonStyle, device);
			// Re-apply the current bg color to the preview when style changes
			const currentColor = window.wp.customize?.(bgColorControlId)?.get();
			applyMenuTriggerColorToPreview(device, buttonStyle, currentColor);
		});
	});

	// Set initial label based on current value (always run to ensure label sync)
	const initialStyle = window.wp.customize?.(styleControlId)?.get() || "";
	updateMenuTriggerBgColorLabel(bgColorControlId, initialStyle, device);
	// apply initial color as well
	const initialColor = window.wp.customize?.(bgColorControlId)?.get();
	applyMenuTriggerColorToPreview(device, initialStyle, initialColor);

	// Bind to bg color changes so we update preview depending on the currently selected style
	window.wp.customize?.(bgColorControlId, function (setting) {
		setting.bind(function (colorValue) {
			const buttonStyle = window.wp.customize?.(styleControlId)?.get() || "";
			applyMenuTriggerColorToPreview(device, buttonStyle, colorValue);
		});
	});
}

/**
 * Update the label of menu trigger background color control.
 *
 * @param {string} controlId - The control ID.
 * @param {string} buttonStyle - The button style value.
 */
function updateMenuTriggerBgColorLabel(
	controlId: string,
	buttonStyle: string,
	device: string,
) {
	window.wp.customize?.control(controlId, function (control) {
		if (!control || !control.params) return;

		// Default: preserve existing label if we don't match a known style
		let newLabel = control.params.label || "";

		if (buttonStyle === "solid") {
			newLabel = "Background Color";
		} else if (buttonStyle === "outline") {
			newLabel = "Border Color";
		}

		control.params.label = newLabel;

		// Trigger a re-render of the control label if needed
		const labelElement = control.container?.find(".customize-control-title");
		if (labelElement && labelElement.length) {
			labelElement.text(control.params.label);
		}
	});
}

/**
 * Apply the menu trigger color to the Customizer preview iframe depending on style.
 * - outline -> set border (2px solid color)
 * - solid -> set background-color
 */
function applyMenuTriggerColorToPreview(
	device: "desktop" | "mobile",
	buttonStyle: string,
	colorValue: any,
) {
	try {
		const selector =
			device === "mobile" ? ".wpbf-mobile-menu-toggle" : ".wpbf-menu-toggle";
		const $iframe = window.jQuery ? window.jQuery("iframe") : null;

		if (!$iframe || !$iframe.length) return;

		const $els = $iframe.contents().find(selector);
		if (!$els || !$els.length) return;

		if (!colorValue) {
			// clear inline styles
			$els.css({ "background-color": "", border: "" });
			return;
		}

		if (buttonStyle === "outline") {
			// set border, clear background
			$els.css({
				"background-color": "unset",
				border: "2px solid " + colorValue,
			});
		} else if (buttonStyle === "solid") {
			// set background, clear border
			$els.css({ "background-color": colorValue, border: "unset" });
		} else {
			// simple or unknown: clear both
			$els.css({ "background-color": "", border: "" });
		}
	} catch (e) {
		// ignore errors interacting with iframe
	}
}

/**
 * Show/hide mobile-specific menu trigger controls based on selected style.
 * Ensures controls defined elsewhere (moved into the builder) are hidden for 'simple'.
 */
function setupMobileMenuTriggerVisibility() {
	const styleSettingId = "wpbf_header_builder_mobile_menu_trigger_style";
	const controlsToToggle = [
		"mobile_menu_hamburger_bg_color",
		"mobile_menu_hamburger_border_radius",
		"wpbf_header_builder_mobile_menu_trigger_button_separator",
		"wpbf_header_builder_mobile_menu_trigger_padding",
	];

	function applyVisibility(buttonStyle: string) {
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
