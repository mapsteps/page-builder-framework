/**
 * Bidirectional Synchronization Assistant for Mobile Menu and Menu Trigger.
 *
 * This module highlights the Mobile Menu AREA in the builder panel when:
 * - Ghost Trigger: Menu Trigger is added but Mobile Menu area is empty.
 * - Missing Trigger: Menu widgets in Mobile Menu area but no Trigger in rows.
 *
 * @export
 */

type SyncState = {
	hasTrigger: boolean;
	hasMenuWidgets: boolean;
};

const MOBILE_TRIGGER_WIDGET_KEY = "mobile_menu_trigger";
const MOBILE_MENU_WIDGET_KEYS = ["mobile_menu_1", "mobile_menu_2"];

const GHOST_TRIGGER_CLASS = "wpbf-ghost-trigger-warning";
const MISSING_TRIGGER_CLASS = "wpbf-missing-trigger-warning";

export function setupMenuTriggerSync() {
	// Only run when header builder is enabled.
	const isHeaderBuilderEnabled = window.wp
		.customize?.("wpbf_enable_header_builder")
		?.get();

	if (!isHeaderBuilderEnabled) {
		// Still listen for when it gets enabled.
		listenToHeaderBuilderToggle();
		return;
	}

	init();

	/**
	 * Listen only to header builder toggle (for when initially disabled).
	 */
	function listenToHeaderBuilderToggle() {
		window.wp.customize?.("wpbf_enable_header_builder", function (setting) {
			setting.bind(function (enabled: boolean) {
				if (enabled) {
					window.setTimeout(() => {
						init();
					}, 500);
				}
			});
		});
	}

	function init() {
		listenToHeaderBuilderChanges();

		// Initial validation after a short delay to ensure builder panel is ready.
		window.setTimeout(() => {
			validateAndUpdateBuilderArea();
		}, 500);
	}

	/**
	 * Listen to header builder layout changes.
	 */
	function listenToHeaderBuilderChanges() {
		window.wp.customize?.("wpbf_header_builder", function (setting) {
			setting.bind(function () {
				validateAndUpdateBuilderArea();
			});
		});

		// Also listen to header builder toggle.
		window.wp.customize?.("wpbf_enable_header_builder", function (setting) {
			setting.bind(function (enabled: boolean) {
				if (enabled) {
					window.setTimeout(() => {
						validateAndUpdateBuilderArea();
					}, 500);
				} else {
					removeAllWarningClasses();
				}
			});
		});
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
	 * Get the Mobile Menu area element in the builder panel.
	 */
	function getMobileMenuArea(): Element | null {
		const builderPanel = document.querySelector(
			".wpbf_header_builder-builder-panel",
		);
		if (!builderPanel) return null;

		const mobileSlots = builderPanel.querySelector(
			'.wpbf-builder-slots[data-device="mobile"]',
		);
		if (!mobileSlots) return null;

		return mobileSlots.querySelector(".builder-offcanvas");
	}

	/**
	 * Get the Menu Trigger widget in the available widgets panel or in a row.
	 */
	function getTriggerWidgetInAvailable(): Element | null {
		const availableWidgetsPanel = document.querySelector(
			'.wpbf-available-widgets[data-device="mobile"]',
		);
		if (!availableWidgetsPanel) return null;

		return availableWidgetsPanel.querySelector(
			`.widget-item[data-widget-key="${MOBILE_TRIGGER_WIDGET_KEY}"]`,
		);
	}

	/**
	 * Validate the current state and update the builder area visuals.
	 */
	function validateAndUpdateBuilderArea() {
		const state = getSyncState();
		const mobileMenuArea = getMobileMenuArea();
		const triggerWidget = getTriggerWidgetInAvailable();

		// Remove existing warning classes first.
		removeAllWarningClasses();

		// Ghost Trigger: Has trigger but no menu widgets in Mobile Menu area.
		if (state.hasTrigger && !state.hasMenuWidgets) {
			if (mobileMenuArea) {
				mobileMenuArea.classList.add(GHOST_TRIGGER_CLASS);
			}
		}

		// Missing Trigger: Has menu widgets but no trigger in rows.
		if (state.hasMenuWidgets && !state.hasTrigger) {
			if (triggerWidget) {
				triggerWidget.classList.add(MISSING_TRIGGER_CLASS);
			}
		}
	}

	/**
	 * Remove all warning classes from builder elements.
	 */
	function removeAllWarningClasses() {
		document.querySelectorAll(`.${GHOST_TRIGGER_CLASS}`).forEach((el) => {
			el.classList.remove(GHOST_TRIGGER_CLASS);
		});
		document.querySelectorAll(`.${MISSING_TRIGGER_CLASS}`).forEach((el) => {
			el.classList.remove(MISSING_TRIGGER_CLASS);
		});
	}
}
