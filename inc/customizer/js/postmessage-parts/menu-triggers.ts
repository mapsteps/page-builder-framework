import {
	listenToCustomizerValueChange,
	writeCSS,
	maybeAppendSuffix,
	toStringColor,
	removeStyleTag,
} from "../customizer-util";
import { parseJsonOrUndefined } from "../../../../Customizer/Controls/Generic/src/string-util";
import { WpbfColorControlValue } from "../../../../Customizer/Controls/Color/src/color-interface";
import { MarginPaddingValue } from "../../../../Customizer/Controls/MarginPadding/src/margin-padding-interface";
import { headerBuilderEnabled } from "../../../../assets/js/utils/customizer-util";

/**
 * Setup menu trigger controls for header builder.
 * Handles customization for both desktop and mobile menu trigger buttons.
 */
export default function menuTriggersSetup(customizer?: WpbfCustomize) {
	/**
	 * Listen to menu trigger value changes.
	 *
	 * This handles all menu trigger customizations including:
	 * - Icon selection (variant-1, variant-2, variant-3, none)
	 * - Button styles (simple, solid, outline)
	 * - Text labels
	 * - Padding
	 * - Desktop-specific: icon color, border radius, background/border color, icon size
	 *
	 * Note for mobile triggers:
	 * - Mobile background color → handled by "mobile_menu_hamburger_bg_color" (in mobile-navigation.ts)
	 * - Mobile border radius → handled by "mobile_menu_hamburger_border_radius" (in mobile-navigation.ts)
	 * - Mobile icon color → handled by "mobile_menu_hamburger_color" (in mobile-navigation.ts)
	 * - Mobile icon size → handled by "mobile_menu_hamburger_size" (in mobile-navigation.ts)
	 *
	 * @param {"desktop"|"mobile"} device The target device type.
	 */
	function listenToMenuTriggerValueChange(device: "desktop" | "mobile") {
		// Menu trigger icon.
		listenToCustomizerValueChange<string>(
			"wpbf_header_builder_" + device + "_menu_trigger_icon",
			function (settingId, value) {
				// Only apply when header builder is enabled.
				// This prevents inserting header builder SVG into non-header-builder mobile menu toggle.
				if (!headerBuilderEnabled()) {
					return;
				}

				const iconVariant = value ? String(value) : "variant-1";

				if (
					iconVariant !== "none" &&
					iconVariant !== "variant-1" &&
					iconVariant !== "variant-2" &&
					iconVariant !== "variant-3"
				) {
					return;
				}

				const triggerButton = document.querySelector(
					device === "mobile"
						? ".wpbf-mobile-menu-toggle"
						: ".wpbf-menu-toggle",
				);
				if (!triggerButton) return;

				const existingSvg = triggerButton.querySelector(
					".menu-trigger-button-svg",
				);

				const buttonStyleVal = customizer?.(
					"wpbf_header_builder_" + device + "_menu_trigger_style",
				).get();

				const buttonStyle =
					"" === buttonStyleVal ? "simple" : String(buttonStyleVal);

				if (
					buttonStyle !== "simple" &&
					buttonStyle !== "outline" &&
					buttonStyle !== "solid"
				) {
					return;
				}

				triggerButton.classList.remove("simple", "outline", "solid");

				triggerButton.classList.add(buttonStyle);

				if (iconVariant === "none") {
					existingSvg?.remove();
				} else {
					const newSvg =
						window.wpbfMenuTriggerButtonSvg?.[iconVariant] &&
						window.wpbfMenuTriggerButtonSvg[iconVariant]
							? window.wpbfMenuTriggerButtonSvg[iconVariant]
							: null;

					if (newSvg) {
						if (existingSvg) {
							existingSvg.outerHTML = newSvg;
						} else {
							triggerButton.insertAdjacentHTML("afterbegin", newSvg);
						}
					}
				}
			},
		);

		// Menu trigger style.
		listenToCustomizerValueChange<string>(
			"wpbf_header_builder_" + device + "_menu_trigger_style",
			function (settingId, value) {
				// Only apply when header builder is enabled.
				// This prevents modifying non-header-builder mobile menu toggle.
				if (!headerBuilderEnabled()) {
					return;
				}

				// Handle empty string as 'simple'
				const buttonStyle =
					value && String(value).trim() !== "" ? String(value) : "simple";

				if (
					buttonStyle !== "simple" &&
					buttonStyle !== "outline" &&
					buttonStyle !== "solid"
				) {
					return;
				}

				const triggerButton = document.querySelector(
					device === "mobile"
						? ".wpbf-mobile-menu-toggle"
						: ".wpbf-menu-toggle",
				);

				if (!triggerButton) return;

				// Update button classes
				triggerButton.classList.remove("simple", "outline", "solid");
				triggerButton.classList.add(buttonStyle);

				// Re-trigger individual control listeners to apply styles based on new button style
				// This approach is similar to how icon variant listener works
				if (device === "mobile") {
					// For mobile, trigger the old control listeners
					const bgColor = customizer?.("mobile_menu_hamburger_bg_color")?.get();
					const borderRadius = customizer?.(
						"mobile_menu_hamburger_border_radius",
					)?.get();

					// Re-apply background/border color
					if (bgColor !== undefined) {
						const bgColorSetting = customizer?.(
							"mobile_menu_hamburger_bg_color",
						);
						if (bgColorSetting) {
							// Temporarily store the value
							const tempValue = bgColor;
							// Trigger change by setting to different value first, then back
							bgColorSetting.set("");
							bgColorSetting.set(tempValue);
						}
					}

					// Re-apply border radius
					if (borderRadius !== undefined) {
						const borderRadiusSetting = customizer?.(
							"mobile_menu_hamburger_border_radius",
						);
						if (borderRadiusSetting) {
							// Temporarily store the value
							const tempValue = borderRadius;
							// Trigger change by setting to different value first, then back
							borderRadiusSetting.set(0);
							borderRadiusSetting.set(tempValue);
						}
					}
				} else {
					// For desktop, trigger the new control listeners
					const bgColor = customizer?.(
						"wpbf_header_builder_desktop_menu_trigger_bg_color",
					)?.get();
					const borderRadius = customizer?.(
						"wpbf_header_builder_desktop_menu_trigger_border_radius",
					)?.get();
					const padding = customizer?.(
						"wpbf_header_builder_desktop_menu_trigger_padding",
					)?.get();

					// Re-apply background/border color
					if (bgColor !== undefined) {
						const bgColorSetting = customizer?.(
							"wpbf_header_builder_desktop_menu_trigger_bg_color",
						);
						if (bgColorSetting) {
							const tempValue = bgColor;
							bgColorSetting.set("");
							bgColorSetting.set(tempValue);
						}
					}

					// Re-apply border radius
					if (borderRadius !== undefined) {
						const borderRadiusSetting = customizer?.(
							"wpbf_header_builder_desktop_menu_trigger_border_radius",
						);
						if (borderRadiusSetting) {
							const tempValue = borderRadius;
							borderRadiusSetting.set(0);
							borderRadiusSetting.set(tempValue);
						}
					}

					// Re-apply padding
					if (padding !== undefined) {
						const paddingSetting = customizer?.(
							"wpbf_header_builder_desktop_menu_trigger_padding",
						);
						if (paddingSetting) {
							const tempValue = padding;
							paddingSetting.set("");
							paddingSetting.set(tempValue);
						}
					}
				}
			},
		);

		// Menu trigger button's text.
		listenToCustomizerValueChange<string>(
			"wpbf_header_builder_" + device + "_menu_trigger_text",
			function (settingId, value) {
				// Only apply when header builder is enabled.
				if (!headerBuilderEnabled()) {
					return;
				}

				const triggerButton = document.querySelector(
					device === "mobile"
						? ".wpbf-mobile-menu-toggle"
						: ".wpbf-menu-toggle",
				);
				if (!triggerButton) return;

				const existingLabelSpan = triggerButton.querySelector(
					".menu-trigger-button-text",
				);

				if (value.trim() === "") {
					existingLabelSpan?.remove();
				} else {
					if (existingLabelSpan) {
						existingLabelSpan.textContent = value;
					} else {
						const newLabelSpan = document.createElement("span");
						newLabelSpan.classList.add("menu-trigger-button-text");
						newLabelSpan.textContent = value;
						triggerButton.appendChild(newLabelSpan);
					}
				}
			},
		);

		// Menu trigger button's padding.
		listenToCustomizerValueChange<MarginPaddingValue | string>(
			`wpbf_header_builder_${device}_menu_trigger_padding`,
			function (settingId, value) {
				// Only apply when header builder is enabled.
				if (!headerBuilderEnabled()) {
					return;
				}

				const obj =
					parseJsonOrUndefined<Record<string, number | string>>(value);

				// Only apply padding if style is solid or outline
				const buttonStyle = customizer?.(
					`wpbf_header_builder_${device}_menu_trigger_style`,
				)?.get();

				const buttonStyleStr =
					buttonStyle && String(buttonStyle).trim() !== ""
						? String(buttonStyle)
						: "simple";

				// Only apply padding for solid and outline styles
				if (buttonStyleStr !== "solid" && buttonStyleStr !== "outline") {
					writeCSS(settingId, {
						selector:
							device === "mobile"
								? ".wpbf-mobile-menu-toggle"
								: ".wpbf-menu-toggle",
						props: {
							"padding-top": "unset",
							"padding-right": "unset",
							"padding-bottom": "unset",
							"padding-left": "unset",
						},
					});
					return;
				}

				writeCSS(settingId, {
					selector:
						device === "mobile"
							? ".wpbf-mobile-menu-toggle"
							: ".wpbf-menu-toggle",
					props: {
						"padding-top": maybeAppendSuffix(obj?.top),
						"padding-right": maybeAppendSuffix(obj?.right),
						"padding-bottom": maybeAppendSuffix(obj?.bottom),
						"padding-left": maybeAppendSuffix(obj?.left),
					},
				});
			},
		);

		if (device === "desktop") {
			// Menu trigger button icon's color (Header Builder mode only).
			listenToCustomizerValueChange<WpbfColorControlValue>(
				"wpbf_header_builder_desktop_menu_trigger_icon_color",
				function (settingId, value) {
					// Only apply when Header Builder is enabled.
					// When disabled, premium plugin handles via menu_off_canvas_hamburger_color.
					if (!headerBuilderEnabled()) {
						// Remove any existing style tag to prevent overriding premium plugin's styles.
						removeStyleTag(settingId);
						return;
					}

					const colorValue = toStringColor(value);

					writeCSS(settingId, {
						selector: ".wpbf-menu-toggle",
						props: { color: colorValue ? colorValue + " !important" : "" },
					});
				},
			);

			// Menu trigger button's border radius.
			listenToCustomizerValueChange<string | number>(
				"wpbf_header_builder_desktop_menu_trigger_border_radius",
				function (settingId, value) {
					// Only apply border radius if style is solid or outline
					const buttonStyle = customizer?.(
						"wpbf_header_builder_desktop_menu_trigger_style",
					)?.get();

					const buttonStyleStr =
						buttonStyle && String(buttonStyle).trim() !== ""
							? String(buttonStyle)
							: "simple";

					if (buttonStyleStr !== "solid" && buttonStyleStr !== "outline") {
						writeCSS(settingId, {
							selector: ".wpbf-menu-toggle",
							props: { "border-radius": "unset !important" },
						});
						return;
					}

					writeCSS(settingId, {
						selector: ".wpbf-menu-toggle",
						props: { "border-radius": maybeAppendSuffix(value) },
					});
				},
			);

			// Menu trigger button's background/border color.
			listenToCustomizerValueChange<WpbfColorControlValue>(
				"wpbf_header_builder_desktop_menu_trigger_bg_color",
				function (settingId, value) {
					const buttonStyle = customizer?.(
						"wpbf_header_builder_desktop_menu_trigger_style",
					)?.get();

					const buttonStyleStr =
						buttonStyle && String(buttonStyle).trim() !== ""
							? String(buttonStyle)
							: "simple";

					if (buttonStyleStr !== "solid" && buttonStyleStr !== "outline") {
						writeCSS(settingId, {
							selector: ".wpbf-menu-toggle",
							props: {
								"background-color": "unset !important",
								border: "unset !important",
							},
						});
						return;
					}

					writeCSS(settingId, {
						selector: ".wpbf-menu-toggle",
						props: {
							"background-color":
								buttonStyleStr === "solid"
									? toStringColor(value) + " !important"
									: "unset !important",
							border:
								buttonStyleStr === "solid"
									? "unset !important"
									: "2px solid " + toStringColor(value) + " !important",
						},
					});
				},
			);

			// Menu trigger button icon's size (Header Builder mode only).
			listenToCustomizerValueChange<string | number>(
				"wpbf_header_builder_desktop_menu_trigger_icon_size",
				function (settingId, value) {
					// Only apply when Header Builder is enabled.
					// When disabled, premium plugin handles via menu_off_canvas_hamburger_size.
					if (!headerBuilderEnabled()) {
						// Remove any existing style tag to prevent overriding premium plugin's styles.
						removeStyleTag(settingId);
						return;
					}

					writeCSS(settingId, {
						selector: ".wpbf-menu-toggle",
						props: { "font-size": maybeAppendSuffix(value) },
					});
				},
			);
		}
	}

	listenToMenuTriggerValueChange("mobile");
	listenToMenuTriggerValueChange("desktop");

	// Listen to header builder toggle to clean up desktop menu trigger style tags.
	// When header builder is disabled mid-session, we need to remove the theme's
	// style tags so they don't override the premium plugin's menu_off_canvas_hamburger_* styles.
	listenToCustomizerValueChange<boolean>(
		"wpbf_enable_header_builder",
		function (settingId, value) {
			if (!value) {
				// Header builder is disabled - remove the desktop menu trigger style tags.
				removeStyleTag("wpbf_header_builder_desktop_menu_trigger_icon_size");
				removeStyleTag("wpbf_header_builder_desktop_menu_trigger_icon_color");
			}
		},
	);
}
