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
} from "./utils/dom-utils";

function init() {
	setupSite();
	setupDesktopMenu();
	setupMobileMenu();
}

init();

// Export `Wpbf` object to `window`.
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
window["WpbfTheme"] = {
	breakpoints: getBreakpoints(),
	activeBreakpoint: getActiveBreakpoint(),
	isInsideCustomizer: isInsideCustomizer(),
};
