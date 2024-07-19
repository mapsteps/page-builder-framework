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
 * Global `WpbfTheme` object.
 *
 * @typedef {Object} WpbfTheme
 *
 * For backwards compatibility:
 *
 * @property {WpbfBreakpoints} breakpoints - Breakpoint values for desktop, tablet, and mobile.
 * @property {string} activeBreakpoint - The current active breakpoint.
 * @property {boolean} isInsideCustomizer - Whether we're inside customizer or not.
 */

/**
 * @typedef {Object} WpbfDom
 *
 * @property {function(string): (HTMLElement|null)} findHtmlEl
 * @property {function(string): HTMLElement[]} getHtmlEls
 * @property {function(HTMLElement): (HTMLElement|null)} getParentHtmlEl
 * @property {function(HTMLElement, string=): HTMLElement[]} getSiblings
 * @property {function(HTMLElement): (HTMLElement|null)} getSiblingHtmlEl
 * @property {function((Element|string), string, string=): Element[]} getNextElsUntil
 * @property {function((Element|string), string, string=): Element[]} getPrevElsUntil
 * @property {function(string): (HTMLElement|null)} getLastHtmlEl
 * @property {function(HTMLElement, string): (HTMLElement|null)} directQuerySelector
 * @property {function((string|NodeListOf<Element>|HTMLElement[]), function(Element): void): void} forEachEl
 * @property {function(string, (string|null), function(any): void): void} listenDocumentEvent
 * @property {function((HTMLElement|string), string): string} getAttr
 * @property {function((HTMLElement|string), string): number} getAttrAsNumber
 * @property {function(): WpbfBreakpoints} getBreakpoints
 * @property {function(): string} getActiveBreakpoint
 * @property {function((HTMLElement|Element), string): void} updateElSrc
 * @property {function(HTMLElement): {top: number, left: number}} getOffset
 * @property {function(): number} getWindowScrollTop
 * @property {function(HTMLElement): number} getPureHeight
 * @property {import("vanjs-core").Van} builder
 */

/**
 * @typedef {object} SlideToggleOpts
 *
 * @property {HTMLElement}           el HTMLElement to slide up or down.
 * @property {'up'|'down'}           direction The slide direction. Accepts either "up" or "down".
 * @property {number|undefined}      [duration] The animation duration.
 * @property {string|undefined}      [easing] The CSS animation easing.
 * @property {() => void|undefined}  [callback] The function to be called after animation done.
 * @property {string|undefined}      [animScope] Scope of the CSS animation.
 */

/**
 * @typedef {Object} WpbfAnim
 *
 * @property {function(HTMLElement, number): void} hideElAfterDelay
 * @property {function(HTMLElement, (string|undefined), string=): HTMLStyleElement} writeElStyle
 * @property {function(HTMLElement, (string|undefined)): string} getElStyleId
 * @property {function(HTMLElement, (string|undefined)): HTMLStyleElement} getElStyleTag
 * @property {function(number, number): void} animateScrollTop
 * @property {function(SlideToggleOpts): void} slideToggle
 */

/**
 * @typedef {Object} WpbfUrl
 *
 * @property {function(string, Object<string, any>): string} addUrlParams
 */

/**
 * @typedef {Object} WpbfUtils
 *
 * @property {function(): boolean} isInsideCustomizer
 * @property {WpbfDom} dom
 * @property {WpbfAnim} anim
 * @property {import("ky").KyInstance} fetch
 * @property {WpbfUrl} url
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
 * @property {any} media
 */

/**
 * Custom window object.
 *
 * @typedef {Object} WpbfWindow
 *
 * @property {WpbfUtils} WpbfUtils
 * @property {WpbfTheme} WpbfTheme
 * @property {wp} wp
 */
