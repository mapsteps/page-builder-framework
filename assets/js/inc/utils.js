/**
 * Iterates over a collection of elements and applies a function to each.
 *
 * @param {NodeList|string} selector - Either a NodeList obtained from document.querySelectorAll() or a CSS selector string.
 * @param {function(Element)} handler - The function to be applied to each element. Accepts one parameter, which is the element.
 *
 * @returns {void}
 */
export function forEachEl(selector, handler) {
	if (!(selector instanceof NodeList) && typeof selector !== "string") return;
	if (typeof handler !== "function") return;

	const elms =
		selector instanceof NodeList
			? selector
			: document.querySelectorAll(selector);
	if (!elms.length) return;

	for (let i = 0; i < elms.length; i++) {
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
export function listenDocumentEvent(eventType, selector, handler) {
	if (typeof eventType !== "string") return;
	if (typeof selector !== "function") return;

	document.addEventListener(eventType, function (e) {
		if (selector) {
			if (!e.target || !e.target.matches) return;
			if (!e.target.matches(selector)) return;
		}

		handler.bind(e.target)(e);
	});
}

/**
 * Get attribute value of an element.
 *
 * @param {HTMLElement|string} selector - The element or CSS selector.
 * @param {string} key - The attribute name.
 *
 * @return {string} The attribute value.
 */
export function getAttr(selector, key) {
	const el =
		selector instanceof HTMLElement
			? selector
			: document.querySelector(selector);
	if (!el || !el.getAttribute) return "";
	if (!key) return "";

	return el.getAttribute(key);
}

/**
 * Get attribute value of an element as number.
 *
 * @param {HTMLElement|string} selector - The element or CSS selector.
 * @param {string} key - The attribute name.
 *
 * @return {number} The attribute value as number.
 */
export function getAttrAsNumber(selector, key) {
	const value = getAttr(selector, key);
	if (!value) return 0;

	return parseInt(value, 10);
}

/**
 * Check whether we're inside customizer or not.
 *
 * @returns {boolean} Whether we're inside customizer or not.
 */
export function isInsideCustomizer() {
	return window.wp && wp.customize ? true : false;
}

export const defaultBreakpoints = {
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
 * @param {string} device The device type. Accepts 'desktop', 'tablet', or 'mobile'.
 * @returns {number} The breakpoint value.
 */
export function getBreakpointValue(device) {
	let breakpoint = defaultBreakpoints[device] || 0;

	const matchRule = "wpbf-" + device + "-breakpoint-[\\w-]*\\b";
	const breakpointClassMatch = document.body.className.match(matchRule);

	if (!breakpointClassMatch) {
		return breakpoint;
	}

	const breakpointMatch = breakpointClassMatch.toString().match(/\d+/);

	const breakpointValue = Array.isArray(breakpointMatch)
		? breakpointMatch[0]
		: breakpointMatch;

	return parseInt(breakpointValue, 10) || 0;
}

/**
 * Get breakpoint values for desktop, tablet, and mobile.
 *
 * @returns {DeviceBreakpoints} breakpoints The breakpoints object.
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
 * @returns {string} The active breakpoint. Accepts 'desktop', 'tablet', or 'mobile'.
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

/**
 * Hide an element after a delay.
 *
 * @param {HTMLElement} el The element to hide.
 * @param {number} delay The delay in milliseconds.
 */
export function hideElAfterDelay(el, delay) {
	if (!el) return;
	if (typeof delay !== "number") return;

	setTimeout(function () {
		el.style.display = "none";
	}, delay);
}
