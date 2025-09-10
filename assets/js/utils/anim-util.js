/**
 * Hide an element after a delay.
 *
 * @param {HTMLElement} el - The element to hide.
 * @param {number} delay - The delay in milliseconds.
 */
export function hideElAfterDelay(el, delay) {
	if (!el) return;
	if (typeof delay !== "number") return;

	setTimeout(function () {
		el.style.display = "none";
	}, delay);
}

/**
 * Get the value of inline style's width property.
 *
 * @param {HTMLElement} el - The element to get the inline width from.
 * @return {string|boolean} The inline width value. Returns false if no inline width is found.
 */
function getInlineWidth(el) {
	const styleContent = el.getAttribute("style");
	if (!styleContent) return false;

	// The width value can be px or % or other units. Generate the regex regardless of the units.
	const regex = new RegExp(`width\\s*:\\s*(\\d+\\w+)\\s*;`);
	const match = styleContent.match(regex);

	if (match) {
		return match[1];
	}

	return false;
}

/**
 * Remove inline style's width property.
 *
 * @param {HTMLElement} el - The element to remove the inline width from.
 */
export function removeInlineWidth(el) {
	const styleContent = el.getAttribute("style");
	if (!styleContent) return;

	if (getInlineWidth(el)) {
		el.setAttribute(
			"style",
			styleContent.replace(/width\s*:\s*(\d+\w+)\s*;/, ""),
		);
	}
}

/**
 * Get a generated style tag from an HTML element.
 *
 * @param {HTMLElement} el - The element to generate the style tag from.
 * @param {string|undefined} styleContent - The style content.
 *
 * @return {HTMLStyleElement} The style tag.
 */
export function writeElStyle(el, styleContent) {
	const id = el.id
		? el.id
		: "wpbf-" + Math.random().toString(36).substring(2, 9);
	if (!el.id) el.id = id;

	const styleTagId = `wpbf-style-${id}`;

	const styleTag = document.querySelector(`#${styleTagId}`);

	if (styleTag && styleTag instanceof HTMLStyleElement) {
		if (styleContent) styleTag.innerHTML = styleContent;
		return styleTag;
	}

	const newStyleTag = document.createElement("style");

	newStyleTag.id = `wpbf-style-${id}`;
	if (styleContent) newStyleTag.innerHTML = styleContent;
	document.head.appendChild(newStyleTag);

	return newStyleTag;
}

/**
 * Get id of a generated style tag from an HTML element.
 *
 * @param {HTMLElement} el - The element to generate the style tag from.
 * @return {string}
 */
export function getElStyleId(el) {
	const styleTag = writeElStyle(el, undefined);
	return styleTag.id;
}

/**
 * Get the generated style element of an HTML element.
 *
 * @param {HTMLElement} el - The element to generate the style tag from.
 * @return {HTMLStyleElement}
 */
export function getElStyleTag(el) {
	return writeElStyle(el, undefined);
}

/**
 * Animate scroll top.
 *
 * @param {number} targetPosition - The target position to scroll to.
 * @param {number} duration - The duration in milliseconds.
 */
export function animateScrollTop(targetPosition, duration) {
	const startPosition = window.scrollY;
	const distance = targetPosition - startPosition;
	const startTime = performance.now();

	/**
	 * @param {number} timestamp
	 */
	function scrollStep(timestamp) {
		const currentTime = timestamp - startTime;
		window.scrollTo(0, swing(currentTime, startPosition, distance, duration));

		if (currentTime < duration) {
			requestAnimationFrame(scrollStep);
		}
	}

	requestAnimationFrame(scrollStep);
}

/**
 * Swing effect.
 *
 * @param {number} time
 * @param {number} start
 * @param {number} change
 * @param {number} duration
 *
 * @return {number}
 */
function swing(time, start, change, duration) {
	return (
		start + change / 2 - (change / 2) * Math.cos((Math.PI * time) / duration)
	);
}
