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
	if (typeof handler !== "function") return;

	let eventName = eventType;

	switch (eventType) {
		case "mouseenter":
			eventName = "mouseover";
			break;

		case "mouseleave":
			eventName = "mouseout";
			break;
	}

	document.addEventListener(eventName, function (e) {
		let target = e.target;

		if (selector) {
			if (!e.target || !e.target.closest) return;
			target = e.target.closest(selector);
			if (!target) return;
		}

		if (eventName === "mouseover") {
			// console.log("target", target);
		}

		handler.call(target, e);
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
 * @param {string} device - The device type. Accepts 'desktop', 'tablet', or 'mobile'.
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

/**
 * Direct query selector. It's like el.querySelector(':scope > selector') but supports older browsers.
 *
 * @param {HTMLElement} el - The parent element.
 * @param {string} selector - The selector.
 *
 * @return {HTMLElement|null} The element or null.
 */
export function directQuerySelector(el, selector) {
	let className = el.className;

	// Trim leading and trailing spaces.
	className = className.replace(/^\s+|\s+$/g, "");

	// Remove space and replace it with . (dot)
	className = className.replace(/\s/g, ".");

	const parent = el.parentNode;
	const children = parent.querySelectorAll(`.${className} > ${selector}`);
	if (!children.length) return null;

	let result = null;

	for (let i = 0; i < children.length; i++) {
		if (children[i].parentNode != el) continue;
		result = children[i];
		break;
	}

	return result;
}

/**
 * Get siblings of an element.
 * The "el" parameter is can be in any position (not only first child).
 *
 * @param {HTMLElement} el - The element.
 * @param {string} selector - The selector.
 *
 * @return {Array<HTMLElement>} The siblings.
 */
export function getSiblings(el, selector) {
	if (!el.parentNode) return [];

	const siblings = [];
	let sibling = el.parentNode.firstChild;

	while (sibling) {
		if (sibling.nodeType === 1 && sibling !== el) {
			if (!selector || sibling.matches(selector)) {
				siblings.push(sibling);
			}
		}

		sibling = sibling.nextSibling;
	}

	return siblings;
}

/**
 * Get element's height without padding and border.
 *
 * @param {HTMLElement} el - The element.
 * @return {number} The pure height.
 */
export function getPureHeight(el) {
	if (!el) return 0;

	const style = window.getComputedStyle(el);

	// Get the total height including padding and border
	const totalHeight = el.offsetHeight;

	const pureHeight =
		totalHeight -
		parseFloat(style.paddingTop) -
		parseFloat(style.paddingBottom) -
		parseFloat(style.borderTopWidth) -
		parseFloat(style.borderBottomWidth);

	return pureHeight;
}
