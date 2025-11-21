import {
	listenToCustomizerValueChange,
	writeCSS,
	maybeAppendSuffix,
	toStringColor,
} from "../customizer-util";
import { WpbfColorControlValue } from "../../../../Customizer/Controls/Color/src/color-interface";

export default function buttonsSetup() {
	// Background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"button_bg_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					'.wpbf-button:not(.wpbf-button-primary), input[type="submit"]',
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Background color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"button_bg_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					'.wpbf-button:not(.wpbf-button-primary):hover, input[type="submit"]:hover',
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Text color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"button_text_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					'.wpbf-button:not(.wpbf-button-primary), input[type="submit"]',
				props: { color: toStringColor(value) },
			});
		},
	);

	// Text color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"button_text_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					'.wpbf-button:not(.wpbf-button-primary):hover, input[type="submit"]:hover',
				props: { color: toStringColor(value) },
			});
		},
	);

	// Primary background color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"button_primary_bg_color",
		function (settingId, value) {
			writeCSS(settingId, {
				blocks: [
					{
						selector: ".wpbf-button-primary",
						props: {
							"background-color": toStringColor(value),
						},
					},
					{
						selector:
							".wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background)",
						props: {
							"background-color": toStringColor(value),
						},
					},
					{
						selector:
							".is-style-outline .wp-block-button__link:not(.has-text-color):not(.has-background)",
						props: {
							"border-color": toStringColor(value),
							color: toStringColor(value),
						},
					},
				],
			});
		},
	);

	// Primary background color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"button_primary_bg_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				blocks: [
					{
						selector: ".wpbf-button-primary:hover",
						props: { "background-color": toStringColor(value) },
					},
					{
						selector:
							".wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background):not(.has-text-color):hover",
						props: { "background-color": toStringColor(value) },
					},
					{
						selector:
							".is-style-outline .wp-block-button__link:not(.has-text-color):not(.has-background):hover",
						props: {
							"border-color": toStringColor(value),
							color: toStringColor(value),
						},
					},
				],
			});
		},
	);

	// Primary text color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"button_primary_text_color",
		function (settingId, value) {
			writeCSS(settingId, {
				blocks: [
					{
						selector: ".wpbf-button-primary",
						props: { color: toStringColor(value) },
					},
					{
						selector:
							".wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-text-color)",
						props: { color: toStringColor(value) },
					},
				],
			});
		},
	);

	// Primary text color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"button_primary_text_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				blocks: [
					{
						selector: ".wpbf-button-primary:hover",
						props: {
							color: toStringColor(value),
						},
					},
					{
						selector:
							".wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background):not(.has-text-color):hover",
						props: {
							color: toStringColor(value),
						},
					},
				],
			});
		},
	);

	// Border radius.
	listenToCustomizerValueChange<string | number>(
		"button_border_radius",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: '.wpbf-button, input[type="submit"]',
				props: {
					"border-radius": maybeAppendSuffix(value),
				},
			});
		},
	);

	// Border width.
	listenToCustomizerValueChange<number | string>(
		"button_border_width",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: '.wpbf-button, input[type="submit"]',
				props: {
					"border-width": maybeAppendSuffix(value),
					"border-style": "solid",
				},
			});
		},
	);

	// Border color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"button_border_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					'.wpbf-button:not(.wpbf-button-primary), input[type="submit"]',
				props: { "border-color": toStringColor(value) },
			});
		},
	);

	// Border color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"button_border_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					'.wpbf-button:not(.wpbf-button-primary):hover, input[type="submit"]:hover',
				props: { "border-color": toStringColor(value) },
			});
		},
	);

	// Primary border color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"button_primary_border_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-button-primary",
				props: { "border-color": toStringColor(value) },
			});
		},
	);

	// Primary border color hover.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"button_primary_border_color_alt",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-button-primary:hover",
				props: { "border-color": toStringColor(value) },
			});
		},
	);
}
