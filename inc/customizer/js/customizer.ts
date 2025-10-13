import { setupControlsMovement } from "./customizer-parts/setup-controls-movement";
import setupBuilderControlToggleBehavior from "./customizer-parts/setup-builder-control";
import setupMenuTriggerLabels from "./customizer-parts/setup-menu-trigger-labels";

window.wp.customize?.bind("ready", () => {
	setTimeout(() => {
		setupCustomizer();
	}, 25);
});

/**
 * Setup customizer.
 */
function setupCustomizer() {
	init();

	function init() {
		listenDevicePreviewSwitch();
		setupLogoContainerWidth();
		setupBuilderControlToggleBehavior();
		setupControlsMovement();
		setupMenuTriggerLabels();
	}

	function listenDevicePreviewSwitch() {
		const previewedDevice = window.wp.customize?.previewedDevice.get();

		if (previewedDevice) {
			document.body.classList.add(`wpbf-${previewedDevice}-preview`);
		}

		window.wp.customize?.previewedDevice.bind(function (device) {
			document.body.classList.remove(`wpbf-desktop-preview`);
			document.body.classList.remove(`wpbf-tablet-preview`);
			document.body.classList.remove(`wpbf-mobile-preview`);

			document.body.classList.add(`wpbf-${device}-preview`);
		});
	}

	function setupLogoContainerWidth() {
		jQuery("#customize-control-menu_logo_container_width")
			.on("mousedown", function () {
				jQuery("iframe")
					.contents()
					.find(".wpbf-navigation .wpbf-1-4")
					.css("border-right", "3px solid #0085ba");
			})
			.on("mouseup", function () {
				jQuery("iframe")
					.contents()
					.find(".wpbf-navigation .wpbf-1-4")
					.css("border-right", "none");
			});

		jQuery("#customize-control-mobile_menu_logo_container_width")
			.on("mousedown", function () {
				jQuery("iframe")
					.contents()
					.find(".wpbf-navigation .wpbf-2-3")
					.css("border-right", "3px solid #0085ba");
			})
			.on("mouseup", function () {
				jQuery("iframe")
					.contents()
					.find(".wpbf-navigation .wpbf-2-3")
					.css("border-right", "none");
			});
	}
}
