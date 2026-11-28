# Page Builder Framework: roadmap

The one place to look. Four steps, one at a time; only ever think about the next one. Details live in
`CUSTOMIZER-PLAN.md` ("For later") and `SETTINGS-AUDIT.md`; this file only says what's next and where things belong.

Last updated: November 28, 2026.

## Done

- **Customizer rebuilt** (November 18-19, 2026): own control engine, settings schema, CSS per area, instant preview.
  `CUSTOMIZER-PLAN.md`.
- **Every theme setting checked** against its label (November 19) and the 30 problems sorted (November 27-28): 26 fixed,
  4 kept on purpose, block editor buttons left out. `SETTINGS-AUDIT.md`.
- **Theme Settings page** on the new heatbox (2.12.3).
- **Leaner Google Fonts**: one rule per font file, unused fonts deleted, text font preloaded, more weights per font
  (variable fonts get every weight). Switched-off fonts don't load.

## 1. Finish the Customizer control styling (running)

One clean, consistent look for every control, close to WordPress's own. Session "Uniform styling for the theme's
Customizer controls". Open there: the undo icon, the last check.

## 2. Premium settings check

The same round as the theme's audit, for Premium's own Customizer settings: does each one do what its label says, live
and in the preview. Already found (details in `CUSTOMIZER-PLAN.md` -> Premium pass):

- A post type's Sidebar setting beats the sidebar picked on a single post.
- Mini cart buttons: Theme Button color also hits primary buttons (fixed in the theme, not in Premium).
- Navigation Width without "px" in the stacked advanced menu.
- Three width fields still say "Default: 1200px".
- Premium's sizes need "px" when a plain number is typed; some previews (line height, letter spacing, off canvas
  background) cover less than the live page.
- Housekeeping: Premium's backwards compatibility and settings files run on every page.
- Infinite scroll loader (blog and shop): an old animated GIF (`assets/img/loader.gif`, used by `js/infinite-scroll.js`
  and `js/wpbf-premium-woo-infinite-scroll.js`). Give it a modern look, e.g. the theme's own CSS spinner
  (`.wpbf-button.is-loading`). User, November 28, 2026: not now, note it.

## 3. Settings and grouping review (your decisions)

Which settings to add, modernize or drop, and whether the Customizer panels and sections are grouped sensibly. Claude
prepares a list to decide from; nothing changes without your yes. Open decisions already waiting:

- Font alphabets: load only the ones the site needs, as a Customizer option (default: all).
- Slider numbers typed without a unit are saved without "px" (the theme adds it, Premium doesn't).
- Premium's HTML code fields get no color highlighting (turning it on also shows HTML warnings).

## 4. "Built right" review of the rest of the theme

Area by area, like the Customizer rebuild: what's there, what's wrong, fix in small steps.

- Templates: header, footer, blog, posts, pages, archives, search, 404 (and the hooks child themes rely on).
- Integrations: WooCommerce, EDD. Block editor is its own construction zone (leave it until you say so).
- Front-end scripts and stylesheets, accessibility, speed.
- Settings page code (e.g. the compatibility notice), the build scripts (`wpbf.mjs`), lint errors outside the
  Customizer.
- Not tested yet (needs real shop data): WooCommerce products per row, cart count, AJAX add to cart, block cart/checkout
  colors; EDD cart menu item, "Count" preview.
- Customizer leftovers: the font list is sent 13 times (Customizer page could be half the size); typography select after
  a reset; color fields showing `#000000` for transparent; a few preview-only glitches; small code cleanups.
