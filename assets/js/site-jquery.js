/// <reference path="../../types.js"/>

import setupjQuerySite from "./setup/jquery-site-general";
import setupjQueryDesktopMenu from "./setup/jquery-desktop-menu";
import setupjQueryMobileMenu from "./setup/jquery-mobile-menu";

// Export `WpbfTheme` object to `window` for backwards compatibility.
// @ts-ignore
window["WpbfTheme"] = setupjQuerySite(jQuery);

setupjQueryDesktopMenu(jQuery);
setupjQueryMobileMenu(jQuery);
