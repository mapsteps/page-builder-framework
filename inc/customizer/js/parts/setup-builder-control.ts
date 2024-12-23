import { WpbfBuilderControl } from "../../../../Customizer/Controls/Builder/src/builder-interface";
import { WpbfCheckboxControl } from "../../../../Customizer/Controls/Checkbox/src/checkbox-interface";

type BuilderPanelData = {
	panelId: string;
	builderControlId: string;
	toggleControlId: string;
};

declare var wp: {
	customize: WpbfCustomize | undefined;
};

const customizePreviewId = "customize-preview";
const builderPanelClassName = "builder-panel";

export default function setupBuilderControl() {
	const toggleControls = document.querySelectorAll(
		"#customize-theme-controls .wpbf-builder-toggle",
	);
	if (!toggleControls.length) return;

	const panelFields: BuilderPanelData[] = [];

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

				panelFields.push({
					panelId,
					toggleControlId,
					builderControlId,
				});
			});
		});
	}

	if (!panelFields.length) return;

	for (const panelField of panelFields) {
		listenBuilderPanel(panelField);
		listenToggleControl(panelField);
		listenConnectedSections(panelField.builderControlId);
	}
}

function listenBuilderPanel(panelField: BuilderPanelData) {
	wp.customize?.panel(panelField.panelId, function (panel) {
		panel.container?.addClass(`${panelField.builderControlId}-control-panel`);

		panel.expanded.bind(function (expanded) {
			if (expanded) {
				wp.customize?.control(panelField.toggleControlId, function (control) {
					if (control?.setting?.get()) {
						openBuilderPanel(panelField.builderControlId);
					}
				});
			} else {
				closeBuilderPanel(panelField.builderControlId);
			}
		});
	});
}

function listenToggleControl(panelField: BuilderPanelData) {
	wp.customize?.control(
		panelField.toggleControlId,
		function (control: WpbfCheckboxControl | undefined) {
			if (!control) return;

			checkToggleControl(panelField, control, control.setting?.get());

			control.setting?.bind(function (enabled) {
				checkToggleControl(panelField, control, enabled);
			});
		},
	);
}

function checkToggleControl(
	panelField: BuilderPanelData,
	control: WpbfCheckboxControl,
	controlEnabled?: boolean,
) {
	if (controlEnabled) {
		wp.customize?.panel(panelField.panelId, function (panel) {
			if (panel.expanded()) {
				if (control.container[0]) {
					control.container[0].classList.remove("disabled");
				}

				openBuilderPanel(panelField.builderControlId);
			}
		});
	} else {
		if (control.container[0]) {
			control.container[0].classList.add("disabled");
		}

		closeBuilderPanel(panelField.builderControlId);
	}
}

function listenConnectedSections(builderControlId: string) {
	wp.customize?.control(
		builderControlId,
		function (control: WpbfBuilderControl | undefined) {
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
 * Get builder customize panel.
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
