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

export function hasComputedOpacityFull(el) {
	if (!el) return false;

	const computedStyle = window.getComputedStyle(el);
	const opacity = computedStyle.getPropertyValue("opacity");

	return opacity === "1";
}

export function hasComputedOpacityZero(el) {
	if (!el) return false;

	const computedStyle = window.getComputedStyle(el);
	let opacity = computedStyle.getPropertyValue("opacity");
	opacity = parseFloat(opacity);

	return opacity === 0;
}

export function hasComputedDisplayNone(el) {
	if (!el) return false;

	const computedStyle = window.getComputedStyle(el);
	const display = computedStyle.getPropertyValue("display");

	return display === "none";
}

export function hasInlineDisplayNone(el) {
	const styleContent = el.getAttribute("style");
	if (!styleContent) return false;

	if (styleContent.match(/display\s*:\s*none\s*;/)) {
		return true;
	}

	return false;
}

export function hasInlineDisplayNotNone(el) {
	const styleContent = el.getAttribute("style");
	if (!styleContent) return false;

	// Check if styleContent contains display other than none.
	if (styleContent.match(/display\s*:\s*(?!none).*;/)) {
		return true;
	}

	return false;
}

/**
 * Remove display: none; from element's inline style attribute.
 *
 * @param {HTMLElement} el The element to remove display: none; from.
 */
export function removeInlineDisplayNone(el) {
	const styleContent = el.getAttribute("style");

	if (hasInlineDisplayNone(el)) {
		el.setAttribute(
			"style",
			styleContent.replace(/display\s*:\s*none\s*;/, ""),
		);
	}
}

/**
 * Remove display: none; from element's inline style attribute.
 *
 * @param {HTMLElement} el The element to remove display: none; from.
 */
export function removeInlineDisplayNotNone(el) {
	const styleContent = el.getAttribute("style");

	if (hasInlineDisplayNone(el)) {
		el.setAttribute(
			"style",
			styleContent.replace(/display\s*:\s*(?!none).*;/, ""),
		);
	}
}

/**
 * Get the animation style tag.
 *
 * @returns {HTMLElement} The animation style tag.
 */
export function getAnimStyleTag() {
	const tag = document.querySelector("style.aura-animation-style");

	if (!tag) {
		const styleTag = document.createElement("style");
		styleTag.classList.add("aura-animation-style");
		styleTag.innerHTML = ".aura-opacity-0 {opacity: 0;}";
		styleTag.innerHTML += "\n.aura-opacity-1 {opacity: 1;}";
		styleTag.innerHTML += "\n.aura-duration-200 {transition-duration: 200ms;}";
		styleTag.innerHTML += "\n.aura-duration-250 {transition-duration: 250ms;}";
		styleTag.innerHTML += "\n.aura-duration-300 {transition-duration: 300ms;}";
		styleTag.innerHTML += "\n.aura-duration-350 {transition-duration: 350ms;}";
		styleTag.innerHTML += "\n.aura-duration-400 {transition-duration: 400ms;}";
		styleTag.innerHTML +=
			"\n.aura-transition-opacity {transition-property: opacity;}";
		styleTag.innerHTML +=
			"\n.aura-transition-opacity-visibility {transition-property: opacity, visibility;}";
		styleTag.innerHTML +=
			"\n.aura-transition-height {transition-property: height;}";
		styleTag.innerHTML += "\n.aura-transition-all {transition-property: all;}";

		document.head.appendChild(styleTag);

		return styleTag;
	}

	return tag;
}

/**
 * Check if animation property class exists.
 *
 * @param {string} prop The animation property. Accepts 'duration', 'delay', 'timing', 'iteration', 'direction', 'fill-mode', or 'play-state'.
 * @param {string|number} value The animation property value.
 *
 * @return {boolean} Whether the animation property class exists or not.
 */
export function animPropClassExists(prop, value) {
	const tag = getAnimStyleTag();
	const content = tag.innerHTML;

	// Check if content contains rule like this: .aura-duration-350
	const regex = new RegExp(`\\.aura-${prop}-${value}\\s*{`);
	const match = content.match(regex);

	return match ? true : false;
}

/**
 * Fade in an element.
 *
 * @param {HTMLElement} el The element to be faded-in.
 * @param {number} duration The duration in milliseconds.
 */
export function fadeIn(el, duration) {
	if (!el) return;

	const elHasComputedDisplayNone = hasComputedDisplayNone(el);
	const elHasComputedOpacityZero = hasComputedOpacityZero(el);

	// Stop if computed display is not "none".
	if (!elHasComputedDisplayNone) return;

	// Stop if computed opacity is 0.
	if (elHasComputedOpacityZero) return;

	const computedStyle = window.getComputedStyle(el);
	const opacityTarget = parseFloat(computedStyle.getPropertyValue("opacity"));

	const displayNoneCameFromInlineStyle = hasInlineDisplayNone(el);
	let displayTypeTarget = "block";
	let shouldAddDisplay = false;

	if (displayNoneCameFromInlineStyle) {
		removeInlineDisplayNone(el);
		const computedDisplay = computedStyle.getPropertyValue("display");
		displayTypeTarget = computedDisplay === "none" ? "block" : computedDisplay;

		if (computedDisplay === "none") {
			shouldAddDisplay = true;
		}
	}

	const styleTag = getAnimStyleTag();
	let styleContent = styleTag.innerHTML;

	if (!animPropClassExists("opacity", opacityTarget)) {
		styleContent = styleTag.innerHTML;
		styleTag.innerHTML = `${styleContent}\n.aura-opacity-${opacityTarget} {opacity: ${opacityTarget};}`;
	}

	if (!animPropClassExists("duration", duration)) {
		styleContent = styleTag.innerHTML;
		styleTag.innerHTML = `${styleContent}\n.aura-duration-${duration} {transition-duration: ${duration}ms;}`;
	}

	el.classList.add("aura-opacity-0");
	if (shouldAddDisplay) el.style.display = displayTypeTarget;
	el.classList.add("aura-transition-opacity");
	el.classList.add(`aura-duration-${duration}`);
	el.classList.add(`aura-opacity-${opacityTarget}`);

	setTimeout(function () {
		el.classList.remove("aura-opacity-0");
		el.classList.remove(`aura-opacity-${opacityTarget}`);
		el.classList.remove(`aura-duration-${duration}`);
	}, duration);
}

/**
 * Fade out an element.
 *
 * @param {HTMLElement} el The element to be faded-in.
 * @param {number} duration The duration in milliseconds.
 */
export function fadeOut(el, duration) {
	if (!el) return;

	const elHasComputedDisplayNone = hasComputedDisplayNone(el);
	const elHasComputedOpacityZero = hasComputedOpacityZero(el);
	const elHasComputedOpacityFull = hasComputedOpacityFull(el);

	// Stop if computed display is "none".
	if (elHasComputedDisplayNone) return;

	// Stop if computed opacity is not 0.
	if (!elHasComputedOpacityZero) return;

	const computedStyle = window.getComputedStyle(el);
	const opacityFrom = parseFloat(computedStyle.getPropertyValue("opacity"));
	const opacityTarget = 0;

	const displayCameFromInlineStyle = hasInlineDisplayNotNone(el);
	let displayTypeFrom = "block";
	const displayTypeTarget = "none";
	let shouldAddDisplay = false;

	if (displayCameFromInlineStyle) {
		removeInlineDisplayNotNone(el);
		const computedDisplay = computedStyle.getPropertyValue("display");
		displayTypeTarget = computedDisplay === "none" ? "block" : computedDisplay;

		if (computedDisplay === "none") {
			shouldAddDisplay = true;
		}
	}

	const styleTag = getAnimStyleTag();
	let styleContent = styleTag.innerHTML;

	if (!animPropClassExists("opacity", opacityTarget)) {
		styleContent = styleTag.innerHTML;
		styleTag.innerHTML = `${styleContent}\n.aura-opacity-${opacityTarget} {opacity: ${opacityTarget};}`;
	}

	if (!animPropClassExists("duration", duration)) {
		styleContent = styleTag.innerHTML;
		styleTag.innerHTML = `${styleContent}\n.aura-duration-${duration} {transition-duration: ${duration}ms;}`;
	}

	el.classList.add("aura-opacity-0");
	if (shouldAddDisplay) el.style.display = displayTypeTarget;
	el.classList.add("aura-transition-opacity");
	el.classList.add(`aura-duration-${duration}`);
	el.classList.add(`aura-opacity-${opacityTarget}`);

	setTimeout(function () {
		el.classList.remove("aura-opacity-0");
		el.classList.remove(`aura-opacity-${opacityTarget}`);
		el.classList.remove(`aura-duration-${duration}`);
	}, duration);
}
