import { WpbfBuilderControl } from "../../../../Customizer/Controls/Builder/src/builder-interface";
import { WpbfCheckboxControl } from "../../../../Customizer/Controls/Checkbox/src/checkbox-interface";

type BuilderPanelData = {
	togglePanelId: string;
	builderControlId: string;
	toggleControlId: string;
};

declare var wp: {
	customize: WpbfCustomize | undefined;
};

const customizePreviewId = "customize-preview";
const builderPanelClassName = "builder-panel";

/**
 * Setup builder control toggle behavior.
 *
 * This function will setup any toggle controls that have the `.wpbf-builder-toggle` class.
 * The toggle controls will be used to toggle the connected builder panel.
 */
export default function setupBuilderControlToggleBehavior() {
	const toggleControls = document.querySelectorAll(
		"#customize-theme-controls .wpbf-builder-toggle",
	);
	if (!toggleControls.length) return;

	const panelDataList: BuilderPanelData[] = [];

	for (const toggleControl of toggleControls) {
		if (!(toggleControl instanceof HTMLElement)) return;
		const toggleControlId = toggleControl.dataset.wpbfSetting;
		if (!toggleControlId) return;

		const builderControlId = toggleControl.dataset.connectedBuilder;
		if (!builderControlId) return;

		wp.customize?.control(toggleControlId, function (control) {
			if (!control) return;
			const sectionId = control.section();

			wp.customize?.section(sectionId, function (section) {
				const panelId = section.params.panel;
				if (!panelId) return;

				section.container?.addClass(
					`builder-control-section ${builderControlId}-control-section`,
				);

				panelDataList.push({
					togglePanelId: panelId,
					toggleControlId,
					builderControlId,
				});
			});
		});
	}

	if (!panelDataList.length) return;

	for (const panelData of panelDataList) {
		listenToTogglePanelExpand(panelData);
		listenToToggleControlValue(panelData);
		listenToWidgetConnectedSections(panelData.builderControlId);
	}

	listenDevicePreviewSwitch();
}

/**
 * Listen device switch event and switch our device buttons accordingly.
 */
function listenDevicePreviewSwitch() {
	// Bind device changes from WordPress default.
	wp.customize?.previewedDevice.bind(function (device: string) {
		// Do something later.
	});
}

/**
 * Listen to the expand/collapse event of the toggle's panel.
 *
 * Panel here is the panel of the toggle control, not the panel of the builder control itself.
 *
 * @param {BuilderPanelData} panelData - The builder panel data.
 */
function listenToTogglePanelExpand(panelData: BuilderPanelData) {
	wp.customize?.panel(panelData.togglePanelId, function (panel) {
		panel.container?.addClass(`${panelData.builderControlId}-control-panel`);

		panel.expanded.bind(function (expanded) {
			if (expanded) {
				wp.customize?.control(panelData.toggleControlId, function (control) {
					if (control?.setting?.get()) {
						openBuilderPanel(panelData.builderControlId);
					}
				});
			} else {
				closeBuilderPanel(panelData.builderControlId);
			}
		});
	});
}

/**
 * Listen to the toggle control's value change.
 */
function listenToToggleControlValue(panelData: BuilderPanelData) {
	wp.customize?.control(
		panelData.toggleControlId,
		(control: WpbfCheckboxControl | undefined) => {
			if (!control) return;

			toggleBuilderPanel(panelData, control, control.setting?.get());

			control.setting?.bind(function (enabled) {
				toggleBuilderPanel(panelData, control, enabled);
			});
		},
	);
}

/**
 * Toggle the builder panel.
 *
 * @param {BuilderPanelData} panelData - The builder panel data.
 * @param {WpbfCheckboxControl} toggleControl - The toggle control.
 * @param {boolean} toggleEnabled - Whether the toggle control is enabled.
 */
function toggleBuilderPanel(
	panelData: BuilderPanelData,
	toggleControl: WpbfCheckboxControl,
	toggleEnabled?: boolean,
) {
	if (toggleEnabled) {
		wp.customize?.panel(panelData.togglePanelId, function (panel) {
			if (panel.expanded()) {
				if (toggleControl.container[0]) {
					toggleControl.container[0].classList.remove("disabled");
				}

				openBuilderPanel(panelData.builderControlId);
			}
		});
	} else {
		if (toggleControl.container[0]) {
			toggleControl.container[0].classList.add("disabled");
		}

		closeBuilderPanel(panelData.builderControlId);
	}
}

/**
 * Listen to the expand/collapse event of the connected sections of the builder widgets.
 *
 * @param {string} builderControlId - The builder control ID.
 */
function listenToWidgetConnectedSections(builderControlId: string) {
	wp.customize?.control(
		builderControlId,
		(control: WpbfBuilderControl | undefined) => {
			if (!control) return;
			const params = control.params;

			const availableWidgets = params.builder.availableWidgets;
			if (!availableWidgets.length) return;

			for (const widget of availableWidgets) {
				const connectedSectionId = widget.section;
				if (!connectedSectionId) continue;

				wp.customize?.section(connectedSectionId, function (section) {
					section.expanded.bind(function (expanded) {
						// If the builder is disabled, then we don't need to do anything.
						if (!isBuilderEnabled(builderControlId)) return;

						const builderPanel = document.querySelector(
							`.${builderControlId}-builder-panel`,
						);

						if (builderPanel) {
							const activeWidget = builderPanel.querySelector(
								`.widget-item[data-widget-key="${widget.key}"]`,
							);

							if (activeWidget) {
								if (expanded) {
									activeWidget.classList.add("connected-section-expanded");
								} else {
									activeWidget.classList.remove("connected-section-expanded");
								}
							}
						}
					});
				});
			}
		},
	);
}

/**
 * Check if builder control is enabled.
 *
 * @param {string} builderControlId The builder control ID.
 * @returns {boolean} Whether builder is enabled or not.
 */
function isBuilderEnabled(builderControlId: string): boolean {
	const customizePanel = getBuilderCustomizePanel(builderControlId);
	if (!customizePanel) return false;

	return customizePanel.classList.contains("builder-is-shown");
}

/**
 * Open the builder panel.
 * We don't use jQuery slideDown because it's too slow (noticeable).
 *
 * @param {string} builderControlId The builder control ID.
 */
function openBuilderPanel(builderControlId: string) {
	const $builderPanel = jQuery(`.${builderControlId}-${builderPanelClassName}`);
	$builderPanel.addClass("before-shown");
	const panelHeight = $builderPanel.outerHeight();

	window.setTimeout(() => {
		$builderPanel.removeClass("before-shown");

		window.setTimeout(() => {
			$builderPanel.css("max-height", panelHeight ?? "auto");
			jQuery("#" + customizePreviewId).css("bottom", panelHeight ?? "auto");
		}, 0);

		const customizePanel = getBuilderCustomizePanel(builderControlId);
		if (!customizePanel) return;
		customizePanel.classList.add("builder-is-shown");
	}, 0);
}

/**
 * Close builder panel.
 * We don't use jQuery slideUp because it's too slow (noticeable).
 *
 * @param {string} builderControlId The builder control ID.
 */
function closeBuilderPanel(builderControlId: string) {
	jQuery(`.${builderControlId}-${builderPanelClassName}`).removeAttr("style");

	jQuery("#" + customizePreviewId).css("bottom", 0);

	const customizePanel = getBuilderCustomizePanel(builderControlId);
	if (!customizePanel) return;
	customizePanel.classList.remove("builder-is-shown");
}

/**
 * Get the builder's customizer panel.
 *
 * @param {string} builderControlId The builder control ID.
 * @returns {HTMLElement|undefined} The builder customize panel.
 */
function getBuilderCustomizePanel(
	builderControlId: string,
): HTMLElement | undefined {
	const customizePanel = document.querySelector(
		`.control-panel-content.${builderControlId}-control-panel`,
	);
	if (!(customizePanel instanceof HTMLElement)) return undefined;

	return customizePanel;
}
