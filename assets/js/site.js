import setupDesktopMenu from "./setup/desktop-menu";
import setupMobileMenu from "./setup/mobile-menu";
import setupSite from "./setup/site-general";

/**
 * @type {WpbfUtils} utils
 */
// @ts-ignore
const utils = window.WpbfUtils;

init();

function init() {
	setupSite(utils);
	setupDesktopMenu(utils);
	setupMobileMenu(utils);
}

// @ts-ignore
window["WpbfTheme"] = {
	// For backwards compatibility.
	breakpoints: utils.dom.getBreakpoints(),
	activeBreakpoint: utils.dom.getActiveBreakpoint(),
	isInsideCustomizer: utils.isInsideCustomizer(),
};
