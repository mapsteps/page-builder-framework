/**
 * Aura global object.
 *
 * @typedef {Object} Aura
 * @property {function():DeviceBreakpoints} getBreakpoints Get breakpoint values for desktop, tablet, and mobile.
 * @property {function():string} getActiveBreakpoint Get the current active breakpoint.
 * @property {function():boolean} isInsideCustomizer Check whether we're inside customizer or not.
 * @property {function(NodeList|string, function(Element))} forEachEl Iterates over a collection of elements and applies a function to each.
 * @property {function(string, string|null, function(Event))} listenDocumentEvent Add document's event listener with optional selector to filter the target.
 * @property {function(string|HTMLElement, string): string} getAttr Get attribute value of an element.
 * @property {function(string|HTMLElement, string): string} getAttrAsNumber Get attribute value of an element as number.
 * @property {function(): void} reinit Reinitialize the site scripts.
 */

/**
 * Pre-defined device breakpoints.
 *
 * @typedef {Object} DeviceBreakpoints
 * @property {number} desktop
 * @property {number} tablet
 * @property {number} mobile
 */
