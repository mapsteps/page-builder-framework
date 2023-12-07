import { getBreakpoints } from "./utils";

/**
 * This module is intended to handle the site wide JS functionality.
 * Except for the desktop menu and mobile menu.
 *
 * Along with the desktop-menu.js and mobile-menu.js, this file will be combined to site-min.js file.
 *
 * @param {JQuery} $ jQuery object.
 * @return {AuraSiteObject}
 */
export default function setupSite($) {
	const breakpoints = getBreakpoints();

	/**
	 * Initialize the module, call the main functions.
	 *
	 * This function is the only function that should be called on top level scope.
	 * Other functions are called / hooked from this function.
	 */
	function init() {
		setupBodyClasses();
		setupScrollToTop();
		wpcf7support();
		setupBoxedLayoutSupport();

		// On window resize, re-run the body class setup - so that it has the updated breakpoint class name.
		window.addEventListener("resize", function (e) {
			setupBodyClasses();
		});

		// Executing various triggers on window load.
		window.addEventListener("load", function () {
			$(".opacity").delay(200).animate({ opacity: "1" }, 200);

			processElements(".display-none", function (el) {
				el.style.display = "block";
			});

			window.dispatchEvent(new Event("resize"));
			window.dispatchEvent(new Event("scroll"));
		});
	}

	/**
	 * Setup body classes based on breakpoint.
	 *
	 * This function will add "wpbf-is-{device}" class to the body tag.
	 */
	function setupBodyClasses() {
		const windowWidth = document.documentElement.clientWidth;
		let bodyClass = "";

		if (windowWidth > breakpoints.desktop) {
			bodyClass = "wpbf-is-desktop";
		} else {
			if (windowWidth > breakpoints.tablet) {
				bodyClass = "wpbf-is-tablet";
			} else {
				bodyClass = "wpbf-is-mobile";
			}
		}

		document.body.classList.remove("wpbf-is-desktop");
		document.body.classList.remove("wpbf-is-tablet");
		document.body.classList.remove("wpbf-is-mobile");

		document.body.classList.add(bodyClass);
	}

	/**
	 * Setup scroll to top functionality.
	 */
	function setupScrollToTop() {
		const scrollTop = document.querySelector(".scrolltop");
		if (!scrollTop) return;

		const scrollTopValue = scrollTop.dataset.scrolltopValue;

		// Show or hide scroll-to-top button on window scroll event.
		window.addEventListener("scroll", function (e) {
			if (window.scrollY > scrollTopValue) {
				$(".scrolltop").fadeIn();
			} else {
				$(".scrolltop").fadeOut();
			}
		});

		// Scroll to top functionality.
		addEventHandler("click", ".scrolltop", function (e) {
			document.body.tabIndex = -1;
			document.body.focus();
			this.blur();
			$("body, html").animate({ scrollTop: 0 }, 500);
		});
	}

	/**
	 * Support for Contact Form 7.
	 */
	function wpcf7support() {
		processElements(".wpcf7-form-control-wrap", function (el) {
			el.addEventListener("mouseenter", function () {
				$(".wpcf7-not-valid-tip", el).fadeOut();
			});
		});
	}

	/**
	 * Setup support for boxed layout mode.
	 */
	function setupBoxedLayoutSupport() {
		const page = document.querySelector(".wpbf-page");
		if (!page) return;

		/** @type {string} */
		const pageMarginTop = window.getComputedStyle(page).marginTop;

		window.addEventListener("resize", function () {
			/** @type {number} */
			const pageWidth = page.offsetWidth;

			// If page width is >= window width, then remove margin top & margin bottom.
			if (pageWidth >= documument.documentElement.clientWidth) {
				page.style.marginTop = "0";
				page.style.marginBottom = "0";
			} else {
				// Otherwise, add the margin top & margin bottom.
				page.style.marginTop = pageMarginTop;
				page.style.marginBottom = pageMarginTop;
			}
		});
	}

	// Run the module.
	init();
}
