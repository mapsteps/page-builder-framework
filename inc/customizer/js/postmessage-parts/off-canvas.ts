import {
	listenToCustomizerValueChange,
	writeCSS,
	maybeAppendSuffix,
	toStringColor,
} from "../customizer-util";
import { WpbfColorControlValue } from "../../../../Customizer/Controls/Color/src/color-interface";
import { headerBuilderEnabled } from "../../../../assets/js/utils/customizer-util";

export default function offCanvasSetup(customizer?: WpbfCustomize) {
	// Hamburger size.
	listenToCustomizerValueChange<string | number>(
		"off_canvas_hamburger_size",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-menu-toggle",
				props: { "font-size": maybeAppendSuffix(value) },
			});
		},
	);

	// Hamburger color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"off_canvas_hamburger_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-menu-toggle",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Menu width.
	listenToCustomizerValueChange<string | number>(
		"off_canvas_width",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-off-canvas-menu",
				props: { width: maybeAppendSuffix(value) },
			});

			writeCSS(settingId + "-push", {
				selector:
					".wpbf-off-canvas-menu.wpbf-off-canvas-menu-push.active ~ .wpbf-inner-body, .wpbf-off-canvas-menu.wpbf-off-canvas-menu-push.active ~ .wpbf-fixed-header",
				props: {
					transform: `translateX(-${maybeAppendSuffix(value)})`,
				},
			});

			writeCSS(settingId + "-push-left", {
				selector:
					".wpbf-off-canvas-menu.wpbf-off-canvas-menu-left.wpbf-off-canvas-menu-push.active ~ .wpbf-inner-body, .wpbf-off-canvas-menu.wpbf-off-canvas-menu-left.wpbf-off-canvas-menu-push.active ~ .wpbf-fixed-header",
				props: {
					transform: `translateX(${maybeAppendSuffix(value)})`,
				},
			});
		},
	);

	// Menu padding.
	listenToCustomizerValueChange<string | number>(
		"off_canvas_padding",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-off-canvas-menu .wpbf-mobile-menu",
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
		"off_canvas_bg_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-off-canvas-menu",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Font size.
	listenToCustomizerValueChange<string | number>(
		"off_canvas_font_size",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-off-canvas-menu .wpbf-mobile-menu a",
				props: { "font-size": maybeAppendSuffix(value) },
			});
		},
	);

	// Font color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"off_canvas_font_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".wpbf-off-canvas-menu .wpbf-mobile-menu a, .wpbf-off-canvas-menu .wpbf-close",
				props: { color: toStringColor(value) },
			});
		},
	);

	// Font color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"off_canvas_font_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-off-canvas-menu .wpbf-mobile-menu a:hover",
				props: { color: toStringColor(value) },
			});
		},
	);
}
