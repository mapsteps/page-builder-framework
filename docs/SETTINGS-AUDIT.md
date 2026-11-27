# Page Builder Framework: Customizer settings audit (November 19, 2026)

Does each theme setting do what its label says? Checked on pbf.local with Premium 2.11 active, theme branch `redo`
(= `master`). Nothing fixed, nothing committed.

## Status (fixing started November 27, 2026)

Worked through one by one in the fix order below, each reproduced on pbf.local first, then pushed.

- Fixed: #1 EDD download sidebar, #2 "Inherit Global" sidebar on posts (+ Sidebar page template; posts now inherit General -> Sidebar, not the archive), #3 primary buttons taking the Theme Button color, #5 headings losing bold, #6 centered menu text logo, #7 mobile menu 16px, #14 tablet logo/tagline size (now up to 1024px), #15 mobile sub menu indent.
- Kept on purpose (user): #8 hamburger icon stays white on a colored Icon Button (Icon Color also colors the search/cart icons).
- Left out (user): #4 block editor buttons and the Accent Color. Block editor styles are their own construction zone.
- Not covered by this audit: Premium's own settings (see CUSTOMIZER-PLAN.md -> For later -> Premium pass).
- Next: #16 mobile tagline.

## In short (plain language)

Most settings work: about 230 checks passed, in the preview and on the live site alike. The real problems:

- **Sidebars:** EDD download pages never show a sidebar, whatever you pick. "Position (Global)" isn't global:
  posts set to "Inherit Global Settings" follow the Blog Archive sidebar instead.
- **Buttons:** once any Theme Button color is set, primary buttons (like "Read more") take that color instead of the
  accent color, unless primary colors are set too. Block-editor buttons ignore the Accent Color.
- **Headings lose their bold** when the Text font is on and the H1 font switch is off.
- **Header:** centered menu + text logo shows the logo in menu color/size. The mobile menu can't be set back to 16px
  once the desktop menu size isn't 16. The hamburger "Icon Color" is ignored once an "Icon Button" color is set. The
  logo text size for tablets only applies below 768px. Mobile sub menu indent ignores the item padding. The mobile
  tagline stays on after switching the tagline off.
- **Shop:** "Image Alignment: Right" on product pages hides all sale badges. The shop "List" layout also changes the
  related products on product pages.
- **Blog:** "Image Beside Post" always shows the featured image, even when it's unchecked.
- **Breadcrumbs:** "Front Page" alone never shows on a static front page. With Yoast (as on this site) or Rank Math,
  all breadcrumb design settings do nothing.
- **Small but common:** a width typed without "px" (e.g. 1400) silently does nothing; a padding of 0 is ignored in
  several places; Boxed Layout "Padding" stops working once Page Padding is changed.

## Suggested fix order

1. EDD download page sidebar (one-line fix, very visible, broken since 2.4).
2. Primary buttons taking the Theme Button color (+ block buttons and accent color).
3. "Inherit Global" sidebar on posts (and the page template variant).
4. Headings losing bold.
5. Header group: centered text logo, mobile font size 16, hamburger icon color, tablet logo size breakpoint, mobile
   sub menu indent, mobile tagline.
6. WooCommerce: sale badge hidden with image right; list layout leaking to product pages.
7. "Image Beside Post" featured image; breadcrumbs Front Page; breadcrumbs vs SEO plugins (at least a note in the
   Customizer).
8. Unitless widths (add px like `{option|px}`) and padding 0 everywhere; Boxed padding vs Page Padding.
9. The rest (small wording/defaults, preview-only glitches, code-only WooCommerce/EDD items).

## How it was tested

- Real clicks and keys in the Customizer (headless Chrome, harness `au-lib.mjs` + `au-help.mjs` in this folder,
  copied from the battle test), changes batched per section, **Publish**, then the same checks on the live page
  (computed styles, elements shown/hidden, texts, classes, real mouse hover, desktop 1400 / tablet 800 / phone 375).
  Every check also ran in the preview before publishing. Scripts: `au-general.mjs`, `au-general2.mjs`,
  `au-typography.mjs`, `au-header.mjs`, `au-blog.mjs`, `au-footer.mjs`, `au-woo.mjs`, `au-misc.mjs`, `au-final.mjs`;
  results `au-result-*.json`.
- The first General run used the site as it is (child theme `wpbf-child`). All other runs used the **theme alone**
  (child theme switched off only for the test browser by a temporary cookie-gated mu-plugin, so the child's own
  templates and CSS don't hide theme behavior). The same mu-plugin turned Yoast's breadcrumbs off and used the theme's
  404 template for the test browser only.
- Four code reviews (one per area) listed what each setting should do and suspected bugs:
  `static-general-typography.md`, `static-header.md`, `static-blog-footer.md`, `static-woo-edd.md` (file:line for
  every item). Most suspected bugs were then confirmed live; the ones marked **code** below were not tested live.
- Legend: **live** = seen on the live page after Publish (and in the preview unless noted); **code** = from reading
  the code only; **preview only** = live is right, the preview isn't.
- "Since": from the code reviews / `git log -S`. Most CSS was rewritten on Nov 18–19 with identical output, so the
  old releases behave the same unless noted.

## Broken, most visible first

| # | Setting (section) | What happens vs. the label | How seen | Since |
|---|---|---|---|---|
| 1 | Product Page Sidebar (EDD) + Sidebar Position (Global) | EDD download pages have **no sidebar at all** whatever is chosen. The per-download meta is empty, `'' !== 'global'` sets the layout to `''`, body class `wpbf-sidebar-`. `inc/integration/edd/edd-functions.php:128` | live: set Right → `wpbf-sidebar-`, no sidebar | 2.4 (5b2c130a) |
| 2 | Sidebar Position (Global) / Post "Inherit Global Settings" | Posts on "Inherit Global" follow **Blog Archive → Sidebar**, not the global position (archive None + global Left → post has no sidebar). Pages with the old "Sidebar" template also turn Global into none. `inc/helpers.php:1108-1131` | live | 1.8 |
| 3 | Theme Buttons: Background / Hover (General → Theme Buttons) | With Theme Button colors set and Primary colors empty (their default), **primary buttons** (Read more = Button (Primary)) show the normal button color, not the accent. Preview shows the accent color, live the button color (#112233). CSS order `styles/general.php:224-239` | live + preview differs | old (2.11.x) |
| 4 | Accent Color (Typography → Text) | Block-editor buttons (`.wp-block-button__link`, outline too) keep Premium's theme accent color (#00b1ff), the Accent Color and empty primary colors don't reach them. Content links follow it fine. | live | old |
| 5 | Font Settings (Text) + H1 Font Settings off | Text font prints `font-weight:400` on h1–h6, so **h1/h2 (and every heading without its own switch) lose bold** when the H1 switch is off. `styles/typography.php:31` | live: h1:400 h2:400 | long-standing |
| 6 | Menu: Centered + text logo | The logo inside the centered menu takes the **menu font color and size** (got #aa00aa/18px, set logo #aa0000/30px). | live | old |
| 7 | Mobile Navigation → Font Size | Can't be **16px** once Navigation → Font Size isn't 16: desktop size applies to the mobile menu, 16 (mobile default) never prints. `styles/header.php:149-156` vs `:283` | live: set 16 → 18px | old |
| 8 | Mobile Navigation → Icon Color + Hamburger Icon Button | With an icon button color set, the icon is forced white (`#fff !important`), **Icon Color is ignored**. | live | 2.0 (a46fd343) |
| 9 | Product page → Image Alignment: Right (WooCommerce) | **Hides every sale badge** on the product page (incl. related products). `styles/woocommerce.php:262` | live | old |
| 10 | Shop → Layout: List (WooCommerce) | Body class `wpbf-woo-list-view` on **every page**, so related products/upsells on product pages turn into a list too. `inc/body-classes.php:45-47` | live | old |
| 11 | Blog Archive → Layout "Image Beside Post" + Header without Featured Image | Featured image **always shows** in the beside layout. `blog-layouts/beside.php:18-22` | live | 2.9 or older |
| 12 | Breadcrumbs → Display on "Front Page" | Not shown on a static front page unless "Pages" is also picked ("Pages" check runs first). The posts page isn't covered by any choice. `inc/breadcrumbs.php:71-76` | live | 2018 |
| 13 | Breadcrumbs (all design options) | With Yoast or Rank Math breadcrumbs on (pbf.local uses Yoast), separator, alignment, colors, background and "Below Header" bar do nothing (their markup). With SEOPress both trails print (missing `return`). `inc/breadcrumbs.php:88-106` | live (theme's own crumbs only appeared with Yoast's off) | 2.1.1 |
| 14 | Logo → Font Size (tablet), Tagline Font Size (tablet) | Tablet value only applies **up to 768px**, but the mobile logo shows up to 1024px: at 800px the desktop size is used. | live: 800px → 30px instead of 26px | old |
| 15 | Mobile Sub Menu → Indent | Always adds 20px, ignoring Mobile Navigation → Padding (left): padding 30 + indent 30 gives 50px, sub items sit left of their parents. `styles/header.php:289-291` | live | 2.6 |
| 16 | Logo → Display Tagline on Mobile | Switching **Display Tagline** off afterwards leaves the mobile tagline on (its switch is hidden then, color/size no longer apply). | live | old |
| 17 | Layout → Boxed Layout → Padding | Once Page Padding is changed (any side), its `#inner-content` rule beats the boxed padding: content keeps 20px instead of 40px; only header/footer containers follow. | live | old |
| 18 | Widths typed without a unit: Page Width, Navigation Width, Pre Header Width, Footer Width, Blog/Post Custom Content Width, Shop/Product Custom Content Width | `1400` is accepted without a warning but prints `max-width:1400` (invalid), **nothing changes**. Theme uses `{option}` not `{option|px}`. | live (Page Width); code (others) | old |
| 19 | Padding side set to 0: Sub Menu item padding, Mobile Navigation padding, Blog/Post Boxed padding, Archive Space Between | 0 is ignored, the theme's 10/20px stays. | live (sub menu left 0 → 20px); code (others) | old |
| 20 | Excerpt Length 0 / Excerpt Indicator | 0 gives 55 words. The indicator is glued to the last word (a typed leading space is trimmed: "H2zzmore"); the field shows `[...]` as default while WordPress prints ` […]`. `theme-mods.php:23,39-47` | live | old |
| 21 | 404 Title/Text, Breadcrumb Separator, Meta Separator | Can't be emptied: empty falls back to the default. | code | old |
| 22 | Post Layout → Disable Comments | Hides the comment list and form; comments stay open (can still be posted). `comments.php:11` | live (form gone) + code | old |
| 23 | Post Layout → Footer "Read More" | Offered, but no template exists: nothing shows. `settings-blog.php:701-705` | code | old |
| 24 | "Default: 1200px" descriptions (Navigation/Pre Header/Footer/Blog/Post widths) | Empty actually means the global Page Width (1280px on this site). | code | old |
| 25 | Logo Container Width / (Mobile) | Only works for menu Right/Left; the mobile one only for Hamburger; the label doesn't say so. Also limits the logo: logo width 200 showed 192px with a 20% container. | live + code | old |
| 26 | Navigation font vs Footer font | The Navigation font also hits footer and pre-header menus (they use `.wpbf-menu`), overriding the Footer font there. | code | old |
| 27 | Sub menu / mobile sub menu Font Color | Setting it switches off the inherited Navigation hover color on sub items (same weight, later rule). | code | old |
| 28 | Scroll to Top colors, Mobile Divider Color, WooCommerce tabs/price/title colors | Defaults shown in the Customizer differ from what visitors see; picking the shown default does nothing. | code | old |
| 29 | Accent Color → Hover | Also recolors the current main-menu item with `!important`. | code | old |
| 30 | Font switches off | Fonts stay loaded when their switch is off. `FontsOutput.php:334-341` | code | old |

### WooCommerce / EDD, code only (not reproducible with 4 test products or the block cart)

- Products per Row: products per page always assume 4 columns (last row incomplete with 3 per row); related products
  show 4 items in 3 columns (`woocommerce-functions.php:515`, since 2.11.0.2). No min/max (7–9 or 0 breaks the grid).
- Cart count in the menu goes stale after AJAX add on product pages / changes on `/cart/` (since WooCommerce 7.8).
- AJAX add to cart: breaks external/affiliate product buttons; shows errors twice; silently needs WooCommerce's
  "AJAX add to cart buttons on archives" on.
- Checkout "Side by Side" and the notice colors don't reach the block cart/checkout (this site uses blocks).
- "Price Quantity Buttons (+/-)" label is wrong; +/- shows on products whose quantity can't change.
- EDD: adding a download nests the cart menu item inside itself (`edd-ajax.js:16`, since 2.0); "Count" reloads the
  whole preview (misspelled setting, `edd-customizer-settings.php:196`).
- Minor wording: "Hide Breadcrumbs" also hides them on product pages; "Visibility (Desktop)" does nothing with an
  off-canvas menu; cart "Color" only colors the count bubble; sale badge settings also change the product page badge.

### Preview only (live is right)

- Footer Bar column Text: while typing, the preview gets a second `#footer` inside the first (partials lack
  `container_inclusive`, `settings-footer.php:108-115,180-187`). Seen: 2 footers, 1 nested.
- Primary buttons with empty primary colors: preview shows the accent color, live the Theme Button color (see #3).
- WooCommerce menu item Count "Hide": the preview still shows the count.
- Custom Logo URL/alt/title don't update in the preview; Blog general text fields show the first post's content on
  every post until reload; Pre Header column text removes that column's menu until reload (code).
- Text logo Hover right after removing the image logo: preview showed the accent hover color, live correct (once).
- Not the theme: a preview URL that redirects (Yoast removes `/category/`) loses the unsaved changes, so the preview
  shows the saved state there.

### Site-specific (child theme `wpbf-child`, not theme bugs)

- Primary buttons: child CSS sets the radius after the Customizer CSS (12px set → 8px live; known from the battle test).
- The child's 404, search, page and front-page templates skip the theme's hooks: 404 Title/Text, Search Results
  layout options, page sidebar/breadcrumbs don't apply there.
- Logo image `alt` is saved empty on this site.

## Per section: OK (seen working live and in the preview)

- **Layout:** Page Width (with unit), Page Padding desktop/tablet/mobile (tablet value also applies on phones unless
  set), Boxed Layout on/off, Margin, Background, Box Shadow (blur, spread, horizontal, vertical, color), core
  Background Color. Reset buttons reset to the defaults (dimension and text fields have no reset button).
- **Sidebar:** Width, Gap, Widget Padding, Background; Position works where archives/Shop/posts set it explicitly.
- **404 Page** (theme template): Title, Text, Search Form hide.
- **Breadcrumbs** (theme's own trail): on/off, Display on Archives/Single/Search/Pages, Before Content / Below Header,
  Separator, Alignment, Background, Font Color, Accent + Hover.
- **Theme Buttons:** Background, Hover, Font Color, Hover, Border Radius, Border Width, Border Color + Hover, Primary
  Background/Hover/Font/Border.
- **Scroll to Top:** on/off, Left/Right (incl. phone offset), Show after (px), Background + Hover, Icon Color +
  Hover, Border Radius.
- **Typography:** Text font switch + family (body, inputs, buttons), Color, Accent + Hover (links); H1 font applies
  to all headings without their own switch, H2 off follows H1, H3 keeps its own; Navigation font (desktop + mobile);
  Sub Menu font; Footer font; Logo font. Tagline font: rule present (`styles/header.php:91`), not seen live (test
  didn't land on a page with a tagline at that moment).
- **Logo:** Logo Width desktop/tablet/mobile, alt, title, Custom Logo URL (live), text logo Color/Hover/Size desktop +
  phone, Tagline show/color/size, tagline on mobile.
- **Navigation:** Menu Right/Left/Centered/Stacked, Search Icon, Navigation Width (with unit), Menu Height, Item
  Spacing, Background, Font Color + Hover, Font Size.
- **Sub Menu:** Width, Alignment, Text Alignment, Item Padding (non-zero), Background, Font Color, Font Size,
  Separator + Color. (Hover colors: rules present, not hovered in the test.)
- **Mobile Navigation:** Hamburger/Default, Search Icon, Height, Background, Icon Size, Icon Button color + radius,
  Item Padding, Item Background, Font Color, Divider Color, Sub Menu Arrow Color; menu opens on tap; shows from 1024px
  down. **Mobile Sub Menu:** Auto Collapse (class), Background, Font Color, Font Size.
- **Pre Header:** None/Two Columns, column texts, Width, Height, Background, Font Color, Link Color + Hover, Font Size.
- **Blog General:** Meta Separator, Author Avatar, Excerpt Length, Excerpt Indicator (see #20), Read More link
  type/text, Categories Title. **Pagination:** Background, Font Color, Active background/color, Border Radius, Font
  Size (hover rules present; the test browser's admin bar covered the links).
- **Blog Archive:** Custom Width, Headline Show/Hide, Sidebar, Layout Default/Beside, Style Boxed, Boxed Padding,
  Content Alignment, Background, Accent + Hover, Title/Font Size, Space Between, Image Right, Image Width, Footer
  Categories.
- **Post Layout:** Custom Width, Sidebar Left, Header Meta, Footer Categories, Disable Comments (form gone), Post
  Navigation, Boxed Padding + Background, Title Size, Content Size.
- **Footer Bar:** Column texts incl. `[year]`, Column Menu ("Add Menu" link without a menu), Width, Height,
  Background, Font Color, Link + Hover, Font Size, One Column, None.
- **WooCommerce:** Shop width, hide title/breadcrumbs/result count/ordering, Products per Row, Grid Gap, Content
  Alignment, Sale badge position/layout/alignment/size/colors, Title and Price size/color, Out of Stock notice colors
  and size, Shop Sidebar; Product page width, Image Width, Lightbox off, Summary Separator, Quantity Buttons hide,
  Price color/size, Tabs colors/size, Product Sidebar, Image Right (badge aside); Cart menu item desktop/mobile/count,
  Store Notice color. **EDD:** cart menu item desktop + color, mobile.

## Not checked live (time or test data)

Sub menu/mobile hover colors, mobile sub menu arrow (needs a nested parent), Woo gallery zoom/slider, AJAX add to
cart, info/success/error notice colors, checkout layout, EDD archive sidebar (no download archive on pbf.local),
Hide-from-non-shop-pages switches, Premium's own options (out of scope; nothing new seen broken).

## Restore and proof

- Backup before the first save: `audit-backup.json` (21 rows: `theme_mods_*`, `wpbf%`, `cron`, logo/icon, blog
  name/description, widgets, menu options, store notice), highest post id 127372, postmeta 927.
- Afterwards: zz-test post and the 4 zz-test products + category deleted; 28 Customizer save records (ids above
  127372) and their 66 meta rows deleted; one `_edd_default_price_id` row EDD added to agency-bundle while it was
  viewed deleted; rows restored raw; temporary mu-plugin `zz-test-audit.php` deleted; CSS file deleted and rebuilt by
  one page view. Fonts folder as before (inter, open-sans, roboto, rubik; files downloaded by the runs were deleted).
- State now: posts 220 / max id 127372, postmeta 393 / max 927 (as at the start).
- After the rebuilding page view, 3 rows differ from the backup: `cron` (WordPress schedules on a page view),
  `wpbf_customizer_css_cache` and `wpbf_migrations_done`. Reason: another session bumped the theme version during the
  audit (`7e6bc282` / `7040ebc3`, style.css only, 19:58–20:03), so the page view stored the CSS and migration record
  under the new version. The rebuilt CSS file differs from `css-before.css` in form only (separate `:root` blocks, same
  values): the old file was built before the latest theme/Premium commits of the day. All theme mods and every other
  backed-up row are byte-identical to the backup.
