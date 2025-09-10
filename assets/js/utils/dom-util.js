/**
 * Iterates over a collection of elements and applies a function to each.
 *
 * @param {NodeListOf<HTMLElement>|string} selector - Either a NodeList obtained from document.querySelectorAll() or a CSS selector string.
 * @param {function(HTMLElement): void} handler - The function to be applied to each element. Accepts one parameter, which is the element.
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
		const elm = elms[i];

		if (elm instanceof HTMLElement) {
			handler(elm);
		}
	}
}

/**
 * Add event handler to the document.
 *
 * @param {string} eventType - The event type.
 * @param {string|null} selector - The selector.
 * @param {function(any): void} handler - The event handler.
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
		if (!e.target) return;
		if (!(e.target instanceof HTMLElement)) return;
		let target = e.target;

		if (selector) {
			const closestTarget = e.target.closest(selector);
			if (!closestTarget) return;

			if (closestTarget instanceof HTMLElement) {
				target = closestTarget;
			}
		}

		if (target && eventName === "mouseout") {
			if (
				e instanceof MouseEvent &&
				e.relatedTarget instanceof Node &&
				target.contains(e.relatedTarget)
			) {
				return;
			}
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

	const val = el.getAttribute(key);

	return val ? val : "";
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
	if (!parent) return null;

	const children = parent.querySelectorAll(`.${className} > ${selector}`);
	if (!children.length) return null;

	/**
	 * @type {HTMLElement|null}
	 */
	let result = null;

	for (let i = 0; i < children.length; i++) {
		if (children[i].parentNode != el) continue;
		const child = children[i];

		if (child instanceof HTMLElement) {
			result = child;
			break;
		}
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
		if (
			sibling.nodeType === 1 &&
			sibling instanceof HTMLElement &&
			sibling !== el
		) {
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

	// Temporarily patch the element's display and opacity.
	el.style.opacity = "0";
	el.style.display = "block";

	const computedStyle = window.getComputedStyle(el);

	// Get the total height including padding and border
	const totalHeight = el.offsetHeight;

	const pureHeight =
		totalHeight -
		parseFloat(computedStyle.paddingTop) -
		parseFloat(computedStyle.paddingBottom) -
		parseFloat(computedStyle.borderTopWidth) -
		parseFloat(computedStyle.borderBottomWidth);

	let inlineStyleContent = el.getAttribute("style");

	// Restore the element's display and opacity.
	if (inlineStyleContent) {
		inlineStyleContent = inlineStyleContent.replace(
			/display\s*:\s*block\s*;/,
			"",
		);

		inlineStyleContent = inlineStyleContent.replace(/opacity\s*:\s*0\s*;/, "");

		el.setAttribute("style", inlineStyleContent);
	}

	return pureHeight;
}
