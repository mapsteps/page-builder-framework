import { listenToCustomizerValueChange } from "../customizer-util";
import { headerBuilderEnabled } from "../../../../assets/js/utils/customizer-util";

export default function headerBuilderRevealSetup() {
	/**
	 * Handle menu reveal type changes in the customizer.
	 * This allows instant preview when switching between dropdown and off-canvas modes.
	 *
	 * @param {"mobile"|"desktop"} device The target device type.
	 */
	function listenToRevealTypeValueChange(device: "mobile" | "desktop") {
		listenToCustomizerValueChange<string>(
			`wpbf_header_builder_${device}_offcanvas_reveal_as`,
			function (settingId, value) {
				if (!headerBuilderEnabled()) return;

				if (device === "mobile") {
					handleMobileRevealTypeChange(value);
				} else {
					handleDesktopRevealTypeChange(value);
				}
			},
		);
	}

	/**
	 * Handle mobile menu reveal type changes.
	 * In the theme, only 'dropdown' mode is supported.
	 * Premium Add-On can extend this via wpbfMobileRevealTypeHandlers to add 'off-canvas' support.
	 *
	 * @param {string} value The selected reveal type (empty string, 'dropdown', or 'off-canvas' with Premium).
	 */
	function handleMobileRevealTypeChange(value: string) {
		// Find the mobile header rows container element
		const mobileHeaderRows = document.querySelector(".wpbf-mobile-header-rows");
		if (!mobileHeaderRows) return;

		// Remove all existing menu type classes to start fresh
		mobileHeaderRows.classList.remove(
			"wpbf-mobile-menu-default",
			"wpbf-mobile-menu-off-canvas",
			"wpbf-mobile-menu-dropdown",
			"wpbf-mobile-menu-hamburger",
		);

		// Reset toggle button state if it was active
		const toggle = document.querySelector(
			"#wpbf-mobile-menu-toggle",
		) as HTMLElement;

		if (toggle?.classList.contains("active")) {
			toggle.classList.remove("active");
			toggle.setAttribute("aria-expanded", "false");

			// Reset toggle button icon back to hamburger
			const headerBuilderEnabled = !!document.querySelector(
				".wpbf-navigation.use-header-builder",
			);

			if (headerBuilderEnabled) {
				const mobileMenuText = toggle.querySelector(
					".menu-trigger-button-text",
				);

				if (mobileMenuText instanceof HTMLElement) {
					// Check if the element has the 'wpbf-is-hidden' class.
					if (!mobileMenuText.classList.contains("wpbf-is-hidden")) {
						mobileMenuText.style.display = "inline-block";
					}
				}

				const svgIcon = toggle.querySelector(".menu-trigger-button-svg");

				if (svgIcon instanceof SVGElement) {
					svgIcon.style.display = "inline-block";
				}

				toggle.classList.remove("wpbff");
			} else {
				toggle.classList.add("wpbff-hamburger");
			}

			toggle.classList.remove("wpbff-times");
		}

		// Reset menu active state
		document.body.classList.remove("wpbf-mobile-menu-active");

		// Remove mobile menu overlay if present
		const mobileOverlay = document.querySelector(
			".wpbf-mobile-menu-overlay",
		) as HTMLElement;
		if (mobileOverlay) {
			mobileOverlay.classList.remove("active");
			mobileOverlay.style.display = "";
			mobileOverlay.style.opacity = "";
		}

		// Get the close button element (make sure we get the one inside mobile menu)
		const closeButton = document.querySelector(
			".wpbf-mobile-menu-container .wpbf-close",
		) as HTMLElement;

		// Reset mobile menu container states and styles
		const mobileMenuContainer = document.querySelector(
			".wpbf-mobile-menu-container",
		);
		if (mobileMenuContainer instanceof HTMLElement) {
			mobileMenuContainer.classList.remove("active");
			mobileMenuContainer.style.display = "";
			mobileMenuContainer.style.height = "";
			mobileMenuContainer.style.overflowY = "";
		}

		/**
		 * Check if Premium Add-On has registered a handler for off-canvas.
		 * Premium Add-On can register handlers via window.wpbfMobileRevealTypeHandlers.
		 */
		const handlers = (window as any).wpbfMobileRevealTypeHandlers;
		if (handlers && typeof handlers[value] === "function") {
			// Let Premium Add-On handle this reveal type
			handlers[value]({
				mobileHeaderRows,
				closeButton,
				mobileMenuContainer,
			});
			return;
		}

		// Default theme behavior: dropdown mode (for 'default' or 'dropdown').
		// Dropdown mode requires both dropdown and hamburger classes.
		mobileHeaderRows.classList.add("wpbf-mobile-menu-dropdown");
		mobileHeaderRows.classList.add("wpbf-mobile-menu-hamburger");

		// Hide close button for dropdown (if it exists from Premium)
		if (closeButton) {
			closeButton.style.display = "none";
			closeButton.style.visibility = "hidden";
		}

		// For dropdown mode, move menu back to its original position if it was in off-canvas container
		const offCanvasContainer = document.querySelector(
			".wpbf-mobile-menu-off-canvas-container",
		);
		const mobileMenu = offCanvasContainer?.querySelector(
			".wpbf-mobile-menu-container",
		);

		if (offCanvasContainer && mobileMenu) {
			// Remove the off-canvas container and restore menu position
			offCanvasContainer.parentNode?.insertBefore(
				mobileMenu,
				offCanvasContainer,
			);
			offCanvasContainer.remove();
		}
	}

	/**
	 * Handle desktop menu reveal type changes.
	 *
	 * @param {string} value The selected reveal type (off-canvas, off-canvas-left, or full-screen).
	 */
	function handleDesktopRevealTypeChange(value: string) {
		// Find the desktop menu container element
		const desktopMenuContainer = document.querySelector(
			".wpbf-menu-off-canvas, .wpbf-menu-full-screen",
		) as HTMLElement;
		if (!desktopMenuContainer) return;

		// Update push menu body classes based on reveal type
		const isPushMenu = window.wp.customize?.("menu_off_canvas_push")?.get();
		document.body.classList.remove(
			"wpbf-push-menu-left",
			"wpbf-push-menu-right",
		);
		if (isPushMenu) {
			if (value === "off-canvas-left") {
				document.body.classList.add("wpbf-push-menu-left");
			} else if (value === "off-canvas" || !value) {
				document.body.classList.add("wpbf-push-menu-right");
			}
		}

		// Reset toggle button state if it was active
		const toggle = document.querySelector("#wpbf-menu-toggle");
		if (toggle?.classList.contains("active")) {
			toggle.classList.remove("active");
		}

		// Reset menu active state
		document.body.classList.remove("wpbf-nav-active");

		// Get the close button element (make sure we get the one inside desktop menu)
		const closeButton = desktopMenuContainer.querySelector(
			".wpbf-close",
		) as HTMLElement;

		// Remove all existing menu type classes to start fresh
		desktopMenuContainer.classList.remove(
			"wpbf-menu-off-canvas",
			"wpbf-menu-off-canvas-right",
			"wpbf-menu-off-canvas-left",
			"wpbf-menu-full-screen",
		);

		// Apply appropriate classes based on selected menu type
		if (value === "off-canvas" || !value) {
			// Off-canvas right mode (default)
			desktopMenuContainer.classList.add(
				"wpbf-menu-off-canvas",
				"wpbf-menu-off-canvas-right",
			);
		} else if (value === "off-canvas-left") {
			// Off-canvas left mode
			desktopMenuContainer.classList.add(
				"wpbf-menu-off-canvas",
				"wpbf-menu-off-canvas-left",
			);
		} else if (value === "full-screen") {
			// Full-screen mode
			desktopMenuContainer.classList.add("wpbf-menu-full-screen");
		}

		// Ensure close button is visible for all desktop menu types
		if (closeButton) {
			closeButton.style.display = "flex";
			closeButton.style.visibility = "visible";
		}

		// Reset desktop menu container states and styles
		desktopMenuContainer.classList.remove("active");
		desktopMenuContainer.style.display = "";
		desktopMenuContainer.style.height = "";
		desktopMenuContainer.style.overflowY = "";

		// Reset navigation styles
		const nav = desktopMenuContainer.querySelector("nav");
		if (nav instanceof HTMLElement) {
			nav.style.height = "";
			nav.style.maxHeight = "";
			nav.style.overflowY = "";
		}

		// Remove menu overlay if present
		const overlay = document.querySelector(".wpbf-menu-overlay");
		if (overlay) {
			overlay.classList.remove("active");
		}
	}

	listenToRevealTypeValueChange("mobile");
	listenToRevealTypeValueChange("desktop");
}
