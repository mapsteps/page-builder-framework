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

1. **Fix what loses data or is unsafe** (small, separate fixes before any restructuring):
   - color checker keeps transparent / `var()` / 4-digit hex
   - multi-select keeps every choice when there's no limit
   - repeater checker: no more `html_entity_decode`, every sub-field type checked
   - code fields require the "unfiltered HTML" permission
   - fonts: italic weights stored correctly, no endless re-download
   - "file" CSS mode: written on save, never from the preview
   - broken paths (typography preview, React)
   - Kirki layer: missing old types, falsy defaults, the do-nothing alias file
2. **Build setup:** one config, one non-interactive `pnpm build`, unused packages and Parcel leftovers removed, vendor libraries out of `dist/`. Rebuild every control and check the output is equivalent to today's files before going on.
3. **Option schema + `wpbf_mod()`:** collect every option's default into `Schema/` (taken from today's registration and output code; where they disagree, the value visitors see today wins). Registration reads defaults from the schema. The snapshot's "defaults" run must stay identical.
4. **Lazy engine:** settings files and controls only load on `customize_register`; the font list and typography ids come from the schema. Front-end requests stop building the registry.
5. **CSS and fonts on save:** CSS generated once on save and cached (inline mode prints the cache, file mode writes the file); fonts downloaded on save. The preview generates live, once (today it prints the CSS twice).
6. **CSS rules and live preview** (see decision 2 below): build the mechanism and move the general/layout options over as the first area. The other areas move over in their own modules.
7. **Controls, one family at a time:** shared React base; slider + input-slider + responsive slider into one; checkbox/toggle and the radios into one each; generic + responsive generic one form; repeater slimmed to the sub-fields in use; React copies, unused data file and Kirki-era leftovers (core override, unused control data) removed. Load controls once as one bundle instead of ~42 files. select2 replaced last, after checking selects save exactly the same.
8. **Kirki layer and migrations:** freeze the Kirki safety net (one file, documented); the 2019–2021 migrations record "done" so they stop checking on every request.
9. **Finish:** the Customizer folder lint-clean, dead classes removed, `PREMIUM-DEPENDENCIES.md` updated (incl. removing two false entries: `enqueue`, `init`).

## Decisions for the user

1. **Old Premium (2.9 and older):** keep the safety net frozen + a clearer "update Premium" notice (recommended), or stop supporting it.
2. **How CSS is written (affects every module after this one):**
   - **A, recommended:** most options are simple ("this color → this property on these elements"). Their CSS rule moves into the option's definition in the schema. The front-end CSS and the instant live preview are both generated from it. The 141 hand-written preview bindings and most of the 2,585-line CSS file disappear. The few options with complicated CSS (several options combined) keep PHP code, and their preview asks PHP for the updated CSS (short delay).
   - **B:** keep writing CSS by hand in PHP per area, and let the preview always ask PHP for the CSS on each change. Simpler to switch to, but every change in the preview shows after a short delay, and the CSS file stays large.
3. **Minimum WordPress version:** the theme declares none today (WordPress.org requires "Requires at least"). Setting 6.6 lets us drop the bundled React copies.
