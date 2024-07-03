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

// @ts-ignore
window["WpbfTheme"] = {
	// For backwards compatibility.
	breakpoints: getBreakpoints(),
	activeBreakpoint: getActiveBreakpoint(),
	isInsideCustomizer: isInsideCustomizer(),

	// New properties.
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
