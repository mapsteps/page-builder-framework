import {
	listenToCustomizerValueChange,
	emptyNotZero,
	writeCSS,
	writeResponsiveCSSMultiSelector,
	maybeAppendSuffix,
	toStringColor,
} from "../customizer-util";
import { parseJsonOrUndefined } from "../../../../Customizer/Controls/Generic/src/string-util";
import { MarginPaddingValue } from "../../../../Customizer/Controls/MarginPadding/src/margin-padding-interface";
import { WpbfColorControlValue } from "../../../../Customizer/Controls/Color/src/color-interface";

export default function layoutSetup($: JQueryStatic) {
	// Page width.
	listenToCustomizerValueChange<string | number>(
		"page_max_width",
		function (settingId, value) {
			value = emptyNotZero(value) ? "1200px" : value;

			writeCSS(settingId, {
				selector: ".wpbf-container, .wpbf-boxed-layout .wpbf-page",
				props: {
					"max-width": maybeAppendSuffix(value),
				},
			});
		},
	);

	// Padding.
	listenToCustomizerValueChange<string | MarginPaddingValue>(
		"page_padding",
		function (settingId, value) {
			const obj = parseJsonOrUndefined<MarginPaddingValue>(value);

			writeResponsiveCSSMultiSelector(settingId, {
				desktop: {
					selector: "#inner-content",
					props: {
						"padding-top": maybeAppendSuffix(obj?.desktop_top),
						"padding-right": maybeAppendSuffix(obj?.desktop_right),
						"padding-bottom": maybeAppendSuffix(obj?.desktop_bottom),
						"padding-left": maybeAppendSuffix(obj?.desktop_left),
					},
				},
				tablet: {
					selector: "#inner-content",
					props: {
						"padding-top": maybeAppendSuffix(obj?.tablet_top),
						"padding-right": maybeAppendSuffix(obj?.tablet_right),
						"padding-bottom": maybeAppendSuffix(obj?.tablet_bottom),
						"padding-left": maybeAppendSuffix(obj?.tablet_left),
					},
				},
				mobile: {
					selector: "#inner-content",
					props: {
						"padding-top": maybeAppendSuffix(obj?.mobile_top),
						"padding-right": maybeAppendSuffix(obj?.mobile_right),
						"padding-bottom": maybeAppendSuffix(obj?.mobile_bottom),
						"padding-left": maybeAppendSuffix(obj?.mobile_left),
					},
				},
			});
		},
	);

	// Boxed margin.
	listenToCustomizerValueChange<string | number>(
		"page_boxed_margin",
		function (settingId, value) {
			$(".wpbf-page")
				.css("margin-top", value + "px")
				.css("margin-bottom", value + "px");
		},
	);

	// Boxed padding.
	listenToCustomizerValueChange<string | number>(
		"page_boxed_padding",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-container",
				props: {
					"padding-left": maybeAppendSuffix(value),
					"padding-right": maybeAppendSuffix(value),
				},
			});
		},
	);

	// Boxed background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"page_boxed_background",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-page",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// ScrollTop position.
	listenToCustomizerValueChange<string>(
		"scrolltop_position",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".scrolltop",
				props: {
					left: value === "left" ? "20px" : "auto",
					right: value === "left" ? "auto" : "20px",
				},
			});
		},
	);

	// ScrollTop background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"scrolltop_bg_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".scrolltop",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// ScrollTop background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"scrolltop_bg_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".scrolltop:hover",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// ScrollTop icon color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"scrolltop_icon_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".scrolltop",
				props: { color: toStringColor(value) },
			});
		},
	);

	// ScrollTop icon color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"scrolltop_icon_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".scrolltop:hover",
				props: { color: toStringColor(value) },
			});
		},
	);

	// ScrollTop border radius.
	listenToCustomizerValueChange<string | number>(
		"scrolltop_border_radius",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".scrolltop",
				props: { borderRadius: maybeAppendSuffix(value) },
			});
		},
	);
}
