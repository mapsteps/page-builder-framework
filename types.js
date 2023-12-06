/**
 * @typedef {Object} SiteObject
 * @property {boolean} isInsideCustomizer - Whether we're inside customizer or not.
 * @property {Object} breakpoints - Pre-defined breakpoints.
 * @property {string} activeBreakpoint - The current active breakpoint.
 * @property {function} processElements - Method to iterates over a collection of elements and applies a function to each.
 * @property {function} addEventHandler - Method to add event handler to the document.
 * @property {function} getDataset - Method to get dataset value of an element.
 * @property {function} getDatasetAsNumber - Method to get dataset value of an element as number.
 */

/**
 * @typedef {Object} WpbfTheme
 * @property {SiteObject} site - Core module to handle the site wide JS functionality.
 * @property {Object} desktopMenu - Module to handle the desktop menu JS functionality.
 * @property {Object} mobileMenu - Module to handle the mobile menu JS functionality.
 */
