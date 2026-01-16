import { WpbfCustomizeSetting } from "../../../Customizer/Controls/Base/src/base-interface";
import { WpbfColorControlValue } from "../../../Customizer/Controls/Color/src/color-interface";
import { DevicesValue } from "../../../Customizer/Controls/Responsive/src/responsive-interface";

export const mediaQueries = {
	mobile:
		"max-width: " + (window.WpbfTheme.breakpoints.tablet - 1).toString() + "px",
	tablet:
		"max-width: " +
		(window.WpbfTheme.breakpoints.desktop - 1).toString() +
		"px",
	desktop:
		"min-width: " + window.WpbfTheme.breakpoints.desktop.toString() + "px",
};

export function toNumberValue(value: string | number): number {
	if (typeof value === "number") {
		return value;
	}

	if (value === "") return 0;

	return parseFloat(value);
}

/**
 * Check if provided value is empty but not zero.
 *
 * @param {number|string} value The value to check.
 * @returns {boolean} True or false.
 */
export function emptyNotZero(value: number | string): boolean {
	if (value === "0" || value === 0) {
		return false;
	}

	return value ? false : true;
}

export function valueHasUnit(value: string | number): boolean {
	if (!value) {
		return false;
	}

	const strValue = String(value);
	const unitPattern = /[a-z%]+$/i;
	const unitMatch = strValue.match(unitPattern);

	return unitMatch && unitMatch.length > 0 ? true : false;
}

export function maybeAppendSuffix(
	value: string | number | undefined | null,
	suffix?: string,
) {
	if (value === undefined || value === "" || value === null) {
		return undefined;
	}

	suffix = suffix || "px";

	return valueHasUnit(value) ? value : value + suffix;
}

export function toStringColor(color: WpbfColorControlValue) {
	if (color === "" || typeof color === "number") {
		return undefined;
	}

	if (typeof color === "string") return color;
	if (!("r" in color)) return undefined;

	const alpha = "a" in color ? color.a : 1;

	return alpha && alpha < 1
		? `rgba(${color.r}, ${color.g}, ${color.b}, ${alpha})`
		: `rgb(${color.r}, ${color.g}, ${color.b})`;
}

export function parseTemplateTags(value: string): string {
	if (!value) return "";

	let parsedValue = value.replace(/\{site_url\}/g, window.WpbfObj.siteUrl);

	return parsedValue;
}

/**
 * Handle mobile menu resize events.
 * Adjusts the mobile menu height based on viewport and wrapper dimensions.
 */
export function handleMobileMenuResize() {
	const windowHeight = document.documentElement.clientHeight;
	const mobileNavWrapper = document.querySelector(".wpbf-mobile-nav-wrapper");

	if (!mobileNavWrapper) return;

	const wrapperHeight =
		mobileNavWrapper instanceof HTMLElement ? mobileNavWrapper.offsetHeight : 0;
	const activeNav = document.querySelector(
		".wpbf-mobile-menu-container.active nav",
	);

	if (activeNav instanceof HTMLElement) {
		activeNav.style.maxHeight = windowHeight - wrapperHeight + "px";
	}
}


/**
 * Get style tag element based on control id.
 *
 * @param {string} id The style data id.
 * @return {HTMLStyleElement} The style tag element.
 */
export function getStyleTag(id: string): HTMLStyleElement {
	const tag = document.head.querySelector(`style[data-id="${id}"]`);
	if (tag instanceof HTMLStyleElement) return tag;

	const styleTag = document.createElement("style");
	styleTag.dataset.id = id;
	styleTag.className = "wpbf-customize-live-style";

	document.head.append(styleTag);
	return styleTag;
}

export function removeStyleTag(id: string) {
	const styleTag = document.querySelector(`style[data-id="${id}"]`);
	styleTag?.remove();
}

export function writeCSS(
	styleTagOrId: HTMLStyleElement | string,
	args: {
		mediaQuery?: string;
		blocks?: {
			selector: string;
			props: Record<string, string | number | null | undefined>;
		}[];
		selector?: string;
		props?: Record<string, string | number | null | undefined>;
	},
) {
	const styleTag =
		typeof styleTagOrId === "string" ? getStyleTag(styleTagOrId) : styleTagOrId;

	const blocks = args.blocks && Array.isArray(args.blocks) ? args.blocks : [];
	const selector = args.selector || "";

	// Either blocks or selector should be set.
	if (!blocks.length && !selector) {
		return;
	}

	const mediaQuery = args.mediaQuery || "";

	let content = "";

	if (blocks.length) {
		if (mediaQuery) {
			content += `${mediaQuery} {`;
		}

		blocks.forEach((block) => {
			const blockSelector = block.selector;
			const blockProps = block.props;

			if (!blockSelector || !blockProps || !Object.keys(blockProps).length) {
				return;
			}

			content += `${blockSelector} {`;

			for (const [cssProp, cssValue] of Object.entries(blockProps)) {
				if (!cssProp || cssValue === null || cssValue === undefined) {
					continue;
				}

				content += `${cssProp}: ${cssValue};`;
			}

			content += "}";
		});

		if (mediaQuery) {
			content += "}";
		}

		styleTag.innerHTML = content;
		return;
	}

	const props = args.props;

	if (!props || !Object.keys(props).length) {
		return;
	}

	content = "";

	if (mediaQuery) {
		content += `${mediaQuery} {`;
	}

	content += `${selector} {`;

	for (const [cssProp, cssValue] of Object.entries(props)) {
		if (!cssProp || cssValue === null || cssValue === undefined) {
			continue;
		}

		content += `${cssProp}: ${cssValue};`;
	}

	content += "}";

	if (mediaQuery) {
		content += "}";
	}

	styleTag.innerHTML = content;
}

/**
 * Write responsive CSS.
 *
 * @param {HTMLStyleElement} styleTagOrId - The style tag element or the style tag id.
 * @param {string} selector - The CSS selector.
 * @param {string|string[]} rule - The CSS rule.
 * @param {Record<string, any>} value - The responsive CSS value.
 */
export function writeResponsiveCSS(
	styleTagOrId: HTMLStyleElement | string,
	selector: string,
	rule: string | string[],
	value: Record<string, any>,
) {
	const styleTag =
		typeof styleTagOrId === "string" ? getStyleTag(styleTagOrId) : styleTagOrId;

	const breakpoints = window.WpbfTheme.breakpoints;
	const mediaQueries = {
		mobile: "max-width: " + (breakpoints.tablet - 1).toString() + "px",
		tablet: "max-width: " + (breakpoints.desktop - 1).toString() + "px",
		desktop: "min-width: " + breakpoints.desktop.toString() + "px",
	};
	let css = "";

	for (const device in value) {
		if (!value.hasOwnProperty(device)) continue;
		if (value[device] === "") continue;

		let deviceCSS = `${selector} { 
		${typeof rule === "string" ? `${rule}: ${value[device]};` : rule.map((r) => `${r}: ${value[device]};`).join("\n")}
	}`;

		// Apply media queries based on the device.
		if (device === "mobile" && breakpoints.mobile) {
			deviceCSS = `@media (${mediaQueries.mobile}) { ${deviceCSS} }`;
		} else if (device === "tablet" && breakpoints.tablet) {
			deviceCSS = `@media (${mediaQueries.tablet}) { ${deviceCSS} }`;
		} else if (device === "desktop" && breakpoints.desktop) {
			deviceCSS = `@media (${mediaQueries.desktop}) { ${deviceCSS} }`;
		}

		css += deviceCSS + "\n";
	}

	styleTag.innerHTML = css;
}

export function listenToCustomizerValueChange<VT>(
	settingId: string,
	fn: (settingId: string, value: VT) => void,
) {
	window.wp.customize?.(
		settingId,
		function (setting: WpbfCustomizeSetting<VT>) {
			// Apply initial value when customizer opens
			const initialValue = setting.get();
			if (initialValue !== undefined && initialValue !== null) {
				fn(settingId, initialValue);
			}

			// Listen to value changes
			setting.bind(function (value) {
				fn(settingId, value);
			});
		},
	);
}

export function listenToBuilderMulticolorControl(props: {
	controlId: string;
	cssSelector: string;
	cssProps: string | string[];
}) {
	window.wp.customize?.(
		props.controlId,
		function (value: WpbfCustomizeSetting<Record<string, string>>) {
			const styleTag = getStyleTag(props.controlId);
			const states = ["default", "hover", "active", "focus"];

			value.bind((newValue) => {
				if (!newValue) {
					styleTag.innerHTML = "";
					return;
				}

				let css = "";

				for (const state of states) {
					if (!newValue.hasOwnProperty(state)) continue;
					const stateSelector = state === "default" ? "" : `:${state}`;

					if (state in newValue) {
						const stateValue = newValue[state];
						if (!stateValue) continue;

						css += `
							${props.cssSelector}${stateSelector} {
								${"string" === typeof props.cssProps ? `${props.cssProps}: ${newValue[state]};` : props.cssProps.map((prop) => `${prop}: ${newValue[state]};`).join("\n")}
							}
						`;
					}
				}

				styleTag.innerHTML = css;
			});
		},
	);
}

export function listenToBuilderResponsiveControl(props: {
	controlId: string;
	cssSelector: string;
	cssProps: string | string[];
	useValueSuffix?: boolean;
}) {
	window.wp.customize?.(
		props.controlId,
		function (setting: WpbfCustomizeSetting<string | DevicesValue>) {
			const styleTag = getStyleTag(props.controlId);

			// Function to process and apply values
			const applyValues = (values: string | DevicesValue) => {
				let valuesObj: DevicesValue = values as DevicesValue;

				if (typeof values === "string") {
					try {
						const parsed = JSON.parse(values);
						if (parsed && typeof parsed === "object") {
							valuesObj = parsed;
						} else {
							styleTag.innerHTML = "";
							return;
						}
					} catch (e) {
						styleTag.innerHTML = "";
						return;
					}
				}

				const validatedValues: DevicesValue = {};

				for (const device in valuesObj) {
					if (!valuesObj.hasOwnProperty(device)) continue;
					if (valuesObj[device] === "") continue;

					let deviceValue = props.useValueSuffix
						? valueHasUnit(valuesObj[device])
							? valuesObj[device]
							: valuesObj[device] + "px"
						: valuesObj[device];

					validatedValues[device] = deviceValue;
				}

				writeResponsiveCSS(
					styleTag,
					props.cssSelector,
					props.cssProps,
					validatedValues,
				);
			};

			// Apply initial value when customizer opens
			const initialValue = setting.get();
			if (initialValue !== undefined && initialValue !== null) {
				applyValues(initialValue);
			}

			// Listen to value changes
			setting.bind((values) => {
				applyValues(values);
			});
		},
	);
}

export type WpbfCheckboxButtonsetResponsiveValue = {
	desktop?: boolean;
	tablet?: boolean;
	mobile?: boolean;
};

/**
 * Write responsive CSS with per-breakpoint selectors into a single style tag.
 * Use this when different breakpoints need different selectors.
 *
 * @param styleTagOrId - The style tag element or the style tag id.
 * @param config - Object with desktop/tablet/mobile configurations.
 */
export function writeResponsiveCSSMultiSelector(
	styleTagOrId: HTMLStyleElement | string,
	config: {
		desktop?: { selector: string; props: Record<string, string | number | undefined> };
		tablet?: { selector: string; props: Record<string, string | number | undefined> };
		mobile?: { selector: string; props: Record<string, string | number | undefined> };
	},
) {
	const styleTag =
		typeof styleTagOrId === "string" ? getStyleTag(styleTagOrId) : styleTagOrId;

	let css = "";

	// Desktop (no media query needed - base styles)
	if (config.desktop) {
		const { selector, props } = config.desktop;
		const propsStr = Object.entries(props)
			.filter(([, v]) => v !== undefined && v !== "")
			.map(([k, v]) => `${k}: ${v};`)
			.join(" ");

		if (propsStr) {
			css += `${selector} { ${propsStr} }\n`;
		}
	}

	// Tablet
	if (config.tablet) {
		const { selector, props } = config.tablet;
		const propsStr = Object.entries(props)
			.filter(([, v]) => v !== undefined && v !== "")
			.map(([k, v]) => `${k}: ${v};`)
			.join(" ");

		if (propsStr) {
			css += `@media (${mediaQueries.tablet}) { ${selector} { ${propsStr} } }\n`;
		}
	}

	// Mobile
	if (config.mobile) {
		const { selector, props } = config.mobile;
		const propsStr = Object.entries(props)
			.filter(([, v]) => v !== undefined && v !== "")
			.map(([k, v]) => `${k}: ${v};`)
			.join(" ");

		if (propsStr) {
			css += `@media (${mediaQueries.mobile}) { ${selector} { ${propsStr} } }\n`;
		}
	}

	styleTag.innerHTML = css;
}
