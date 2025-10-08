/**
 * Setup dynamic label changes for menu trigger background color control.
 *
 * This changes the label based on the button style:
 * - "solid" style: "Button Background Color"
 * - "outline" style: "Button Border Color"
 */
export default function setupMenuTriggerLabels() {
	setupMenuTriggerLabelsByDevice("desktop");
	// setupMenuTriggerLabelsByDevice("mobile");
}

/**
 * Setup label changes for menu trigger by device.
 *
 * @param {string} device - The device type ("desktop" or "mobile").
 */
function setupMenuTriggerLabelsByDevice(device: "desktop" | "mobile") {
	const styleControlId = `wpbf_header_builder_${device}_menu_trigger_style`;
	const bgColorControlId = `wpbf_header_builder_${device}_menu_trigger_bg_color`;

	window.wp.customize?.(styleControlId, function (setting) {
		setting.bind(function (buttonStyle) {
			updateMenuTriggerBgColorLabel(bgColorControlId, buttonStyle);
		});
	});

	// Set initial label based on current value
	const initialStyle = window.wp.customize?.(styleControlId)?.get();
	if (initialStyle) {
		updateMenuTriggerBgColorLabel(bgColorControlId, initialStyle);
	}
}

/**
 * Update the label of menu trigger background color control.
 *
 * @param {string} controlId - The control ID.
 * @param {string} buttonStyle - The button style value.
 */
function updateMenuTriggerBgColorLabel(controlId: string, buttonStyle: string) {
	window.wp.customize?.control(controlId, function (control) {
		if (!control || !control.params) return;

		if (buttonStyle === "solid") {
			control.params.label = "Background Color";
		} else if (buttonStyle === "outline") {
			control.params.label = "Border Color";
		}

		// Trigger a re-render of the control label if needed
		const labelElement = control.container?.find(".customize-control-title");
		if (labelElement && labelElement.length) {
			labelElement.text(control.params.label);
		}
	});
}
