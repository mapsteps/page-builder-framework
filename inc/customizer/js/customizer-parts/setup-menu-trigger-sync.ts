/**
 * Bidirectional Synchronization Assistant for Mobile Menu and Menu Trigger.
 *
 * This module handles the validation and feedback for the Header Builder's
 * Mobile Menu (Off-Canvas) and Menu Trigger widgets to prevent:
 * - Ghost Trigger: Trigger icon appears but Mobile Menu area is empty.
 * - Missing Trigger: Menu is populated but no Trigger widget is added.
 *
 * @export
 */

type SyncState = {
	hasTrigger: boolean;
	hasMenuWidgets: boolean;
};

const MOBILE_TRIGGER_WIDGET_KEY = "mobile_menu_trigger";
const MOBILE_MENU_WIDGET_KEYS = ["mobile_menu_1", "mobile_menu_2"];

const TRIGGER_SECTION_ID = "wpbf_header_builder_mobile_menu_trigger_section";
const OFFCANVAS_SECTION_ID = "wpbf_header_builder_mobile_offcanvas_section";

const WARNING_CLASS = "wpbf-sync-warning";
const HIGHLIGHT_CLASS = "wpbf-sync-highlight";

export function setupMenuTriggerSync() {
	// Only run when header builder is enabled.
	const isHeaderBuilderEnabled = window.wp
		.customize?.("wpbf_enable_header_builder")
		?.get();

	if (!isHeaderBuilderEnabled) {
		return;
	}

	init();

	function init() {
		listenToHeaderBuilderChanges();
		listenToSectionExpand();
		listenToPreviewMessages();

		// Initial validation after a short delay to ensure controls are ready.
		window.setTimeout(() => {
			validateAndUpdateWarnings();
		}, 100);
	}

	/**
	 * Listen to header builder layout changes.
	 */
	function listenToHeaderBuilderChanges() {
		window.wp.customize?.("wpbf_header_builder", function (setting) {
			setting.bind(function () {
				validateAndUpdateWarnings();
			});
		});

		// Also listen to header builder toggle.
		window.wp.customize?.("wpbf_enable_header_builder", function (setting) {
			setting.bind(function (enabled: boolean) {
				if (enabled) {
					window.setTimeout(() => {
						validateAndUpdateWarnings();
					}, 100);
				} else {
					removeAllWarnings();
				}
			});
		});
	}

	/**
	 * Listen to section expand events to show contextual warnings.
	 */
	function listenToSectionExpand() {
		// When Menu Trigger section is expanded.
		window.wp.customize?.section(TRIGGER_SECTION_ID, function (section) {
			section.expanded.bind(function (expanded: boolean) {
				if (expanded) {
					validateAndUpdateWarnings();
				}
			});
		});

		// When Mobile Menu (Off-Canvas) section is expanded.
		window.wp.customize?.section(OFFCANVAS_SECTION_ID, function (section) {
			section.expanded.bind(function (expanded: boolean) {
				if (expanded) {
					validateAndUpdateWarnings();
				}
			});
		});
	}

	/**
	 * Listen to messages from the preview iframe.
	 */
	function listenToPreviewMessages() {
		window.wp.customize?.previewer.bind(
			"wpbf-mobile-menu-empty-click",
			function () {
				// User clicked a ghost trigger - highlight the Mobile Menu area.
				highlightMobileMenuArea();
				showGhostTriggerNotice();
			},
		);
	}

	/**
	 * Get the current sync state from the header builder value.
	 */
	function getSyncState(): SyncState {
		const builderValue = window.wp.customize?.("wpbf_header_builder")?.get();

		const state: SyncState = {
			hasTrigger: false,
			hasMenuWidgets: false,
		};

		if (!builderValue || !builderValue.mobile) {
			return state;
		}

		const mobileLayout = builderValue.mobile;

		// Check if trigger is placed in any row/column.
		if (mobileLayout.rows) {
			for (const rowKey in mobileLayout.rows) {
				if (!mobileLayout.rows.hasOwnProperty(rowKey)) continue;

				const row = mobileLayout.rows[rowKey];
				for (const columnKey in row) {
					if (!row.hasOwnProperty(columnKey)) continue;

					const widgets = row[columnKey];
					if (Array.isArray(widgets)) {
						if (widgets.includes(MOBILE_TRIGGER_WIDGET_KEY)) {
							state.hasTrigger = true;
						}
					}
				}
			}
		}

		// Check if menu widgets are in the offcanvas area.
		if (mobileLayout.offcanvas && Array.isArray(mobileLayout.offcanvas)) {
			for (const widgetKey of mobileLayout.offcanvas) {
				if (MOBILE_MENU_WIDGET_KEYS.includes(widgetKey)) {
					state.hasMenuWidgets = true;
					break;
				}
			}
		}

		return state;
	}

	/**
	 * Validate the current state and update warnings accordingly.
	 */
	function validateAndUpdateWarnings() {
		const state = getSyncState();

		// Remove existing warnings first.
		removeAllWarnings();

		// Ghost Trigger: Has trigger but no menu widgets.
		if (state.hasTrigger && !state.hasMenuWidgets) {
			showWarningInSection(TRIGGER_SECTION_ID, {
				type: "ghost-trigger",
				message: window.wpbfMenuTriggerSyncL10n?.ghostTriggerWarning ||
					"The Menu Trigger is active, but the Mobile Menu area is empty. Add a Menu widget to the Mobile Menu area.",
				buttonText: window.wpbfMenuTriggerSyncL10n?.setupMobileMenu || "Setup Mobile Menu",
				action: () => {
					focusOnMobileMenuArea();
				},
			});
		}

		// Missing Trigger: Has menu widgets but no trigger.
		if (state.hasMenuWidgets && !state.hasTrigger) {
			showWarningInSection(OFFCANVAS_SECTION_ID, {
				type: "missing-trigger",
				message: window.wpbfMenuTriggerSyncL10n?.missingTriggerWarning ||
					"The Mobile Menu has content, but no Menu Trigger is placed in the header rows. Add a Menu Trigger widget to make the menu accessible.",
				buttonText: window.wpbfMenuTriggerSyncL10n?.addMenuTrigger || "Add Menu Trigger",
				action: () => {
					focusOnTriggerWidget();
				},
			});
		}
	}

	/**
	 * Show a warning notice in a specific section.
	 */
	function showWarningInSection(
		sectionId: string,
		options: {
			type: string;
			message: string;
			buttonText: string;
			action: () => void;
		},
	) {
		window.wp.customize?.section(sectionId, function (section) {
			if (!section.container || !section.container[0]) return;

			const container = section.container[0];
			const existingWarning = container.querySelector(`.${WARNING_CLASS}`);
			if (existingWarning) return;

			const warningEl = document.createElement("div");
			warningEl.className = `${WARNING_CLASS} ${WARNING_CLASS}--${options.type}`;
			warningEl.innerHTML = `
				<div class="wpbf-sync-warning__content">
					<span class="dashicons dashicons-warning"></span>
					<p>${options.message}</p>
				</div>
				<button type="button" class="button wpbf-sync-warning__button">
					${options.buttonText}
				</button>
			`;

			const button = warningEl.querySelector(".wpbf-sync-warning__button");
			if (button) {
				button.addEventListener("click", (e) => {
					e.preventDefault();
					options.action();
				});
			}

			// Insert at the top of the section content.
			const sectionContent = container.querySelector(
				".customize-section-content, .accordion-section-content",
			);

			if (sectionContent) {
				sectionContent.insertBefore(warningEl, sectionContent.firstChild);
			}
		});
	}

	/**
	 * Remove all warning notices.
	 */
	function removeAllWarnings() {
		const warnings = document.querySelectorAll(`.${WARNING_CLASS}`);
		warnings.forEach((warning) => warning.remove());
	}

	/**
	 * Focus on the Mobile Menu area in the builder panel.
	 */
	function focusOnMobileMenuArea() {
		// Expand the Mobile Menu section.
		window.wp.customize?.section(OFFCANVAS_SECTION_ID, function (section) {
			section.expand(section.params);
		});

		// Highlight the offcanvas drop zone in the builder panel.
		highlightMobileMenuArea();
	}

	/**
	 * Highlight the Mobile Menu area in the builder panel.
	 */
	function highlightMobileMenuArea() {
		const builderPanel = document.querySelector(
			".wpbf_header_builder-builder-panel",
		);
		if (!builderPanel) return;

		const mobileSlots = builderPanel.querySelector(
			'.wpbf-builder-slots[data-device="mobile"]',
		);
		if (!mobileSlots) return;

		const offcanvasArea = mobileSlots.querySelector(".builder-offcanvas");
		if (!offcanvasArea) return;

		// Add highlight class.
		offcanvasArea.classList.add(HIGHLIGHT_CLASS);

		// Remove highlight after animation.
		window.setTimeout(() => {
			offcanvasArea.classList.remove(HIGHLIGHT_CLASS);
		}, 2000);
	}

	/**
	 * Focus on the Menu Trigger widget in the available widgets panel.
	 */
	function focusOnTriggerWidget() {
		// Expand the Menu Trigger section.
		window.wp.customize?.section(TRIGGER_SECTION_ID, function (section) {
			section.expand(section.params);
		});

		// Highlight the trigger widget in the available widgets panel.
		highlightTriggerWidget();
	}

	/**
	 * Highlight the Menu Trigger widget in the available widgets panel.
	 */
	function highlightTriggerWidget() {
		const builderPanel = document.querySelector(
			".wpbf_header_builder-builder-panel",
		);
		if (!builderPanel) return;

		const mobileSlots = builderPanel.querySelector(
			'.wpbf-builder-slots[data-device="mobile"]',
		);
		if (!mobileSlots) return;

		// Find the trigger widget in the available widgets.
		const availableWidgetsPanel = document.querySelector(
			'.available-widgets-panel[data-device="mobile"]',
		);
		if (!availableWidgetsPanel) return;

		const triggerWidget = availableWidgetsPanel.querySelector(
			`.widget-item[data-widget-key="${MOBILE_TRIGGER_WIDGET_KEY}"]`,
		);
		if (!triggerWidget) return;

		// Add highlight class.
		triggerWidget.classList.add(HIGHLIGHT_CLASS);

		// Remove highlight after animation.
		window.setTimeout(() => {
			triggerWidget.classList.remove(HIGHLIGHT_CLASS);
		}, 2000);
	}

	/**
	 * Show a notice when user clicks a ghost trigger in the preview.
	 */
	function showGhostTriggerNotice() {
		// Focus on the Mobile Menu section with the warning.
		focusOnMobileMenuArea();
	}
}

// Extend the Window interface for localization.
declare global {
	interface Window {
		wpbfMenuTriggerSyncL10n?: {
			ghostTriggerWarning?: string;
			missingTriggerWarning?: string;
			setupMobileMenu?: string;
			addMenuTrigger?: string;
		};
	}
}
