/// <reference path="../../types.js"/>

import setupDesktopMenu from "./setup/desktop-menu";
import setupMobileMenu from "./setup/mobile-menu";
import setupSite from "./setup/site-general";
import {
	getBreakpoints,
	forEachEl,
	getActiveBreakpoint,
	getAttr,
	getAttrAsNumber,
	isInsideCustomizer,
	listenDocumentEvent,
} from "./utils/dom-util";

function init() {
	setupSite();
	setupDesktopMenu();
	setupMobileMenu();
}

init();

// Export `Wpbf` object to `window`.
// @ts-ignore
window["Wpbf"] = {
	site: {
		getBreakpoints: getBreakpoints,
		getActiveBreakpoint: getActiveBreakpoint,
		isInsideCustomizer: isInsideCustomizer,
		forEachEl: forEachEl,
		listenDocumentEvent: listenDocumentEvent,
		getAttr: getAttr,
		getAttrAsNumber: getAttrAsNumber,
	},
};

// Export `WpbfTheme` object to `window` for backwards compatibility.
// @ts-ignore
window["WpbfTheme"] = {
	breakpoints: getBreakpoints(),
	activeBreakpoint: getActiveBreakpoint(),
	isInsideCustomizer: isInsideCustomizer(),
};
