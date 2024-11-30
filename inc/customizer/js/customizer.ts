import { setupControlsMovement } from "../../../assets/js/utils/customizer-util";
import { WpbfCustomizeBuilderControl } from "../../../Customizer/Controls/Builder/src/builder-interface";
import { WpbfCustomizeCheckboxControl } from "../../../Customizer/Controls/Checkbox/src/checkbox-interface";

type BuilderPanelData = {
	panelId: string;
	builderControlId: string;
	toggleControlId: string;
};

window.wp.customize?.bind("ready", () => {
	setTimeout(() => {
		if (!window.wp.customize) return;
		setupCustomizer(jQuery, window.wp.customize);
	}, 25);
});

/**
 * Setup customizer.
 *
 * @param {JQueryStatic} $ - jQuery object.
 */
function setupCustomizer($: JQueryStatic, customizer: WpbfCustomize) {
	const customizePreviewId = "customize-preview";
	const builderPanelClassName = "builder-panel";

	init();

	function init() {
		setupLogoContainerWidth();
		setupBuilderControl();
		listenToHeaderBuilderToggle();
	}

	function setupLogoContainerWidth() {
		$("#customize-control-menu_logo_container_width")
			.on("mousedown", function () {
				$("iframe")
					.contents()
					.find(".wpbf-navigation .wpbf-1-4")
					.css("border-right", "3px solid #0085ba");
			})
			.on("mouseup", function () {
				$("iframe")
					.contents()
					.find(".wpbf-navigation .wpbf-1-4")
					.css("border-right", "none");
			});

		$("#customize-control-mobile_menu_logo_container_width")
			.on("mousedown", function () {
				$("iframe")
					.contents()
					.find(".wpbf-navigation .wpbf-2-3")
					.css("border-right", "3px solid #0085ba");
			})
			.on("mouseup", function () {
				$("iframe")
					.contents()
					.find(".wpbf-navigation .wpbf-2-3")
					.css("border-right", "none");
			});
	}

	function setupBuilderControl() {
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

			customizer.control(toggleControlId, function (control) {
				if (!control) return;
				const sectionId = control.section();

				customizer.section(sectionId, function (section) {
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
		customizer.panel(panelField.panelId, function (panel) {
			panel.container?.addClass(`${panelField.builderControlId}-control-panel`);

			panel.expanded.bind(function (expanded) {
				if (expanded) {
					customizer.control(panelField.toggleControlId, function (control) {
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
		customizer.control(
			panelField.toggleControlId,
			function (control: WpbfCustomizeCheckboxControl | undefined) {
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
		control: WpbfCustomizeCheckboxControl,
		controlEnabled?: boolean,
	) {
		if (controlEnabled) {
			customizer.panel(panelField.panelId, function (panel) {
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
		customizer.control(
			builderControlId,
			function (control: WpbfCustomizeBuilderControl | undefined) {
				if (!control) return;
				const params = control.params;

				const availableWidgets = params.builder.availableWidgets;
				if (!availableWidgets.length) return;

				for (const widget of availableWidgets) {
					const connectedSectionId = widget.section;
					if (!connectedSectionId) continue;

					customizer.section(connectedSectionId, function (section) {
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
		const $builderPanel = $(`.${builderControlId}-${builderPanelClassName}`);
		$builderPanel.addClass("before-shown");
		const panelHeight = $builderPanel.outerHeight();

		window.setTimeout(() => {
			$builderPanel.removeClass("before-shown");

			window.setTimeout(() => {
				$builderPanel.css("max-height", panelHeight ?? "auto");
				$("#" + customizePreviewId).css("bottom", panelHeight ?? "auto");
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
		$(`.${builderControlId}-${builderPanelClassName}`).removeAttr("style");

		$("#" + customizePreviewId).css("bottom", 0);

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

	function listenToHeaderBuilderToggle() {
		setupControlsMovement({
			dependency: {
				settingId: "wpbf_enable_header_builder",
				moveForwardWhenValueIs: true,
			},
			sections: [
				{
					from: "wpbf_menu_options",
					to: "wpbf_header_builder_row_2_section",
					controlsToMove: [
						{
							id: "menu_width",
							label: {
								from: undefined,
								to: "Container Width",
							},
							prio: {
								from: undefined,
								to: 10,
							},
						},
						{
							id: "menu_height",
							label: {
								from: undefined,
								to: "Vertical Padding",
							},
							prio: {
								from: undefined,
								to: 15,
							},
						},
					],
				},
				{
					from: "wpbf_menu_options",
					to: "wpbf_header_builder_row_2_section",
					controlsToMove: [
						{
							id: "menu_bg_color",
							prio: {
								from: undefined,
								to: 200,
							},
						},
						{
							id: "menu_font_colors",
							prio: {
								from: undefined,
								to: 205,
							},
						},
						{
							id: "menu_font_size",
							prio: {
								from: undefined,
								to: 210,
							},
						},
					],
				},
			],
		});
	}
}
