# Customizer rebuild plan

Goal: rebuild the Customizer engine and its controls once, properly, so it never needs another pass. Based on a full read of the engine core, all controls and the Kirki layer (November 18, 2026); every point below was checked in the code.

## Where it stands

The engine (written December 2023) copies Kirki's way of building options and ports Kirki's controls. It works, but:

1. **Defaults have no home.** An option's default lives in up to 6 places: the registration, the label text ("Default: 1200px"), the CSS code (36 "is it the default?" checks with hard-coded values), the live-preview script, the Gutenberg/WooCommerce/EDD styles and helpers. Some already disagree; some checks can never match (number vs. text).
2. **Everything runs on every page view.** All ~460 options (theme + Premium) are built on every request, including visitor page views, AJAX and cron. That includes loading the 280 KB Google font list. All CSS (a 2,585-line file) is generated per page view.
3. **Google Fonts download during visitor page views.** Every italic weight except plain italic never gets stored, so it's downloaded from Google again on every page view. Failed downloads retry forever.
4. **"File" CSS mode** rebuilds the file on every request and can publish unsaved preview changes to all visitors.
5. **Every CSS rule is written twice:** once in PHP, once in the live-preview script (141 hand-written bindings), with fixed breakpoints that ignore Premium's custom ones.
6. **Settings checks that lose data or let things through:**
   - transparent colors (`rgba(…,0)`, `transparent`, `var()`) are wiped on save
   - multi-selects without a limit drop their last item
   - repeater text fields can be turned back into `<script>`, some repeater fields aren't checked at all
   - code fields (Premium's header/footer scripts) accept scripts from admins who aren't allowed to add them (multisite)
7. **Controls:**
   - the build can't be reproduced: scripts and config are missing, the files were built by two different tools
   - all ~42 control files load on every Customizer open
   - three slider controls are ~90% the same code
   - a broken preview file (404 on every preview)
   - bundled React copies that WordPress already provides
   - an outdated select library (select2 release candidate from 2021)
   - an unused 780 KB file
8. **Kirki layer:**
   - needed: Premium 2.9 and older call Kirki directly, and one call isn't guarded, so removing it crashes sites with old Premium + EDD
   - buggy: two old option types are silently dropped, defaults like 0/false get lost, and one file (class aliases) does nothing useful but builds ~37 throw-away fields per request
   - the 2019–2021 setting migrations run their checks on every request

## Principles (the "never again" part)

1. **One home per thing.** Every option has exactly one definition: id, type, default, stored format. Registration, front-end reading, CSS output and the live preview all take it from there. No default is ever typed twice.
2. **One reader.** `wpbf_mod( 'id' )` returns the saved value or the default, already decoded (JSON values, units) and typed. Output code never decodes or compares against hand-typed defaults again.
3. **Work happens when settings change, not when visitors load pages.** CSS and font files are built on save and cached. Visitors only get the finished result.
4. **The Customizer engine only runs in the Customizer.** Front-end requests never build controls, sections or font lists.
5. **One checker per value type**, strict but never destroying valid values (no more wiped transparent colors).
6. **One build, one command, reproducible.** `pnpm build` builds every control; the result is the same on any machine.
7. **Nothing breaks for existing sites.** Option names, stored value formats, control type names, Premium's whole builder API and hooks stay. Checked by the Premium check and the snapshot at every step.

## Target structure

```
Customizer/
  Schema/        option definitions: id, type, default, stored format (one entry per option; theme options by area: general, header, blog, …)
  Builder/       wpbf_customizer_field/section/panel(): only record what's declared (cheap, safe to call early, as Premium does)
  Registry/      turns the records into WordPress Customizer objects, only on customize_register
  Sanitize/      one checker per value type (color, number, unit, select, repeater, code, …)
  Output/        CSS: generated on save, cached; live in the preview only. Fonts: downloaded on save, cached
  Controls/      the controls, merged by family, one shared React base
  Compatibility/ Kirki safety net (frozen)
  src/ + dist/   one build for all controls (vendor libraries kept apart from dist)
```

The option *definitions* for the header, blog, footer and so on move into `Schema/` during this module, without changing any value. The *CSS* for each area gets moved over in that area's own module later (see decision 2); until then it stays where it is, reading through `wpbf_mod()`.

## What must not change

- Builder functions and method names Premium uses (`id`, `type`, `label`, `description`, `priority`, `defaultValue`, `transport`, `choices`, `properties`, `tab`, `tabs`, `tooltip`, `activeCallback`, `partialRefresh`, `addToSection`, `addToPanel`, `add`, `title`), their argument formats, the 24 control type names and the `expanded` section type
- Section and panel ids, option names, stored formats (incl. `save_as_json` options that store text instead of arrays: they keep doing that)
- Hooks: `wpbf_css_output`, `wpbf_add_inline_style`, `wpbf_before_customizer_css`, `wpbf_after_customizer_css`, `wpbf_kirki_font_choices`, `kirki_color_swatches`, and the pluggable `wpbf_kirki_sanitize_helper`
- The fake Kirki class for old Premium (frozen: kept working, not improved)
- The type names of currently unused controls (`checkbox`, `radio`, `margin`, `upload` …), since child themes may use them through the Kirki layer; their code gets merged into the shared controls

## Steps

Each step is one or more commits on the `redo` branch. After every step: snapshot before/after, lint, Premium check, and for control changes a real check in the Customizer (open, change, save, reload).

Checks for every step: `python bin/snapshot/snapshot.py take/diff` (pages), `node bin/snapshot/customizer-check.mjs` (Customizer opens, every control renders, no JS errors or failed requests), `php bin/check-premium-deps.php`, `bin/check-schema.php` (from step 3 on), lint.

1. **Fix what loses data or is unsafe** (small, separate fixes before any restructuring). **Done November 18, 2026** (5 commits). Left for later steps: the select control's markup typos (TS, needs the build from step 2), font download retries/back-off and the empty font style tag (step 5), file-mode CSS regenerating on every request (step 5).
   - color checker keeps transparent / `var()` / 4-digit hex
   - multi-select keeps every choice when there's no limit
   - repeater checker: no more `html_entity_decode`, every sub-field type checked
   - code fields require the "unfiltered HTML" permission
   - fonts: italic weights stored correctly, no endless re-download
   - "file" CSS mode: written on save, never from the preview
   - broken paths (typography preview, React)
   - Kirki layer: missing old types, falsy defaults, the do-nothing alias file
2. **Done November 18, 2026.** Notes for later steps: `color-preview` and `margin-padding-preview` hook into a filter nothing applies (dead, drop in step 7); `tsc --noEmit` reports 13 type errors in the control sources (fix in step 7); `wpbf.mjs` still builds the theme's own assets and zip until the assets module.
   **Build setup:** one config, one non-interactive `pnpm build`, unused packages and Parcel leftovers removed, vendor libraries out of `dist/`. Rebuild every control and check the output is equivalent to today's files before going on.
3. **Option schema + `wpbf_mod()`:** collect every option's default into `Schema/` (taken from today's registration and output code; where they disagree, the value visitors see today wins). Registration reads defaults from the schema. The snapshot's "defaults" run must stay identical. **Done November 18, 2026.**
   - **How it works:** `Customizer/Schema/<area>.php` (general, typography, blog, header, footer, woocommerce, edd) hold 276 entries: `type`, `default` (a closure for translated or site-dependent text), `'json' => true` for options saved as JSON text. `{archive}_…` / `{single}_…` entries cover every id of the `wpbf_archives` / `wpbf_singles` filters. Only options that store a value are listed; separators, headlines and notes stay in the settings files. `OptionSchema` (same folder) loads them lazily. `wpbf_customizer_field()->id()` takes type, default and `save_as_json` from the schema; anything called after `id()` still overrides, so the documented way of adding fields (own `type()` + `defaultValue()`, Premium, child themes, Kirki layer) is unchanged. The theme's settings files no longer contain `type()`, `defaultValue()` or `save_as_json`. Fields outside the schema are recorded when they're added, so `wpbf_mod()` knows their declared default too.
   - **`wpbf_mod( 'id' )`:** saved value or default; JSON options as arrays, toggles as true/false (same truthiness as before), sliders/numbers as int or float; goes through `get_theme_mod()`, so the Customizer preview works. 62 output reads whose hard-coded fallback equalled the schema default already read through it (output identical). Reads with "is default" checks or `json_decode` move with their area's CSS (decision 2); `inc/backwards-compatibility.php` runs before `wpbf_mod()` exists and stays as is (step 8).
   - **Check:** `php -d extension=mysqli -d mysqli.default_port=10035 bin/check-schema.php` (schema matches what's registered, label "Default:" texts, fields with their own type/default keep them, `wpbf_mod()` typing). Add it to the checks of every later step. `snapshot.py` takes the theme's option types from the schema now.
   - **Disagreements resolved** (schema = what visitors see; the Customizer now shows it): Page Width empty → `1200px`; logo alt/title empty → the site name; post footer parts Read More + Categories → Categories; WooCommerce sale badge / out-of-stock text color `#fff` → `#ffffff` (same color, now matches the "is default" check); footer column texts translated → untranslated (that's what the footer prints; same on English sites, translating them is a possible later change); JSON options with an empty default `''` → empty list (no visible change).
   - **Kept on purpose:** pre header, navigation, footer, WooCommerce and archive/post custom widths stay empty although labels say "Default: 1200px": empty means "same as the page width / the Archives setting". The output code's `=== '1200px'` checks for them drop an explicitly chosen 1200px when the page width differs; fix when that CSS moves (step 6 and the area modules).
   - **For step 6:** 13 "is default" checks compare text to a number and never match, so their CSS prints at the default too (harmless): `page_boxed_padding`, `{archive}_post_space_between`, `{archive}_post_image_width`, `pre_header_height`, `menu_logo_container_width`, `mobile_menu_logo_container_width`, `menu_height`, `menu_padding`, `sub_menu_width`, `mobile_menu_height`, `footer_height`, `woocommerce_single_image_width`, `woocommerce_loop_image_width`. With nothing saved the preview differs from the live site in three places (preview uses registered defaults, live prints nothing): page padding on phones (40px vs 20px top/bottom), mobile logo area width (66% vs 66.666%), and the `theme-color` meta tag (printed only in the preview). "Only print when set and different from the default" fixes all three.
   - **For the area modules:** output code reads options nobody registers (dead): `blog_pagination_background_color_next_prev`, `page_background_*` (6), `mobile_sub_menu_border_color`, `mobile_menu_padding_left`, `menu_custom`, `{single}_post_content_alignment`, `edd_menu_item_icon`. LifterLMS's 3 options are switched off (settings file not loaded) and `lifterlms-styles-backup.php` is unused. The Gutenberg editor styles read Premium's typography options with their own hard-coded fallbacks (Premium pass).
4. **Lazy engine:** settings files and controls only load on `customize_register`; the font list and typography ids come from the schema. Front-end requests stop building the registry. **Done November 18, 2026.**
   - **How it works:** `wpbf_customizer_field()` / `section()` / `panel()` return recorders (`CustomizerField`, `CustomizerSection`, `CustomizerPanel`: same methods and arguments) that only note each call. The finished declaration goes to `Registry\Registry`, which replays it on a `FieldRegistrar` / `SectionRegistrar` / `PanelRegistrar` (the former builder code) on `customize_register` priority 1, in declaration order; after that, calls build right away. The theme's settings files (and the WooCommerce/EDD ones) are added as jobs at the point they used to load, so the Customizer is built in exactly the old order: same settings, controls, sections, panels, tabs, dependencies and partials, in the same order, with and without Premium (compared by dump). Premium's calls on `after_setup_theme` stay cheap: a list of calls per field. `settings-helpers.php` (the pluggable sanitize helper, font choices) still loads on every request. Hook order matters: the tooltip/typography script data (`register_tooltips`, `js_vars_for_controls`) must hook in after the typography fields register their scripts, so Customizer::init() adds them through a registry job right after the theme's settings (the Customizer check caught a missing `wpbfTypographyControlIds` when they were hooked first).
   - **Who read the registry outside the Customizer:** only the front-end Google Fonts output (typography ids via `TypographyStore` + `CustomizerStore`, font list via the typography field). It now takes typography ids from the schema plus the fields others declared (`OptionSchema::ofType()`), and only loads the Google font list when a chosen family has no downloaded CSS and isn't a font stack. `wpbf_mod()` gets Premium's/child themes' defaults from the declaration (recorded when declared). Nothing in Premium or the child theme reads the registry.
   - **Measured** (pbf.local, Premium on, median of 15): front-end page view 222 → 207 ms and 22.3 → 12.0 MB peak memory; AJAX 186 → 174 ms, 22.2 → 12.0 MB; REST 191 → 175 ms, 24.4 → 14.1 MB. Built per front-end request: 569 settings, 569 controls, 42 sections, 7 panels and the 1,835-font list before; none after (9 light Customizer classes load: recorders, schema, registry, font output). Premium's own settings files still load on every request (its code).
   - CLI tools that need the registry call `Registry::build()` (as `bin/check-schema.php` does).
5. **CSS and fonts on save:** CSS generated once on save and cached (inline mode prints the cache, file mode writes the file); fonts downloaded on save. The preview generates live, once (today it prints the CSS twice). **Done November 18, 2026.**
   - **How it works** (`Customizer/Output/CustomizerCss.php`): the option `wpbf_customizer_css_cache` (autoloaded, it's needed on every page) holds the Customizer CSS and the Google Fonts CSS per fingerprint (the 2 newest). The fingerprint is an md5 of everything the CSS depends on (0.08 ms, no CSS built): theme mods, Premium's `wpbf_settings` (breakpoints, color palette, blog layouts, CSS file mode), theme + Premium versions, parent/child theme, the child theme's `functions.php` time, active plugins, site URL and http/https (Premium's custom font URLs follow the scheme). Extensible with the `wpbf_customizer_css_key_parts` filter; `wpbf_cache_customizer_css` → false builds per request as before. Saves (`customize_save_after`, `wpbf_settings` changes, theme switch, updates, plugin (de)activation) schedule a refresh on WordPress cron; it builds the CSS, downloads missing fonts and writes the file in "file" mode. A Customizer save request can't build it itself: WordPress previews every setting at its registered default there, which isn't what visitors get. A fingerprint without an entry (a change no hook saw, e.g. an import) is built once by that request, without downloads, which schedules the cron refresh for missing fonts. Clearing the downloaded fonts drops the cache.
   - **Fonts:** downloads happen only on cron (and in the Customizer preview, as before). A failed font is retried after 1 hour, then 4×longer each time up to a week (`wpbf_google_fonts_failed`), via a scheduled refresh. The `<style class="wpbf-google-fonts">` tag is left out when empty (the only page difference in the snapshot).
   - **Preview:** the CSS is printed once (`wpbf-customize-saved-styles`, live); neither the cache nor the file is used or written there.
   - **Request-dependence check:** none of the CSS callbacks (theme, Premium, WooCommerce/EDD/LifterLMS, Elementor fix) look at the current page, user or request; the handle from `wpbf_add_inline_style` is still asked per request. `wpbf_css_output`, `wpbf_add_inline_style`, `wpbf_before/after_customizer_css` work as before; `wpbf_generate_css()` and `wpbf_create_customizer_css_file()` still exist (the latter isn't hooked to every request any more).
   - **Tested on pbf.local** (everything backed up and restored exactly): Customizer save hook → cron built the CSS and wrote the file, 3 visits afterwards didn't rebuild; Premium breakpoint 768 → 800 came through the same way; a change without a hook was built once by the first visit; with Google blocked, one download try on cron, none by visitors, retries after 1 h then 4 h, and the font arrived once unblocked; clearing fonts rebuilt an identical entry. `bin/snapshot` runs read the cache but never write it (`wpbf_customizer_css_store` filter in its mu-plugin).
   - **Measured** (Premium on = file mode, median of 15): page view 214 → 200 ms (home), 242 → 219 ms (post); AJAX 177 → 168 ms, REST 178 → 171 ms (file mode rebuilt the CSS on every request, AJAX and REST included). Building the CSS takes ~15 ms; that now happens once per change.
   - **Later:** the CSS of the preview is still the full stylesheet built on every preview load (step 6 replaces most of it with the schema's rules).
6. **CSS rules and live preview** (see decision 2 below): build the mechanism and move the general/layout options over as the first area. The other areas move over in their own modules.
7. **Controls, one family at a time:** shared React base; slider + input-slider + responsive slider into one; checkbox/toggle and the radios into one each; generic + responsive generic one form; repeater slimmed to the sub-fields in use; React copies, unused data file and Kirki-era leftovers (core override, unused control data) removed. Load controls once as one bundle instead of ~42 files. select2 replaced last, after checking selects save exactly the same.
8. **Kirki layer and migrations:** freeze the Kirki safety net (one file, documented); the 2019–2021 migrations record "done" so they stop checking on every request.
9. **Finish:** the Customizer folder lint-clean, dead classes removed, `PREMIUM-DEPENDENCIES.md` updated (incl. removing two false entries: `enqueue`, `init`).

## Decisions for the user

1. **Old Premium (2.9 and older): decided (November 18, 2026):** keep the safety net frozen + a clearer "update Premium" notice. Blocking it isn't possible cleanly (plugins load before the theme), would take features off live sites of customers who can't renew, and a theme switching off plugins wouldn't pass WordPress.org review. Compatibility is promised for Premium 2.10+ only; older versions just must not crash.
2. **How CSS is written (affects every module after this one): decided A (November 18, 2026).** Keeps the old styles.php rule: CSS is only printed when an option is set and differs from its default (that check now comes from the schema's one default). Rules that depend on several options stay hand-written PHP.
   - **A, chosen:** most options are simple ("this color → this property on these elements"). Their CSS rule moves into the option's definition in the schema. The front-end CSS and the instant live preview are both generated from it. The 141 hand-written preview bindings and most of the 2,585-line CSS file disappear. The few options with complicated CSS (several options combined) keep PHP code, and their preview asks PHP for the updated CSS (short delay).
   - **B:** keep writing CSS by hand in PHP per area, and let the preview always ask PHP for the CSS on each change. Simpler to switch to, but every change in the preview shows after a short delay, and the CSS file stays large.
3. **Minimum WordPress version: decided 6.6 (November 18, 2026).** Lets us use WordPress' own React (bundled copies removed in step 1).
