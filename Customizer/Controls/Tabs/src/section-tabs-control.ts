import "./section-tabs-control.scss";

import { WpbfCustomize } from "../../Base/src/interface";

declare var wp: {
	customize: WpbfCustomize;
};

wp.customize.bind("ready", function () {
	setupTabs();
});

function setupTabs() {
	const childControls = document.querySelectorAll("[data-wpbf-parent-tab-id]");

	let tabIds: string[] = [];

	childControls.forEach(function (childControl) {
		if (!(childControl instanceof HTMLElement)) return;
		const parentTabId = childControl.dataset.wpbfParentTabId;
		if (!parentTabId) return;

		if (!tabIds.includes(parentTabId)) {
			tabIds.push(parentTabId);
		}
	});

	setupTabClicks();
	setupBindings();

	function switchTabs(tabId: string, tabItemName: string) {
		jQuery(
			'[data-wpbf-tab-id="' + tabId + '"] .wpbf-tab-menu-item',
		).removeClass("is-active");

		const tabMenuItem = document.querySelector(
			'[data-wpbf-tab-id="' +
				tabId +
				'"] [data-wpbf-tab-menu-id="' +
				tabItemName +
				'"]',
		);

		if (tabMenuItem) tabMenuItem.classList.add("is-active");

		const tabItems = document.querySelectorAll(
			'[data-wpbf-parent-tab-id="' + tabId + '"]',
		);

		tabItems.forEach(function (tabItem) {
			if (!(tabItem instanceof HTMLElement)) return;

			if (tabItem.dataset.wpbfParentTabItem === tabItemName) {
				tabItem.classList.remove("wpbf-tab-item-hidden");
			} else {
				tabItem.classList.add("wpbf-tab-item-hidden");
			}
		});
	}

	function setupTabClicks() {
		jQuery(document).on("click", ".wpbf-tab-menu-item a", function (e) {
			e.preventDefault();

			const tabId = this.parentNode.parentNode.parentNode.dataset.wpbfTabId;
			const tabItemName = this.parentNode.dataset.wpbfTabMenuId;

			switchTabs(tabId, tabItemName);
		});
	}

	function setupBindings() {
		tabIds.forEach(function (tabId) {
			wp.customize.section(tabId, function (section) {
				section.expanded.bind(function (isExpanded) {
					if (isExpanded) {
						const activeTabMenu = document.querySelector(
							'[data-wpbf-tab-id="' +
								tabId +
								'"] .wpbf-tab-menu-item.is-active',
						);

						if (activeTabMenu && activeTabMenu instanceof HTMLElement) {
							const activeTabMenuId = activeTabMenu.dataset.wpbfTabMenuId;
							if (activeTabMenuId) switchTabs(tabId, activeTabMenuId);
						}
					}
				});
			});
		});
	}
}
