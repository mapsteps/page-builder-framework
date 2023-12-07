import setupDesktopMenu from "./inc/desktop-menu";
import setupMobileMenu from "./inc/mobile-menu";
import setupSite from "./inc/site-general";
import {
	getBreakpoints,
	forEachEl,
	getActiveBreakpoint,
	getAttr,
	getAttrAsNumber,
	isInsideCustomizer,
	listenDocumentEvent,
	getBreakpoints,
} from "./inc/utils";

function init() {
	setupSite(jQuery);
	setupDesktopMenu(jQuery);
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
	reinit: init,
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

// Export Aura object to module.
export default Aura;
