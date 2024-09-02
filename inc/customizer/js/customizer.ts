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
		setupHeaderBuilder();
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

	function setupHeaderBuilder() {
		const toggleControls = document.querySelectorAll(
			"#customize-theme-controls .wpbf-builder-toggle",
		);
		if (!toggleControls.length) return;

		const panelFields: {
			panelId: string;
			toggleControlId: string;
			builderControlId: string;
		}[] = [];

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

					section.container?.addClass("wpbf-builder-section");

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
			customizer.panel(panelField.panelId, function (panel) {
				panel.container?.addClass("wpbf-builder-panel");

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

			customizer.control(panelField.toggleControlId, function (control) {
				control?.setting?.bind(function (enabled) {
					if (enabled) {
						customizer.panel(panelField.panelId, function (panel) {
							if (panel.expanded()) {
								enable(
									panelField.builderControlId,
									control.container ? control.container[0] : undefined,
								);
							}
						});
					} else {
						disable(
							panelField.builderControlId,
							control.container ? control.container[0] : undefined,
						);
					}
				});
			});
		}
	}

	function enable(
		connectedBuilderControlId: string,
		toggleControlContainer: HTMLElement | undefined,
	) {
		toggleControlContainer?.classList.remove("disabled");
		openBuilderPanel(connectedBuilderControlId);
	}

	function disable(
		connectedBuilderControlId: string,
		toggleControlContainer: HTMLElement | undefined,
	) {
		toggleControlContainer?.classList.add("disabled");
		closeBuilderPanel(connectedBuilderControlId);
	}

	/**
	 * Open the header builder panel.
	 * We don't use jQuery slideDown because it's too slow (noticeable).
	 *
	 * @param {string} builderControlId The builder control ID.
	 */
	function openBuilderPanel(builderControlId: string) {
		const $builderPanel = $(`.${builderControlId}-${builderPanelClassName}`);
		$builderPanel.addClass("before-shown");

		window.setTimeout(() => {
			const panelHeight = $builderPanel.outerHeight();
			$builderPanel.removeClass("before-shown");

			window.setTimeout(() => {
				$builderPanel.css("max-height", panelHeight ?? "auto");
				$("#" + customizePreviewId).css("bottom", panelHeight ?? "auto");
			}, 0);
		}, 0);
	}

	/**
	 * Close the header builder panel.
	 * We don't use jQuery slideUp because it's too slow (noticeable).
	 *
	 * @param {string} builderControlId The builder control ID.
	 */
	function closeBuilderPanel(builderControlId: string) {
		$(`.${builderControlId}-${builderPanelClassName}`).removeAttr("style");

		$("#" + customizePreviewId).css("bottom", 0);
	}
}
