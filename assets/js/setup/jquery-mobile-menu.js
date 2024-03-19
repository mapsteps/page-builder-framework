import { getBreakpoints } from "../utils/dom-util";

/**
 * Set up mobile menu JS functionality.
 *
 * This file will be imported from site-jquery.js file.
 *
 * @param {JQueryStatic} $ - jQuery object.
 */
export default function setupjQueryMobileMenu($) {
	let breakpoints = getBreakpoints();

	/**
	 * The menu type.
	 * The value could be 'hamburger', 'default', or 'premium'.
	 *
	 * @type {string}
	 */
	let menuType;

	// Run the module.
	init();

	/**
	 * Initialize the module, call the main functions.
	 *
	 * This function is the only function that should be called on top level scope.
	 * Other functions are called / hooked from this function.
	 */
	function init() {
		// On window resize, get the updated breakpoints.
		window.addEventListener("resize", function (e) {
			breakpoints = getBreakpoints();
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
		if (document.querySelector(".wpbf-mobile-menu-hamburger")) {
			menuType = "hamburger";
			return;
		}

		if (document.querySelector(".wpbf-mobile-menu-default")) {
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
		$(document).on("click", ".wpbf-mobile-menu a", function () {
			// Stop if menu type is 'premium'.
			if ("premium" === menuType) return;

			// Stop if href doesn't contain hash.
			if (!this.href.match("#") && !this.href.match("/#")) return;

			const hasSubmenu = this.parentNode.classList.contains(
				"menu-item-has-children",
			);

			// If the link doesn't have sub-menu, then simply close the mobile menu.
			if (!hasSubmenu) {
				closeMobileMenu(menuType);
			} else {
				if ($(this).closest(".wpbf-mobile-mega-menu").length) {
					// But the link has sub-menu, and its top level parent menu item is a mega menu, then close the mobile menu.
					closeMobileMenu(menuType);
				} else {
					// And if its top level parent menu item is not a mega menu, then toggle it's sub-menu.
					toggleMobileSubmenuOnHashLinkClick(this);
				}
			}
		});
	}

	/**
	 * Toggle submenu on hash link click.
	 *
	 * @param {HTMLElement} link - The anchor element of the menu item.
	 */
	function toggleMobileSubmenuOnHashLinkClick(link) {
		const $toggle = $(link).siblings(".wpbf-submenu-toggle");
		if (!$toggle.length) return;
		const toggle = $toggle[0];

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
		$(document).on("click", ".wpbf-mobile-menu-toggle", function () {
			setupMenuType();
			toggleMobileMenu(menuType);
		});

		// On window resize, if the window width is wider than desktop breakpoint, then hide the mobile menu.
		$(window).resize(function () {
			const windowHeight = $(window).height();
			const windowWidth = $(window).width();

			if (windowHeight) {
				const mobileNavWrapperHeight = $(
					".wpbf-mobile-nav-wrapper",
				).outerHeight();

				if (mobileNavWrapperHeight) {
					$(".wpbf-mobile-menu-container.active nav").css({
						"max-height": windowHeight - mobileNavWrapperHeight,
					});
				}
			}

			if (windowWidth && windowWidth > breakpoints.desktop) {
				closeMobileMenu(menuType);
			}
		});
	}

	/**
	 * Toggle the mobile menu to open or close.
	 * This won't run if the menu type is 'premium'.
	 *
	 * @param {string} menuType - The menu type. Accepts 'default' or 'hamburger'.
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
	 * Open mobile menu.
	 * This function is only being called inside `toggleMobileMenu` function.
	 *
	 * But let the menuType and toggle checking stay inside.
	 * We may call this function directly outside of `toggleMobileMenu` function in the future.
	 *
	 * @param {string} menuType - The menu type. Accepts 'hamburger' or 'default'.
	 */
	function openMobileMenu(menuType) {
		if ("premium" === menuType) return;

		// Toggle here is the mobile menu toggle button.
		const toggle = document.querySelector("#wpbf-mobile-menu-toggle");
		if (!toggle) return;

		$(".wpbf-mobile-menu-container").addClass("active").stop().slideDown();
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
	 * @param {string} menuType - The menu type. Accepts 'hamburger' or 'default'.
	 */
	function closeMobileMenu(menuType) {
		if ("premium" === menuType) return;

		// Toggle here is the mobile menu toggle button.
		const toggle = document.querySelector("#wpbf-mobile-menu-toggle");
		if (!toggle) return;

		// Because this function is also being called directly in several places, then we need this checking.
		if (!toggle.classList.contains("active")) return;

		$(".wpbf-mobile-menu-container").removeClass("active").stop().slideUp();
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
	 * @param {string} menuType - The menu type. Accepts 'hamburger' or 'default'.
	 */
	function setupMobileSubmenuToggle(menuType) {
		const menuClass =
			menuType === "hamburger"
				? ".wpbf-mobile-menu-hamburger .wpbf-submenu-toggle"
				: ".wpbf-mobile-menu-default .wpbf-submenu-toggle";

		$(document).on("click", menuClass, function (e) {
			e.preventDefault();
			toggleMobileSubmenu(this);
		});
	}

	/**
	 * Toggle mobile sub-menu to expand/collapse.
	 *
	 * @param {HTMLElement} toggle - The submenu's toggle button (the expand/collapse arrow).
	 */
	function toggleMobileSubmenu(toggle) {
		if (toggle.classList.contains("active")) {
			closeMobileSubmenu(toggle);
		} else {
			openMobileSubmenu(toggle);
		}
	}

	/**
	 * Open mobile submenu.
	 *
	 * @param {HTMLElement} toggle - The submenu's toggle button (the expand/collapse arrow).
	 */
	function openMobileSubmenu(toggle) {
		$("i", toggle).removeClass("wpbff-arrow-down").addClass("wpbff-arrow-up");
		toggle.classList.add("active");
		toggle.setAttribute("aria-expanded", "true");
		$(toggle).siblings(".sub-menu").stop().slideDown();

		autoCollapseMobileSubmenus(toggle);
	}

	/**
	 * Close mobile submenu.
	 *
	 * @param {HTMLElement} toggle - The submenu's toggle button (the expand/collapse arrow).
	 */
	function closeMobileSubmenu(toggle) {
		$("i", toggle).removeClass("wpbff-arrow-up").addClass("wpbff-arrow-down");
		toggle.classList.remove("active");
		toggle.setAttribute("aria-expanded", "false");
		$(toggle).siblings(".sub-menu").stop().slideUp();
	}

	/**
	 * Auto collapse other opened mobile submenu.
	 *
	 * Open the sub-menu of current clicked menu item,
	 * and hide the other sub-menus (with the same level, in the same parent element).
	 *
	 * @param {HTMLElement} toggle - The submenu's toggle button (the expand/collapse arrow) of the current clicked menu item.
	 */
	function autoCollapseMobileSubmenus(toggle) {
		// If wpbf navigation doesn't have mobile submenu collapse class, then stop here.
		if (
			!$(toggle)
				.closest(".wpbf-navigation")
				.hasClass("wpbf-mobile-sub-menu-auto-collapse")
		) {
			return;
		}

		// The same level menu items in the same parent element.
		const $sameLevelItems = $(toggle)
			.closest(".menu-item-has-children")
			.siblings(".menu-item-has-children");

		$sameLevelItems.each(function (i, menuItem) {
			const submenuToggle = menuItem.querySelector(".wpbf-submenu-toggle");
			if (submenuToggle && submenuToggle instanceof HTMLElement) {
				closeMobileSubmenu(submenuToggle);
			}
		});
	}
}
