/// <reference path="../../../types.js"/>

/**
 * Check whether we're inside customizer or not.
 *
 * @returns {boolean} Whether we're inside customizer or not.
 */
export function isInsideCustomizer() {
	// @ts-ignore
	return window.wp && window.wp.customize ? true : false;
}

/**
 * @type {WpbfBreakpoints}
 */
const defaultBreakpoints = {
	desktop: 1024,
	tablet: 768,
	mobile: 480,
};

/**
 * Get breakpoint by device type.
 *
 * Retrieve breakpoint based on body class,
 * then set it as the value of top level `breakpoints` variable.
 *
 * @param {"desktop"|"tablet"|"mobile"} device - The device type. Accepts 'desktop', 'tablet', or 'mobile'.
 * @returns {number} The breakpoint value.
 */
function getBreakpointValue(device) {
	let breakpoint = defaultBreakpoints[device] || 0;

	const matchRule = "wpbf-" + device + "-breakpoint-[\\w-]*\\b";
	const breakpointClassMatch = document.body.className.match(matchRule);

	if (!breakpointClassMatch) {
		return breakpoint;
	}

	const breakpointMatch = breakpointClassMatch.toString().match(/\d+/);

	const breakpointValue = Array.isArray(breakpointMatch)
		? parseInt(breakpointMatch[0], 10)
		: 0;

	return breakpointValue;
}

/**
 * Get breakpoint values for desktop, tablet, and mobile.
 *
 * @returns {WpbfBreakpoints} breakpoints The breakpoints object.
 */
export function getBreakpoints() {
	let breakpoints = defaultBreakpoints;

	breakpoints.desktop = getBreakpointValue("desktop");
	breakpoints.tablet = getBreakpointValue("tablet");
	breakpoints.mobile = getBreakpointValue("mobile");

	return breakpoints;
}

/**
 * Get the current active breakpoint.
 *
 * @returns {string} - The active breakpoint. Accepts 'desktop', 'tablet', or 'mobile'.
 */
export function getActiveBreakpoint() {
	const breakpoints = getBreakpoints();
	const windowWidth = document.documentElement.clientWidth;

	let activeBreakpoint = "desktop";

	if (windowWidth > breakpoints.desktop) {
		return activeBreakpoint;
	}

	if (windowWidth > breakpoints.tablet) {
		activeBreakpoint = "tablet";
	} else {
		activeBreakpoint = "mobile";
	}

	return activeBreakpoint;
}
