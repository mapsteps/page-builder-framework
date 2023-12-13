import {
	generateStyleTagFromEl,
	getInlineWidth,
	removeInlineWidth,
} from "../utils/anim-utils";
import {
	directQuerySelector,
	forEachEl,
	getAttrAsNumber,
	isInsideCustomizer,
	listenDocumentEvent,
} from "../utils/dom-utils";

/**
 * This module is intended to handle the desktop menu JS functionality.
 *
 * Along with the site.js and mobile-menu.js, this file will be combined to site-min.js file.
 */
export default function setupDesktopMenu() {
	/**
	 * The sub-menu animation duration.
	 */
	let duration = getAttrAsNumber(
		".wpbf-navigation",
		"data-sub-menu-animation-duration",
	);

	/**
	 * Initialize the module, call the main functions.
	 *
	 * This function is the only function that should be called on top level scope.
	 * Other functions are called / hooked from this function.
	 */
	function init() {
		setupMenuItemSearchButton();
		setupCenteredMenu();
		setup2ndLevelSubmenuAnimation();
		setupSubmenuFadeAnimation();
		setupAccessibility();

		// If we're inside customizer, then listen to the customizer's partial refresh.
		if (isInsideCustomizer()) {
			wp.customize.bind("preview-ready", function () {
				listenPartialRefresh();
			});
		}
	}

	/**
	 * Setup search interaction of the search button inside the menu item.
	 */
	function setupMenuItemSearchButton() {
		// Expand search field on click.
		listenDocumentEvent("click", ".wpbf-menu-item-search", function (e) {
			e.stopPropagation();

			if (!this.classList.contains("active")) {
				e.preventDefault();
			}

			openSearchField(this);
		});

		// Close search on window click.
		window.addEventListener("click", function (e) {
			closeSearchField();
		});

		// Close search on escape or tab.
		document.addEventListener("keyup", function (e) {
			if (e.key === "Escape" || e.key === "Esc") {
				closeSearchField();
				return;
			}

			if (e.key === "Tab") {
				if (!e.target.classList.contains("wpbff-search")) {
					closeSearchField();
				}
			}
		});
	}

	/**
	 * Expand search field functionality.
	 *
	 * @param {HTMLElement} menuItem The menu item.
	 */
	function openSearchField(menuItem) {
		const allMenuItems = document.querySelectorAll(
			".wpbf-navigation .wpbf-menu > li",
		);

		const lastThreeItems = Array.from(allMenuItems).slice(-3);

		lastThreeItems.forEach(function (item) {
			item.classList.add("calculate-width");
		});

		let itemWidth = 0;

		forEachEl(".calculate-width", function (el) {
			itemWidth += el.offsetWidth;
		});

		if (itemWidth < 200) {
			itemWidth = 250;
		}

		if (!menuItem.classList.contains("active")) {
			menuItem.classList.add("active");
			menuItem.setAttribute("aria-expanded", "true");

			const searchArea = menuItem.querySelector(".wpbf-menu-search");
			const searchField = menuItem.querySelector("input[type=search]");

			if (searchArea && searchField) {
				// The .is-visible doesn't have the width, let's add it to the style block.
				generateStyleTagFromEl(
					searchArea,
					`.wpbf-menu-item-search .wpbf-menu-search.is-visible {width: ${itemWidth}px;}`,
				);

				searchArea.classList.remove("is-hidden");
				setTimeout(function () {
					searchArea.classList.add("is-visible");
				}, 1);

				searchField.value = "";
				searchField.focus();
			}
		}
	}

	/**
	 * Close search field functionality.
	 */
	function closeSearchField() {
		forEachEl(".wpbf-menu-item-search", function (el) {
			if (!el.classList.contains("active")) {
				return;
			}

			const searchField = el.querySelector(".wpbf-menu-search");

			if (searchField) {
				removeInlineWidth(searchField);
				searchField.classList.remove("is-visible");

				setTimeout(function () {
					searchField.classList.add("is-hidden");
				}, 250);
			}

			setTimeout(function () {
				el.classList.remove("active");
				el.setAttribute("aria-expanded", "false");
			}, 400);
		});
	}

	/**
	 * Listen to WordPress selective refresh (partial refresh) inside customizer.
	 */
	function listenPartialRefresh() {
		wp.customize.selectiveRefresh.bind(
			"partial-content-rendered",
			function (placement) {
				/**
				 * A lot of partial refresh registered to work on header area.
				 * So it's better to not checking the "placement.partial.id".
				 */
				duration = getAttrAsNumber(
					".wpbf-navigation",
					"data-sub-menu-animation-duration",
				);

				setupCenteredMenu();
			},
		);
	}

	/**
	 * Setup centered menu.
	 */
	function setupCenteredMenu() {
		if (!document.querySelector(".wpbf-menu-centered")) return;

		const totalMenuItems = document.querySelectorAll(
			".wpbf-navigation .wpbf-menu-centered .wpbf-menu > li > a",
		).length;

		let divided = totalMenuItems / 2;
		divided = Math.floor(divided);
		divided = divided - 1;

		// Place the logo in the center of the menu.
		forEachEl(".wpbf-menu-centered .logo-container", function (el) {
			const menuItem = document.querySelector(
				".wpbf-navigation .wpbf-menu-centered .wpbf-menu > li:nth-child(" +
					divided +
					")",
			);

			if (menuItem) {
				menuItem.parentNode.insertBefore(el, menuItem.nextSibling);
				el.style.display = "block";
			}
		});
	}

	/**
	 * Setup sub-menu animation - second level.
	 */
	function setup2ndLevelSubmenuAnimation() {
		listenDocumentEvent(
			"mouseenter",
			".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .menu-item-has-children",
			function (e) {
				const submenu = this.querySelector(".sub-menu");
				if (!submenu) return;

				generateStyleTagFromEl(
					submenu,
					`.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .menu-item-has-children .sub-menu.is-visible {transition-duration: ${duration}ms;}`,
				);

				submenu.classList.add(".is-visible");
			},
		);

		listenDocumentEvent(
			"mouseleave",
			".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .menu-item-has-children",
			function () {
				const submenu = this.querySelector(".sub-menu");
				if (!submenu) return;
				submenu.classList.remove(".is-visible");
			},
		);
	}

	/**
	 * Setup sub-menu animation - fade.
	 */
	function setupSubmenuFadeAnimation() {
		listenDocumentEvent(
			"mouseenter",
			".wpbf-sub-menu-animation-fade > .menu-item-has-children",
			function () {
				const submenu = this.querySelector(".sub-menu");
				if (!submenu) return;

				generateStyleTagFromEl(
					submenu,
					`
					.wpbf-sub-menu-animation-fade > .menu-item-has-children > .sub-menu {display:block; opacity: 0; transition: opacity ${duration}ms ease-in-out;}
					`,
				);

				setTimeout(function () {
					submenu.classList.add("is-visible");
				}, 1);
			},
		);

		listenDocumentEvent(
			"mouseleave",
			".wpbf-sub-menu-animation-fade > .menu-item-has-children",
			function () {
				const submenu = this.querySelector(".sub-menu");
				if (!submenu) return;

				submenu.classList.remove("is-visible");
			},
		);
	}

	/**
	 * Setup accessibility.
	 *
	 * This functionality has gone through a stage of deep discussion and thought.
	 * We think this has been highly optimized.
	 * If we want to optimize it again, think again. Or, discuss it first.
	 */
	function setupAccessibility() {
		// Add aria-haspopup="true" to all sub-menu li's
		forEachEl(".menu-item-has-children", function (el) {
			el.setAttribute("aria-haspopup", "true");
		});

		// Add using-mouse class on mousedown.
		document.body.addEventListener("mousedown", function () {
			this.classList.add("using-mouse");

			forEachEl(".menu-item-has-children", function (el) {
				el.classList.remove("wpbf-sub-menu-focus");
			});
		});

		// Remove using-mouse class on keydown.
		document.body.addEventListener("keydown", function () {
			this.classList.remove("using-mouse");
		});

		/**
		 * General logic for tab/hover navigation on desktop navigations that contain sub-menus.
		 */
		listenDocumentEvent(
			"mouseenter",
			// Apply only to sub-menus that are not triggered by tab navigation.
			".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-sub-menu-focus)",
			function () {
				// Remove visual focus if tab-navigation was used earlier.
				document.body.classList.add("using-mouse");

				// Remove "wpbf-sub-menu-focus" class if tab-navigation was used earlier.
				forEachEl(".menu-item-has-children", function (el) {
					el.classList.remove("wpbf-sub-menu-focus");
				});

				const link = directQuerySelector(this, "a");
				if (link) link.focus();
			},
		);

		/**
		 * On mouseleave of tab navigation triggered sub-menu, let's remove the "wpbf-sub-menu-focus" class.
		 * Fixes issue where sub-menu stayed open after switching from tab to mouse navigation.
		 */
		listenDocumentEvent(
			"mouseleave",
			".wpbf-sub-menu > .menu-item-has-children.wpbf-sub-menu-focus",
			function () {
				this.classList.remove("wpbf-sub-menu-focus");
			},
		);

		// Setup tab navigation.
		listenDocumentEvent("focus", ".wpbf-sub-menu a", onNavLinkFocus);
	}

	/**
	 * Function to run on navigation-link focus for tab navigation.
	 */
	function onNavLinkFocus() {
		// Stop here if body has "using-mouse" class.
		if (document.body.classList.contains("using-mouse")) return;

		// Remove "wpbf-sub-menu-focus" class everywhere.
		forEachEl(".wpbf-sub-menu > .menu-item-has-children", function (el) {
			el.classList.remove("wpbf-sub-menu-focus");
		});

		// Hide other sub-menus that could be open due to mouse hover interference.
		forEachEl(
			".wpbf-sub-menu > .menu-item-has-children > .sub-menu",
			function (el) {
				el.style.display = "none";
			},
		);

		let menuItem = this;

		// Add "wpbf-sub-menu-focus" class to the current parent menu item that has children.
		while (menuItem.parentNode) {
			if (menuItem.classList.contains("menu-item-has-children")) {
				menuItem.classList.add("wpbf-sub-menu-focus");
			}

			menuItem = menuItem.parentNode;
		}
	}

	// Run the module.
	init();
}
