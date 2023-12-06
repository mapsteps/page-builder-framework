/**
 * @typedef {Object} SiteModule
 * @property {boolean} isInsideCustomizer Whether we're inside customizer or not.
 * @property {Object} breakpoints Pre-defined breakpoints.
 * @property {string} activeBreakpoint The current active breakpoint.
 * @property {function(NodeList|string, function(Element))} processElements Method to iterates over a collection of elements and applies a function to each.
 * @property {function(string, string|null, function(Event))} addEventHandler Method to add event handler to the document.
 * @property {function(string|HTMLElement, string): string} getDataset Method to get dataset value of an element.
 * @property {function(string|HTMLElement, string): string} getDatasetAsNumber Method to get dataset value of an element as number.
 */

/**
 * @typedef {Object} DesktopMenuModule
 */

/**
 * @typedef {Object} MobileMenuModule
 */

/**
 * @typedef {Object} WpbfTheme
 * @property {SiteModule} site Core module to handle the site wide JS functionality.
 * @property {DesktopMenuModule} desktopMenu Module to handle the desktop menu JS functionality.
 * @property {MobileMenuModule} mobileMenu Module to handle the mobile menu JS functionality.
 */
