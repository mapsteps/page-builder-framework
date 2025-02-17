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
		// Check for variant menus first
		let menu = document.querySelector(".wpbf-mobile-menu-variant-1");
		if (menu) {
			menuType = "variant-1";
			return;
		}

		menu = document.querySelector(".wpbf-mobile-menu-variant-2");
		if (menu) {
			menuType = "variant-2";
			return;
		}

		menu = document.querySelector(".wpbf-mobile-menu-variant-3");
		if (menu) {
			menuType = "variant-3";
			return;
		}

		menu = document.querySelector(".wpbf-mobile-menu-none");
		if (menu) {
			menuType = "none";
			return;
		}

		// Check for default menu type
		menu = document.querySelector(".wpbf-mobile-menu-default");
		if (menu) {
			menuType = "default";
			return;
		}

		// Finally, check for hamburger menu
		menu = document.querySelector(".wpbf-mobile-menu-hamburger");
		if (menu) {
			menuType = "hamburger";
			return;
		}

		// If no menus are found, fall back to premium
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

	/**
	 * Patch mobile nav overflow-y.
	 *
	 * @param {string} overflow The overflow value.
	 */
	function patchMobileNavOverflowY(overflow) {
		const mobileNav = dom.findHtmlEl("#mobile-navigation");
		if (!mobileNav) return;

		mobileNav.style.overflowY = overflow;
	}

	const animScope = "mobile-menu-anim";

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
		const toggle = dom.findHtmlEl("#wpbf-mobile-menu-toggle");
		const mobileMenu = dom.findHtmlEl(".wpbf-mobile-menu-container");

		if (mobileMenu && !mobileMenu.classList.contains("active")) {
			patchMobileNavOverflowY("hidden");

			// Slide down the mobile menu (simulating slideDown behavior in vanilla JS).
			anim.slideToggle({
				el: mobileMenu,
				direction: "down",
				callback: () => {
					mobileMenu.classList.add("active");
					patchMobileNavOverflowY("auto");
				},
				animScope: animScope,
			});
		}

		if (toggle) {
			toggle.classList.add("active");
			toggle.setAttribute("aria-expanded", "true");

			// Handle hamburger menu type
			if ("hamburger" === menuType) {
				toggle.classList.remove("wpbff-hamburger");
				toggle.classList.add("wpbff-times");
			} else {
				// Handle other menu types (non-hamburger).
				// Find existing SVG.
				const svgIcon = toggle.querySelector("svg.ct-icon");
				const closeIconSvg = `
                <svg class="ct-icon close-icon" width="1em" height="1em" viewBox="0 0 32 28" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <line x1="6" y1="6" x2="26" y2="26" stroke="currentColor" stroke-width="2"></line>
                    <line x1="6" y1="26" x2="26" y2="6" stroke="currentColor" stroke-width="2"></line>
                </svg>`;

				// Hide the existing SVG icon (if present).
				if (svgIcon) {
					svgIcon.style.display = "none";
				}

				const mobileMenuText = toggle.querySelector(".mobile-menu-text");
				if (mobileMenuText) {
					mobileMenuText.style.display = "none";
				}

				if (svgIcon) {
					svgIcon.style.display = "none";
				}

				// Check if the close icon is already inserted to avoid duplicates.
				if (!toggle.querySelector(".close-icon")) {
					toggle.insertAdjacentHTML("beforeend", closeIconSvg);
				}

				toggle.classList.remove("wpbff-hamburger");
				toggle.classList.remove("wpbff-times");
			}
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
		const toggle = dom.findHtmlEl("#wpbf-mobile-menu-toggle");

		// If toggle is not active, do nothing.
		if (!toggle || !toggle.classList.contains("active")) return;

		const mobileMenu = dom.findHtmlEl(".wpbf-mobile-menu-container");

		if (mobileMenu && mobileMenu.classList.contains("active")) {
			patchMobileNavOverflowY("hidden");

			// Slide up the mobile menu (simulating slideUp behavior in vanilla JS).
			anim.slideToggle({
				el: mobileMenu,
				direction: "up",
				callback: () => {
					mobileMenu.classList.remove("active");
				},
				animScope: animScope,
			});
		}

		// Reset the toggle button state.
		if (toggle) {
			toggle.classList.remove("active");
			toggle.setAttribute("aria-expanded", "false");

			// Handle different menu types.
			if ("hamburger" === menuType) {
				toggle.classList.remove("wpbff-times");
				toggle.classList.add("wpbff-hamburger");

				// Restore the original SVG (if any).
				const svgIcon = toggle.querySelector("svg.ct-icon");
				if (svgIcon) {
					// Make the original SVG visible again.
					svgIcon.style.display = "inline-block";
				}

				// Remove the close icon (if any).
				const closeIcon = toggle.querySelector(".close-icon");
				if (closeIcon) {
					closeIcon.remove();
				}
			} else {
				// Remove the close icon (if any) for non-hamburger variants.
				const closeIcon = toggle.querySelector(".close-icon");
				if (closeIcon) {
					closeIcon.remove();
				}

				// Show the original SVG icon for non-hamburger menu types.
				const svgIcon = toggle.querySelector("svg.ct-icon");
				if (svgIcon) {
					// Make it visible again.
					svgIcon.style.display = "inline-block";
				}

				const mobileMenuText = toggle.querySelector(".mobile-menu-text");
				if (mobileMenuText) {
					// Make the original SVG visible again.
					mobileMenuText.style.display = "inline-block";
				}

				toggle.classList.remove("wpbff-times");

				// Handle different menu variants (variant-1, variant-2, variant-3).
				if (menuType === "variant-1") {
					toggle.classList.add("wpbff-variant-1");
				} else if (menuType === "variant-2") {
					toggle.classList.add("wpbff-variant-2");
				} else if (menuType === "variant-3") {
					toggle.classList.add("wpbff-variant-3");
				}
			}
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
			anim.slideToggle({
				el: submenu,
				direction: "down",
				callback: () => {},
				animScope: submenuAnimScope,
			});
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
			anim.slideToggle({
				el: submenu,
				direction: "up",
				callback: () => {},
				animScope: submenuAnimScope,
			});
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
