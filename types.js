/**
 * Pre-defined device breakpoints.
 *
 * @typedef {Object} WpbfBreakpoints
 *
 * @property {number} desktop
 * @property {number} tablet
 * @property {number} mobile
 */

/**
 * WpbfSite object.
 *
 * @typedef {Object} WpbfSite
 *
 * @property {function():WpbfBreakpoints} getBreakpoints - Get breakpoint values for desktop, tablet, and mobile.
 * @property {function():string} getActiveBreakpoint - Get the current active breakpoint.
 * @property {function():boolean} isInsideCustomizer - Check whether we're inside customizer or not.
 * @property {function(NodeList|string, function(Element): void): void} forEachEl - Iterates over a collection of elements and applies a function to each.
 * @property {function(string, string|null, function(Event): void): void} listenDocumentEvent - Add document's event listener with optional selector to filter the target.
 * @property {function(string|HTMLElement, string): string} getAttr - Get attribute value of an element.
 * @property {function(string|HTMLElement, string): string} getAttrAsNumber - Get attribute value of an element as number.
 */

/**
 * Global `Wpbf` object.
 *
 * @typedef {Object} Wpbf
 *
 * @property {WpbfSite} site
 */

/**
 * Global `LegacyWpbfTheme` object.
 *
 * @typedef {Object} LegacyWpbfTheme
 *
 * @property {WpbfBreakpoints} breakpoints - Breakpoint values for desktop, tablet, and mobile.
 * @property {string} activeBreakpoint - The current active breakpoint.
 * @property {boolean} isInsideCustomizer - Whether we're inside customizer or not.
 */

/**
 * WpbfCustomize object.
 *
 * @typedef {import("./Customizer/Controls/Base/src/interface").WpbfCustomize} WpbfCustomize
 */

/**
 * Global `wp` object.
 *
 * @typedef {Object} wp
 *
 * @property {WpbfCustomize|undefined} customize
 */

/**
 * Override the global window object to include custom properties.
 *
 * @typedef {Object} WpbfThemeWindow
 *
 * @property {wp} wp
 * @property {Wpbf} Wpbf
 * @property {LegacyWpbfTheme} WpbfTheme
 */

/**
 * @typedef {Window & LegacyWpbfTheme} WpbfWindow
 */
