jQuery(document).on("ready", () => {
	const api = window.wp.customize;
	if (!api) return;
	setupCustomizer(jQuery, api);
});

/**
 * Setup customizer.
 *
 * @param {JQueryStatic} $ - jQuery object.
 */
function setupCustomizer($: JQueryStatic, api: WpbfCustomize) {
	const customizePreviewId = "customize-preview";
	const headerPanelId = "header_panel";
	const headerBuilderPanelClassName = "header-builder-panel";
	const toggleFieldId = "wpbf_use_header_builder";

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
		if (!api) return;

		api.panel(headerPanelId, function (panel) {
			panel.expanded.bind(function (expanded) {
				if (expanded) {
					// Check for the toggleFieldId: if it's enabled, then open the panel.
					api.control(toggleFieldId, function (control) {
						if (control?.setting?.get()) {
							openHeaderBuilderPanel();
						}
					});
				} else {
					closeHeaderBuilderPanel();
				}
			});
		});

		api.control(toggleFieldId, function (control) {
			const enabled = control?.setting?.get();

			if (enabled) {
				control?.container?.removeClass("disabled");
			} else {
			}

			control?.setting?.bind(function (enabled) {
				if (enabled) {
					// Check for the headerPanelId: if it's expanded, then open the panel.
					api.panel(headerPanelId, function (panel) {
						if (panel.expanded()) {
							enable(control.container ? control.container[0] : undefined);
						}
					});
				} else {
					disable(control.container ? control.container[0] : undefined);
				}
			});
		});
	}

	function enable(controlContainer: HTMLElement | undefined) {
		controlContainer?.classList.remove("disabled");
		openHeaderBuilderPanel();
	}

	function disable(controlContainer: HTMLElement | undefined) {
		controlContainer?.classList.add("disabled");
		closeHeaderBuilderPanel();
	}

	/**
	 * Using jQuery animation (slideDown) is too slow (noticeable).
	 */
	function openHeaderBuilderPanel() {
		const $headerBuilderPanel = $("." + headerBuilderPanelClassName);
		$headerBuilderPanel.addClass("before-shown");

		window.setTimeout(() => {
			const panelHeight = $headerBuilderPanel.outerHeight();
			$headerBuilderPanel.removeClass("before-shown");

			window.setTimeout(() => {
				$headerBuilderPanel.css("max-height", panelHeight ?? "auto");
				$("#" + customizePreviewId).css("bottom", panelHeight ?? "auto");
			}, 0);
		}, 0);
	}

	/**
	 * Using jQuery animation (slideUp) is too slow (noticeable).
	 */
	function closeHeaderBuilderPanel() {
		$("." + headerBuilderPanelClassName).removeAttr("style");
		$("#" + customizePreviewId).css("bottom", 0);
	}
}
