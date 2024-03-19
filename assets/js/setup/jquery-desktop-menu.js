/**
 * Set up desktop menu JS functionality.
 *
 * This file will be imported from site-jquery.js file.
 *
 * @param {JQueryStatic} $ - jQuery object.
 */
export default function setupjQueryDesktopMenu($) {
	/**
	 * Whether we're inside customizer or not.
	 *
	 * @type {boolean}
	 */
	// @ts-ignore
	const isInsideCustomizer = window.WpbfTheme.isInsideCustomizer;

	/**
	 * The sub-menu animation duration.
	 */
	let duration = parseInt(
		$(".wpbf-navigation").data("sub-menu-animation-duration"),
		10,
	);

	// Run the module.
	init();

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
		if (isInsideCustomizer) {
			// @ts-ignore
			window.wp.customize.bind("preview-ready", function () {
				listenPartialRefresh();
			});
		}
	}

	/**
	 * Setup search interaction of the search button inside the menu item.
	 */
	function setupMenuItemSearchButton() {
		// Expand search field on click.
		$(document).on("click", ".wpbf-menu-item-search", expandSearchField);

		// Close search on window click.
		window.addEventListener("click", function (e) {
			closeSearchField();
		});

		// Close search on escape or tab.
		document.addEventListener("keyup", closeSearchFieldOnEscOrTab);
	}

	/**
	 * Expand search field when search menu item is clicked.
	 *
	 * @param {JQuery.ClickEvent} e - The click event.
	 * @this {HTMLElement}
	 */
	function expandSearchField(e) {
		e.stopPropagation();

		$(".wpbf-navigation .wpbf-menu > li").slice(-3).addClass("calculate-width");

		let itemWidth = 0;

		$(".calculate-width").each(function (i, el) {
			const outerWidth = $(el).outerWidth();
			if (outerWidth) itemWidth += outerWidth;
		});

		if (itemWidth < 200) {
			itemWidth = 250;
		}

		if (!this.classList.contains("active")) {
			this.classList.add("active");
			this.setAttribute("aria-expanded", "true");

			$(".wpbf-menu-search", this)
				.stop()
				.css({ display: "block" })
				.animate({ width: itemWidth, opacity: "1" }, 200);

			$("input[type=search]", this).val("").focus();
		}
	}

	/**
	 * Close search field when esc key is pressed or focus is moved by pressing tab key.
	 *
	 * @param {KeyboardEvent} e - They keyup event.
	 */
	function closeSearchFieldOnEscOrTab(e) {
		if (e.key === "Escape" || e.key === "Esc") {
			closeSearchField();
		} else if (e.key === "Tab") {
			const target = e.target;

			if (
				target instanceof HTMLElement &&
				!target.classList.contains("wpbff-search")
			) {
				closeSearchField();
			}
		}
	}

	/**
	 * Close search field functionality.
	 */
	function closeSearchField() {
		if ($(".wpbf-menu-item-search").hasClass("active")) {
			$(".wpbf-menu-search")
				.stop()
				.animate({ opacity: "0", width: "0px" }, 250, function () {
					this.style.display = "none";
				});

			setTimeout(function () {
				$(".wpbf-menu-item-search")
					.removeClass("active")
					.attr("aria-expanded", "false");
			}, 400);
		}
	}

	/**
	 * Listen to WordPress selective refresh (partial refresh) inside customizer.
	 */
	function listenPartialRefresh() {
		// @ts-ignore
		window.wp.customize.selectiveRefresh.bind(
			"partial-content-rendered",
			/**
			 * @param {unknown} placement
			 */
			function (placement) {
				/**
				 * A lot of partial refresh registered to work on header area.
				 * Better to not checking the "placement.partial.id".
				 */
				duration = parseInt(
					$(".wpbf-navigation").data("sub-menu-animation-duration"),
					10,
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

		const totalMenuItems = $(
			".wpbf-navigation .wpbf-menu-centered .wpbf-menu > li > a",
		).length;

		let divided = totalMenuItems / 2;

		divided = Math.floor(divided);
		divided = divided - 1;

		// Place the logo in the center of the menu.
		$(".wpbf-menu-centered .logo-container")
			.insertAfter(
				".wpbf-navigation .wpbf-menu-centered .wpbf-menu >li:eq(" +
					divided +
					")",
			)
			.css({ display: "block" });
	}

	/**
	 * Setup sub-menu animation - second level.
	 */
	function setup2ndLevelSubmenuAnimation() {
		$(document)
			.on(
				"mouseenter",
				".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .menu-item-has-children",
				function () {
					$(".sub-menu", this)
						.first()
						.stop()
						.css({ display: "block" })
						.animate({ opacity: "1" }, duration);
				},
			)
			.on(
				"mouseleave",
				".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .menu-item-has-children",
				function () {
					$(".sub-menu", this)
						.first()
						.stop()
						.animate({ opacity: "0" }, duration, function () {
							this.style.display = "none";
						});
				},
			);
	}

	/**
	 * Setup sub-menu animation - fade.
	 */
	function setupSubmenuFadeAnimation() {
		$(document)
			.on(
				"mouseenter",
				".wpbf-sub-menu-animation-fade > .menu-item-has-children",
				function () {
					$(".sub-menu", this).first().stop().fadeIn(duration);
				},
			)
			.on(
				"mouseleave",
				".wpbf-sub-menu-animation-fade > .menu-item-has-children",
				function () {
					$(".sub-menu", this).first().stop().fadeOut(duration);
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
		$(".menu-item-has-children").each(function (i, el) {
			$(el).attr("aria-haspopup", "true");
		});

		// Add using-mouse class on mousedown.
		document.body.addEventListener("mousedown", function () {
			this.classList.add("using-mouse");
			$(".menu-item-has-children").removeClass("wpbf-sub-menu-focus");
		});

		// Remove using-mouse class on keydown.
		document.body.addEventListener("keydown", function () {
			this.classList.remove("using-mouse");
		});

		setupSubmenuItemNavEvents();

		// Setup tab navigation.
		$(document).on("focus", ".wpbf-sub-menu a", onNavLinkFocus);
	}

	/**
	 * General logic for tab/hover navigation on desktop navigations that contain sub-menus.
	 */
	function setupSubmenuItemNavEvents() {
		// Applies only to sub-menus that are not triggered by tab navigation.
		$(document).on(
			"mouseenter",
			".wpbf-sub-menu > .menu-item-has-children:not(.wpbf-sub-menu-focus)",
			function (e) {
				// Remove visual focus if tab-navigation was used earlier.
				document.body.classList.add("using-mouse");

				// Remove "wpbf-sub-menu-focus" class if tab-navigation was used earlier.
				$(".menu-item-has-children").removeClass("wpbf-sub-menu-focus");

				// Focus on the current menu item. This will help if tab-navigation was used earlier.
				$(this).find("> a").trigger("focus");
			},
		);

		// Applies to sub-menu items that have children and is focused.
		$(document).on(
			"mouseleave",
			".wpbf-sub-menu > .menu-item-has-children.wpbf-sub-menu-focus",
			function () {
				this.classList.remove("wpbf-sub-menu-focus");
			},
		);
	}

	/**
	 * Function to run on navigation-link focus for tab navigation.
	 *
	 * @param {JQuery.FocusEvent} e
	 * @this {HTMLElement}
	 */
	function onNavLinkFocus(e) {
		// Stop here if body has "using-mouse" class.
		if ($("body").hasClass("using-mouse")) return;

		// Remove "wpbf-sub-menu-focus" class everywhere.
		$(".wpbf-sub-menu > .menu-item-has-children").removeClass(
			"wpbf-sub-menu-focus",
		);

		// Hide other sub-menus that could be open due to mouse hover interference.
		$(".wpbf-sub-menu > .menu-item-has-children > .sub-menu").stop().hide();

		// Add "wpbf-sub-menu-focus" class to the current parent menu item that has children.
		$(this).parents(".menu-item-has-children").addClass("wpbf-sub-menu-focus");
	}
}
