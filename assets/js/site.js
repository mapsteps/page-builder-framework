var WpbfTheme = {};

/**
 * This module is intended to handle the site wide JS functionality.
 * Except for the desktop menu and mobile menu.
 *
 * Along with the desktop-menu.js and mobile-menu.js, this file will be combined to site-min.js file.
 *
 * @param {Object} $ jQuery object.
 * @return {Object}
 */
WpbfTheme.site = (function ($) {
	/**
	 * Whether we're inside customizer or not.
	 *
	 * @type {boolean}
	 */
	var isInsideCustomizer = window.wp && wp.customize ? true : false;

	/**
	 * Pre-defined breakpoints.
	 *
	 * @type {Object}
	 */
	var breakpoints = {
		desktop: 1024,
		tablet: 768,
		mobile: 480,
	};

	/**
	 * The current active breakpoint.
	 *
	 * @type {string}
	 */
	var activeBreakpoint = "desktop";

	// Run the module.
	init();

	/**
	 * Initialize the module, call the main functions.
	 *
	 * This function is the only function that should be called on top level scope.
	 * Other functions are called / hooked from this function.
	 */
	function init() {
		setupBreakpoints();
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
	 * Iterates over a collection of elements and applies a function to each.
	 *
	 * @param {NodeList|string} target - Either a NodeList obtained from document.querySelectorAll() or a CSS selector string.
	 * @param {function(Element)} handler - The function to be applied to each element. Accepts one parameter, which is the element.
	 *
	 * @returns {void}
	 */
	function processElements(target, handler) {
		if (!(target instanceof NodeList) && typeof target !== "string") return;
		if (typeof handler !== "function") return;

		var elms =
			target instanceof NodeList ? target : document.querySelectorAll(target);
		if (!elms.length) return;

		for (var i = 0; i < elms.length; i++) {
			handler(elms[i]);
		}
	}

	/**
	 * Add event handler to the document.
	 *
	 * @param {string} eventType - The event type.
	 * @param {string|null} selector - The selector.
	 * @param {function(Event)} handler - The event handler.
	 */
	function addEventHandler(eventType, selector, handler) {
		if (typeof eventType !== "string") return;
		if (typeof selector !== "function") return;

		document.addEventListener(eventType, function (e) {
			if (selector) {
				if (!e.target || !e.target.matches) return;
				if (!e.target.matches(selector)) return;
			}

			handler(e);
		});
	}

	/**
	 * Setup breakpoints for desktop, tablet, and mobile.
	 */
	function setupBreakpoints() {
		setupBreakpoint("desktop");
		setupBreakpoint("tablet");
		setupBreakpoint("mobile");
	}

	/**
	 * Setup body classes based on breakpoint.
	 *
	 * This function will add "wpbf-is-{device}" class to the body tag.
	 * It will also set the the top level `activeBreakpoint` variable.
	 */
	function setupBodyClasses() {
		var windowWidth = document.documentElement.clientWidth;
		var bodyClass = "";

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

		document.body.classList.remove("wpbf-is-desktop");
		document.body.classList.remove("wpbf-is-tablet");
		document.body.classList.remove("wpbf-is-mobile");

		document.body.classList.add(bodyClass);
	}

	/**
	 * Setup breakpoint by device type.
	 *
	 * Retrieve breakpoint based on body class,
	 * then set it as the value of top level `breakpoints` variable.
	 *
	 * @param {string} device The device type. Accepts 'desktop', 'tablet', or 'mobile'.
	 */
	function setupBreakpoint(device) {
		var matchRule = "wpbf-" + device + "-breakpoint-[\\w-]*\\b";
		var breakpointClass = document.body.className.match(matchRule);

		if (null != breakpointClass) {
			breakpoints[device] = breakpointClass.toString().match(/\d+/);
			breakpoints[device] = Array.isArray(breakpoints[device])
				? breakpoints[device][0]
				: breakpoints[device];
		}
	}

	/**
	 * Setup scroll to top functionality.
	 */
	function setupScrollToTop() {
		var scrollTop = document.querySelector(".scrolltop");
		if (!scrollTop) return;

		var scrollTopValue = scrollTop.dataset.scrolltopValue;

		// Show or hide scroll-to-top button on window scroll event.
		window.addEventListener("scroll", function (e) {
			if ($(this).scrollTop() > scrollTopValue) {
				$(".scrolltop").fadeIn();
			} else {
				$(".scrolltop").fadeOut();
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
		var $page = $(".wpbf-page");
		var pageMarginTop = $page.css("margin-top");

		window.addEventListener("resize", function () {
			var pageWidth = $page.width();

			// If page width is >= window width, then remove margin top & margin bottom.
			if (pageWidth >= documument.documentElement.clientWidth) {
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
		processElements: processElements,
		addEventHandler: addEventHandler,
	};
})(jQuery);
