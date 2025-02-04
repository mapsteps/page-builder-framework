export function setupSectionTabs() {
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

	function setupTabClicks() {
		jQuery(document).on("click", ".wpbf-tab-menu-item a", function (e) {
			e.preventDefault();
			if (!(this instanceof HTMLElement)) return;

			const parent = this.parentElement;
			if (!parent) return;

			const wrapper = parent.parentElement?.parentElement;
			if (!wrapper) return;

			const tabId = wrapper.dataset.wpbfTabId;
			if (!tabId) return;

			const tabItemName = parent.dataset.wpbfTabMenuId;
			if (!tabItemName) return;

			switchTabs(tabId, tabItemName);
		});
	}

	function setupBindings() {
		tabIds.forEach(function (tabId) {
			window.wp.customize?.section(tabId, function (section) {
				section.expanded.bind(function (isExpanded) {
					if (isExpanded) {
						const activeTabMenu = document.querySelector(
							'[data-wpbf-tab-id="' +
								tabId +
								'"] .wpbf-tab-menu-item.is-active',
						);

						if (activeTabMenu instanceof HTMLElement) {
							const activeTabMenuId = activeTabMenu.dataset.wpbfTabMenuId;
							if (activeTabMenuId) switchTabs(tabId, activeTabMenuId);
						}
					}
				});
			});
		});
	}
}

export function switchTabs(tabGroupId: string, tabItemId: string) {
	jQuery(
		'[data-wpbf-tab-id="' + tabGroupId + '"] .wpbf-tab-menu-item',
	).removeClass("is-active");

	const tabMenuItem = document.querySelector(
		'[data-wpbf-tab-id="' +
			tabGroupId +
			'"] [data-wpbf-tab-menu-id="' +
			tabItemId +
			'"]',
	);

	if (tabMenuItem) tabMenuItem.classList.add("is-active");

	const tabContentItems = document.querySelectorAll(
		'[data-wpbf-parent-tab-id="' + tabGroupId + '"]',
	);

	tabContentItems.forEach(function (tabItem) {
		if (!(tabItem instanceof HTMLElement)) return;

		if (tabItem.dataset.wpbfParentTabItem === tabItemId) {
			tabItem.classList.remove("wpbf-tab-item-hidden");
		} else {
			tabItem.classList.add("wpbf-tab-item-hidden");
		}
	});
}
