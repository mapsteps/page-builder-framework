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
	getBreakpoints,
} from "./utils/dom-utils";

function init() {
	setupSite();
	setupDesktopMenu();
	setupMobileMenu(jQuery);
}

init();

const Aura = {
	getBreakpoints: getBreakpoints,
	getActiveBreakpoint: getActiveBreakpoint,
	isInsideCustomizer: isInsideCustomizer,
	forEachEl: forEachEl,
	listenDocumentEvent: listenDocumentEvent,
	getAttr: getAttr,
	getAttrAsNumber: getAttrAsNumber,
};

// Export Aura object to window.
window.Aura = Aura;

// For compatibility.
window.Wpbf = {
	site: {
		breakpoints: getBreakpoints(),
		activeBreakpoint: getActiveBreakpoint(),
		isInsideCustomizer: isInsideCustomizer(),
	},
};
