import { forEachEl } from "../../../../assets/js/utils/dom-util";
import { WpbfCustomize } from "../../Base/src/interface";
import "./responsive-control.scss";

declare var wp: {
	customize: WpbfCustomize;
};

wp.customize.bind("ready", function () {
	init();
});

function init() {
	listenDevicePreviewSwitch();

	// Loop through wpbf device buttons and assign the event.
	jQuery(document).on(
		"click",
		".wpbf-device-buttons .wpbf-device-button",
		function (e) {
			const device = (this as HTMLButtonElement).dataset.wpbfDevice;
			if (!device) return;

			switchPreviewButtons(device);

			// Trigger WordPress device event.
			wp.customize.previewedDevice.set(device);
		},
	);
}

/**
 * Listen device switch event and switch our device buttons accordingly.
 */
function listenDevicePreviewSwitch() {
	// Bind device changes from WordPress default.
	wp.customize.previewedDevice.bind(function (device: string) {
		switchPreviewButtons(device);
	});
}

/**
 * Setup WPBF device preview.
 *
 * @param string device The device (mobile, tablet, or desktop).
 */
function switchPreviewButtons(device: string) {
	forEachEl(".wpbf-device-buttons .wpbf-device-button", function (el) {
		if (device === el.dataset.wpbfDevice) {
			el.classList.add("is-active");
		} else {
			el.classList.remove("is-active");
		}
	});

	forEachEl(".wpbf-control-device", function (el) {
		if (device === el.dataset.wpbfDevice) {
			el.classList.add("is-active");
		} else {
			el.classList.remove("is-active");
		}
	});

	// Switch the label to target first input field in current device mode.
	forEachEl(".wpbf-customize-control-responsive", function (el) {
		const setting = el.dataset.wpbfSetting;
		const id = `${setting ?? ""}-${device}`;
		const label = el.querySelector("label.customize-control-label");

		if (label && label instanceof HTMLLabelElement) {
			label.htmlFor = id;
		}
	});
}
