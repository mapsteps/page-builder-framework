/**
 * This module is intended to handle the mobile menu JS functionality.
 *
 * Along with the site.js and desktop-menu.js, this file will be combined to site-min.js file.
 *
 * @param {WpbfUtils} utils - The WpbfUtils object.
 */
export default function setupMobileMenu(utils) {
	const dom = utils.dom;
	const anim = utils.anim;

	let breakpoints = dom.getBreakpoints();

	/**
	 * The menu type. Accepts: 'hamburger', 'default', or 'premium'.
	 *
	 * @type {string}
	 */
	let menuType;

	// Initialize the module.
	init();

	/**
	 * Module initialization, call the main functions.
	 *
	 * This function is the only function that should be called on top level scope.
	 * Other functions are called / hooked from this function.
	 */
	function init() {
		// On window resize, get the updated breakpoints.
		window.addEventListener("resize", function (e) {
			breakpoints = dom.getBreakpoints();
		});

		setupMenuType();
		setupHashLinkBehavior();
		setupMobileMenu();
		setupMobileSubmenu();
	}

	/**
	 * Determine the menu type.
	 *
	 * This function will set the value of top level `menuType` variable.
	 * It could be 'hamburger', 'default', or 'premium'.
	 */
	function setupMenuType() {
		let menu = document.querySelector(".wpbf-mobile-menu-hamburger");

		if (menu) {
			menuType = "hamburger";
			return;
		}

		menu = document.querySelector(".wpbf-mobile-menu-default");

		if (menu) {
			menuType = "default";
			return;
		}

		menuType = "premium";
	}

	/**
	 * Setup behavior when clicking links that contain a hash.
	 */
	function setupHashLinkBehavior() {
		/**
		 * On mobile menu item hash link click,
		 * it will either close the mobile menu, or open the submenu if exists.
		 */
		dom.listenDocumentEvent(
			"click",
			".wpbf-mobile-menu a",
			/**
			 * @this {HTMLAnchorElement}
			 */
			function () {
				// Stop if menu type is 'premium'.
				if ("premium" === menuType) return;

				// Stop if href doesn't contain hash.
				if (!this.href.match("#") && !this.href.match("/#")) return;

				const parentNode = this.parentNode;

				const hasSubmenu =
					parentNode instanceof HTMLElement &&
					parentNode.classList.contains("menu-item-has-children");

				// If the link doesn't have sub-menu, then simply close the mobile menu.
				if (!hasSubmenu) {
					closeMobileMenu(menuType);
				} else {
					if (this.closest(".wpbf-mobile-mega-menu")) {
						// But if the link has sub-menu, and its top level parent menu item is a mega menu, then close the mobile menu.
						closeMobileMenu(menuType);
					} else {
						// And if its top level parent menu item is not a mega menu, then toggle it's sub-menu.
						toggleMobileSubmenuOnHashLinkClick(this);
					}
				}
			},
		);
	}

	/**
	 * Toggle submenu on hash link click.
	 *
	 * @param {HTMLElement} link The anchor element of the menu item.
	 */
	function toggleMobileSubmenuOnHashLinkClick(link) {
		let toggles = dom.getSiblings(link, ".wpbf-submenu-toggle");
		if (!toggles.length) return;
		const toggle = toggles[0];

		if (toggle.classList.contains("active")) {
			closeMobileSubmenu(toggle);
		} else {
			openMobileSubmenu(toggle);
		}
	}

	/**
	 * Setup mobile menu for both 'default' and 'hamburger' menu.
	 */
	function setupMobileMenu() {
		/**
		 * On mobile menu toggle click, we re-run the menu type setup and then run the toggling process.
		 * The menu type setup need to be re-run to handle the behavior inside customizer.
		 */
		dom.listenDocumentEvent("click", ".wpbf-mobile-menu-toggle", function () {
			setupMenuType();
			toggleMobileMenu(menuType);
		});

		// On window resize, if the window width is wider than desktop breakpoint, then hide the mobile menu.
		window.addEventListener("resize", function () {
			const windowHeight = document.documentElement.clientHeight;
			const windowWidth = document.documentElement.clientWidth;

			const mobileNavWrapper = document.querySelector(
				".wpbf-mobile-nav-wrapper",
			);

			const mobileNavWrapperHeight =
				mobileNavWrapper && mobileNavWrapper instanceof HTMLElement
					? mobileNavWrapper.offsetHeight
					: 0;

			dom.forEachEl(".wpbf-mobile-menu-container.active nav", function (el) {
				if (!(el instanceof HTMLElement)) return;
				el.style.maxHeight = windowHeight - mobileNavWrapperHeight + "px";
			});

			if (windowWidth > breakpoints.desktop) {
				closeMobileMenu(menuType);
			}
		});
	}

	/**
	 * Toggle the mobile menu to open or close.
	 * This won't run if the menu type is 'premium'.
	 *
	 * @param {string} menuType The menu type. Accepts 'default' or 'hamburger'.
	 */
	function toggleMobileMenu(menuType) {
		if ("premium" === menuType) return;

		// Toggle here is the mobile menu toggle button.
		const toggle = document.querySelector("#wpbf-mobile-menu-toggle");
		if (!toggle) return;

		if (toggle.classList.contains("active")) {
			closeMobileMenu(menuType);
		} else {
			openMobileMenu(menuType);
		}
	}

	const animScope = "mobile-menu-anim";
	const animClassName = "slide-anim";

	/**
	 * Open mobile menu.
	 * This function is only being called inside `toggleMobileMenu` function.
	 *
	 * But let the menuType and toggle checking stay inside.
	 * We may call this function directly outside of `toggleMobileMenu` function in the future.
	 *
	 * @param {string} menuType The menu type. Accepts 'hamburger' or 'default'.
	 */
	function openMobileMenu(menuType) {
		if ("premium" === menuType) return;

		// Toggle here is the mobile menu toggle button.
		const toggle = document.querySelector("#wpbf-mobile-menu-toggle");
		if (!toggle) return;

		const mobileMenu = document.querySelector(".wpbf-mobile-menu-container");

		if (
			mobileMenu &&
			mobileMenu instanceof HTMLElement &&
			!mobileMenu.classList.contains("active")
		) {
			mobileMenu.classList.add("active");

			const pureHeight = dom.getPureHeight(mobileMenu);
			const styleTagId = anim.getElStyleId(mobileMenu, animScope);
			const submenuId = styleTagId.replace("wpbf-style-", "");

			// The .is-expanded animation duration is set in SCSS file to 400ms.
			anim.writeElStyle(
				mobileMenu,
				animScope,
				`
				#${submenuId}.${animClassName}.is-expanded {height: ${pureHeight}px;}
				#${submenuId}.${animClassName} {display: block; height: 0; overflow: hidden;}
				`,
			);

			mobileMenu.classList.add(animClassName);

			setTimeout(function () {
				mobileMenu.classList.add("is-expanded");
			}, 1);
		}

		toggle.classList.add("active");
		toggle.setAttribute("aria-expanded", "true");

		if ("hamburger" === menuType) {
			toggle.classList.remove("wpbff-hamburger");
			toggle.classList.add("wpbff-times");
		}
	}

	/**
	 * Close mobile menu.
	 * This function is being called in `toggleMobileMenu` function and in several direct calls.
	 *
	 * @param {string} menuType The menu type. Accepts 'hamburger' or 'default'.
	 */
	function closeMobileMenu(menuType) {
		if ("premium" === menuType) return;

		// Toggle here is the mobile menu toggle button.
		const toggle = document.querySelector("#wpbf-mobile-menu-toggle");
		if (!toggle) return;

		// Because this function is also being called directly in several places, then we need this checking.
		if (!toggle.classList.contains("active")) return;

		const mobileMenu = document.querySelector(".wpbf-mobile-menu-container");

		if (
			mobileMenu &&
			mobileMenu instanceof HTMLElement &&
			mobileMenu.classList.contains("active")
		) {
			setTimeout(function () {
				mobileMenu.classList.remove("active");
				mobileMenu.classList.remove("is-expanded");

				setTimeout(function () {
					mobileMenu.classList.remove(animClassName);
				}, 400);
			}, 1);
		}

		toggle.classList.remove("active");
		toggle.setAttribute("aria-expanded", "false");

		if ("hamburger" === menuType) {
			toggle.classList.remove("wpbff-times");
			toggle.classList.add("wpbff-hamburger");
		}
	}

	/**
	 * Setup mobile sub-menu for both default and hamburger menu.
	 */
	function setupMobileSubmenu() {
		setupMobileSubmenuToggle("default");
		setupMobileSubmenuToggle("hamburger");
	}

	/**
	 * Setup mobile sub-menu toggle.
	 *
	 * @param {string} menuType The menu type. Accepts 'hamburger' or 'default'.
	 */
	function setupMobileSubmenuToggle(menuType) {
		const menuClass =
			menuType === "hamburger"
				? ".wpbf-mobile-menu-hamburger .wpbf-submenu-toggle"
				: ".wpbf-mobile-menu-default .wpbf-submenu-toggle";

		dom.listenDocumentEvent(
			"click",
			menuClass,
			/**
			 * @param {MouseEvent} e - The mouse event.
			 * @this {HTMLElement}
			 */
			function (e) {
				e.preventDefault();
				toggleMobileSubmenu(this);
			},
		);
	}

	/**
	 * Toggle mobile sub-menu to expand/collapse.
	 *
	 * @param {HTMLElement} toggle The submenu's toggle button (the expand/collapse arrow).
	 */
	function toggleMobileSubmenu(toggle) {
		if (toggle.classList.contains("active")) {
			closeMobileSubmenu(toggle);
		} else {
			openMobileSubmenu(toggle);
		}
	}

	const submenuAnimScope = "mobile-submenu-anim";

	/**
	 * Open mobile submenu.
	 *
	 * @param {HTMLElement} toggle The submenu's toggle button (the expand/collapse arrow).
	 */
	function openMobileSubmenu(toggle) {
		const iElms = toggle.querySelectorAll("i");

		iElms.forEach(function (el) {
			el.classList.remove("wpbff-arrow-down");
			el.classList.add("wpbff-arrow-up");
		});

		toggle.classList.add("active");
		toggle.setAttribute("aria-expanded", "true");

		const submenus = dom.getSiblings(toggle, ".sub-menu");

		submenus.forEach(function (submenu) {
			const pureHeight = dom.getPureHeight(submenu);
			const styleTagId = anim.getElStyleId(submenu, submenuAnimScope);
			const submenuId = styleTagId.replace("wpbf-style-", "");

			anim.writeElStyle(
				submenu,
				submenuAnimScope,
				`
				#${submenuId}.${animClassName}.is-expanded {height: ${pureHeight}px;}
				#${submenuId}.${animClassName} {display: block; height: 0; overflow: hidden;}
				`,
			);

			submenu.classList.add(animClassName);

			setTimeout(function () {
				submenu.classList.add("is-expanded");
			}, 1);
		});

		autoCollapseMobileSubmenus(toggle);
	}

	/**
	 * Close mobile submenu.
	 *
	 * @param {HTMLElement} toggle The submenu's toggle button (the expand/collapse arrow).
	 */
	function closeMobileSubmenu(toggle) {
		const iElms = toggle.querySelectorAll("i");

		iElms.forEach(function (el) {
			el.classList.remove("wpbff-arrow-up");
			el.classList.add("wpbff-arrow-down");
		});

		toggle.classList.remove("active");
		toggle.setAttribute("aria-expanded", "false");

		const submenus = dom.getSiblings(toggle, ".sub-menu");

		submenus.forEach(function (submenu) {
			setTimeout(function () {
				submenu.classList.remove("is-expanded");

				setTimeout(function () {
					submenu.classList.remove(animClassName);
				}, 400);
			}, 1);
		});
	}

	/**
	 * Auto collapse other opened mobile submenu.
	 *
	 * Open the sub-menu of current clicked menu item,
	 * and hide the other sub-menus (with the same level, in the same parent element).
	 *
	 * @param {HTMLElement} toggle The submenu's toggle button (the expand/collapse arrow) of the current clicked menu item.
	 */
	function autoCollapseMobileSubmenus(toggle) {
		const nav = toggle.closest(".wpbf-navigation");

		if (nav) {
			// If wpbf navigation exists but doesn't have mobile submenu collapse class, then stop here.
			if (!nav.classList.contains("wpbf-mobile-sub-menu-auto-collapse")) {
				return;
			}
		}

		/**
		 * The same level menu items in the same parent element.
		 *
		 * @type {HTMLElement[]}
		 */
		let sameLevelItems = [];

		const menuItem = toggle.closest(".menu-item-has-children");

		if (menuItem && menuItem instanceof HTMLElement) {
			sameLevelItems = dom.getSiblings(menuItem, ".menu-item-has-children");
		}

		sameLevelItems.forEach(function (item) {
			const submenuToggle = item.querySelector(".wpbf-submenu-toggle");
			if (!submenuToggle || !(submenuToggle instanceof HTMLElement)) return;
			closeMobileSubmenu(submenuToggle);
		});
	}
}
