import { getBreakpoints } from "../utils/dom-util";

/**
 * Set up site wide JS functionality.
 *
 * This file will be imported from site-jquery.js file.
 *
 * @param {JQueryStatic} $ - jQuery object.
 * @return {LegacyWpbfTheme}
 */
export default function setupjQuerySite($) {
	/**
	 * Whether we're inside customizer or not.
	 *
	 * @type {boolean}
	 */
	// @ts-ignore
	const isInsideCustomizer = window.wp && window.wp.customize ? true : false;

	const breakpoints = getBreakpoints();

	/**
	 * The current active breakpoint.
	 *
	 * @type {string}
	 */
	let activeBreakpoint = "desktop";

	// Run the module.
	init();

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

		/**
		 * Executing various triggers on window load.
		 */
		window.addEventListener("load", function () {
			$(".opacity").delay(200).animate({ opacity: "1" }, 200);
			$(".display-none").show();
			$(window).trigger("resize");
			$(window).trigger("scroll");
		});
	}

	/**
	 * Setup body classes based on breakpoint.
	 *
	 * This function will add "wpbf-is-{device}" class to the body tag.
	 * It will also set the the top level `activeBreakpoint` variable.
	 */
	function setupBodyClasses() {
		const windowWidth = $(window).width();
		let bodyClass = "";

		if (windowWidth) {
			if (windowWidth > breakpoints.desktop) {
				bodyClass = "wpbf-is-desktop";
				activeBreakpoint = "desktop";
			} else {
				if (windowWidth > breakpoints.tablet) {
					bodyClass = "wpbf-is-tablet";
					activeBreakpoint = "tablet";
				} else {
					bodyClass = "wpbf-is-mobile";
					activeBreakpoint = "mobile";
				}
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
		const scrolltopEl = document.querySelector(".scrolltop");
		if (!scrolltopEl || !(scrolltopEl instanceof HTMLElement)) return;

		const dataScrolltop = scrolltopEl.dataset.scrolltopValue;
		const scrollTopSetting = dataScrolltop ? parseFloat(dataScrolltop) : 0;

		// Show or hide scroll-to-top button on window scroll event.
		window.addEventListener("scroll", function (e) {
			const scrollTopValue = $(this).scrollTop();

			if (scrollTopValue && scrollTopValue > scrollTopSetting) {
				scrolltopEl.classList.add("is-visible");
			} else {
				scrolltopEl.classList.remove("is-visible");
			}
		});

		// Scroll to top functionality.
		$(document).on("click", ".scrolltop", function () {
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
		$(".wpcf7-form-control-wrap").on("mouseenter", function () {
			$(".wpcf7-not-valid-tip", this).fadeOut();
		});
	}

	/**
	 * Setup support for boxed layout mode.
	 */
	function setupBoxedLayoutSupport() {
		const $page = $(".wpbf-page");
		const pageMarginTop = $page.css("margin-top");

		window.addEventListener("resize", function () {
			const pageWidth = $page.width();
			const windowWidth = $(window).width();

			// If page width is >= window width, then remove margin top & margin bottom.
			if (pageWidth && windowWidth && pageWidth >= windowWidth) {
				$page.css({ "margin-top": "0", "margin-bottom": "0" });
			} else {
				// Otherwise, add the margin top & margin bottom.
				$page.css({
					"margin-top": pageMarginTop,
					"margin-bottom": pageMarginTop,
				});
			}
		});
	}

	return {
		isInsideCustomizer: isInsideCustomizer,
		breakpoints: breakpoints,
		activeBreakpoint: activeBreakpoint,
	};
}
