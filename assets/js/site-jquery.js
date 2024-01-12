import setupDesktopMenu from "./setup/desktop-menu-jquery";
import setupMobileMenu from "./setup/mobile-menu-jquery";
import setupSite from "./setup/site-general-jquery";

/** @type {LegacyWpbfTheme} */
const WpbfTheme = {
    site: setupSite(jQuery),
};

window["WpbfTheme"] = WpbfTheme;

setupDesktopMenu(jQuery);
setupMobileMenu(jQuery);
