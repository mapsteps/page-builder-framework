import {
	listenToCustomizerValueChange,
	writeCSS,
	maybeAppendSuffix,
	toStringColor,
} from "../customizer-util";
import { headerBuilderEnabled } from "../../../../assets/js/utils/customizer-util";
import { WpbfColorControlValue } from "../../../../Customizer/Controls/Color/src/color-interface";

export default function offCanvasSetup(customizer?: WpbfCustomize) {
	// Hamburger size.
	listenToCustomizerValueChange<string | number>(
		"menu_off_canvas_hamburger_size",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-menu-toggle",
				props: { "font-size": maybeAppendSuffix(value) },
			});
		},
	);

	// Hamburger color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"menu_off_canvas_hamburger_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-menu-toggle",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Push menu toggle.
	listenToCustomizerValueChange<boolean>(
		"menu_off_canvas_push",
		function (settingId, value) {
			// Only run if header builder is enabled (Premium handles Legacy)
			if (!headerBuilderEnabled()) return;

			// In Header Builder mode, use reveal_as setting instead of legacy menu_position
			const revealAs = window.wp
				.customize?.("wpbf_header_builder_desktop_offcanvas_reveal_as")
				?.get();
			const body = document.body;

			// Remove existing classes first to be safe
			body.classList.remove("wpbf-push-menu-left", "wpbf-push-menu-right");

			if (value) {
				if (revealAs === "off-canvas-left") {
					body.classList.add("wpbf-push-menu-left");
				} else if (revealAs === "off-canvas" || !revealAs) {
					body.classList.add("wpbf-push-menu-right");
				}
			}
		},
	);

	// Menu width.
	listenToCustomizerValueChange<string | number>(
		"menu_off_canvas_width",
		function (settingId, value) {
			// Width for right-positioned off-canvas (default)
			writeCSS(settingId + "-left", {
				selector: ".wpbf-menu-off-canvas-left",
				props: {
					width: maybeAppendSuffix(value),
					left: `-${maybeAppendSuffix(value)}`,
				},
			});

			// Width for left-positioned off-canvas
			writeCSS(settingId + "-right", {
				selector: ".wpbf-menu-off-canvas-right",
				props: {
					width: maybeAppendSuffix(value),
					right: `-${maybeAppendSuffix(value)}`,
				},
			});

			// Push effect for left-positioned off-canvas (pushes body to the right)
			writeCSS(settingId + "-push-left", {
				selector: ".wpbf-push-menu-left.active",
				props: {
					left: maybeAppendSuffix(value),
				},
			});

			// Push effect for left-positioned off-canvas (navigation)
			writeCSS(settingId + "-push-left-nav", {
				selector: ".wpbf-push-menu-left.active .wpbf-navigation-active",
				props: {
					left: `${maybeAppendSuffix(value)} !important`,
				},
			});

			// Push effect for right-positioned off-canvas (pushes body to the left)
			writeCSS(settingId + "-push-right", {
				selector: ".wpbf-push-menu-right.active",
				props: {
					left: `-${maybeAppendSuffix(value)}`,
				},
			});

			// Push effect for right-positioned off-canvas (navigation)
			writeCSS(settingId + "-push-right-nav", {
				selector: ".wpbf-push-menu-right.active .wpbf-navigation-active",
				props: {
					left: `-${maybeAppendSuffix(value)} !important`,
				},
			});
		},
	);

	// Menu padding.
	listenToCustomizerValueChange<string | number>(
		"menu_off_canvas_padding",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-menu-off-canvas .wpbf-mobile-menu",
				props: {
					"padding-top": maybeAppendSuffix(value),
					"padding-right": maybeAppendSuffix(value),
					"padding-bottom": maybeAppendSuffix(value),
					"padding-left": maybeAppendSuffix(value),
				},
			});
		},
	);

	// Background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"menu_off_canvas_bg_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-menu-off-canvas, .wpbf-menu-full-screen",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Font size.
	listenToCustomizerValueChange<string | number>(
		"menu_off_canvas_font_size",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-menu-off-canvas .wpbf-mobile-menu a",
				props: { "font-size": maybeAppendSuffix(value) },
			});
		},
	);

	// Font color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"menu_off_canvas_font_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".wpbf-menu-off-canvas .wpbf-mobile-menu a, .wpbf-menu-off-canvas .wpbf-close",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Font color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"menu_off_canvas_font_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-menu-off-canvas .wpbf-mobile-menu a:hover",
				props: { color: toStringColor(value) },
			});
		},
	);
}
