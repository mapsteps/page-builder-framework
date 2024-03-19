import setupDesktopMenu from "./setup/desktop-menu-jquery";
import setupMobileMenu from "./setup/mobile-menu-jquery";
import setupSite from "./setup/site-general-jquery";

// Export `WpbfTheme` object to `window` for backwards compatibility.
window["WpbfTheme"] = setupSite(jQuery);

setupDesktopMenu(jQuery);
setupMobileMenu(jQuery);
