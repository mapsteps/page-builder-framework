import { setupControlsMovement } from "./customizer-parts/setup-controls-movement";
import setupBuilderControlToggleBehavior from "./customizer-parts/setup-builder-control";
import setupLabelChanges from "./customizer-parts/setup-label-changes";
import { setupConditionalControls } from "./customizer-parts/setup-conditional-controls";
import { AnyWpbfCustomizeControl } from "../../../Customizer/Controls/Base/src/base-interface";

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
		listenSectionExpansion();
		listenSectionCollapse();
		setupLogoContainerWidth();
		setupBuilderControlToggleBehavior();
		setupControlsMovement();
		setupConditionalControls();
		setupLabelChanges();
	}

	/**
	 * Listen for section expansion and notify preview iframe.
	 * This enables lazy postMessage handler registration.
	 */
	function listenSectionExpansion() {
		const customizer = window.wp.customize;
		if (!customizer) return;

		customizer.section.each((section: WpbfCustomizeSection) => {
			section.expanded.bind((expanded: boolean) => {
				if (expanded) {
					customizer.previewer?.send("wpbf-section-expanded", section.id);
				}
			});
		});
	}

	/**
	 * Listen for section collapse and cleanup controls to free memory.
	 * Uses debounce to avoid cleanup during rapid section switching.
	 */
	function listenSectionCollapse() {
		const customizer = window.wp.customize;
		if (!customizer) return;

		// Map to store debounced cleanup timeouts per section.
		const collapseDebounceMap = new Map<
			string,
			ReturnType<typeof setTimeout>
		>();

		customizer.section.each((section: WpbfCustomizeSection) => {
			section.expanded.bind((expanded: boolean) => {
				// Clear any pending cleanup for this section.
				const existingTimeout = collapseDebounceMap.get(section.id);
				if (existingTimeout) {
					clearTimeout(existingTimeout);
					collapseDebounceMap.delete(section.id);
				}

				if (!expanded) {
					// Debounce cleanup to avoid rapid section switching issues.
					const timeout = setTimeout(() => {
						cleanupSectionControls(section.id);
						collapseDebounceMap.delete(section.id);
					}, 500);
					collapseDebounceMap.set(section.id, timeout);
				}
			});
		});

		/**
		 * Cleanup controls belonging to a section.
		 * Calls destroy() on each control and resets isEmbedded flag.
		 */
		function cleanupSectionControls(sectionId: string) {
			customizer.control.each(
				(control: AnyWpbfCustomizeControl | undefined) => {
					if (!control) return;
					if (control.section?.() !== sectionId) return;

					// Call destroy if available.
					if (typeof control.destroy === "function") {
						control.destroy();
					}

					// Reset embed state to allow re-initialization.
					if (control.isEmbedded !== undefined) {
						control.isEmbedded = false;
					}
				},
			);
		}
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
