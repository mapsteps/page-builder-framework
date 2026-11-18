# What the Premium Add-On relies on in the theme

Premium is an add-on: it only runs on top of Page Builder Framework and builds directly on the theme's code. Everything below is an API, even if it looks internal. Changing it breaks Premium, often silently (no error, an option or feature just disappears).

Customers update the theme and Premium at different times, so the new theme must keep working with the Premium that's out there (2.10.5 at the start of the redo; the theme accepts Premium 2.10+, `WPBF_PREMIUM_MIN_VERSION`).

## Check

```
php bin/check-premium-deps.php
```

Checks the theme against the full list in `bin/premium-deps.json` (about 200 items). Run it after every change in the theme. It must say "All … OK". It reads the source, so it doesn't replace testing with Premium active.

## The rules

1. **Functions**: never rename or remove a theme function Premium calls (23, e.g. `wpbf_customizer_field()`, `wpbf_sidebar_layout()`, `wpbf_navigation_classes()`), or change its arguments. Adding optional arguments at the end is fine.
2. **Pluggable functions**: Premium defines 11 functions the theme also has (`wpbf_get_theme_mod_value`, `wpbf_svg`, the `wpbf_breakpoint_*` ones …). Plugins load first, so Premium's version wins, and the theme's copy must stay wrapped in `if ( ! function_exists( … ) )`. Dropping that check crashes every site running Premium.
3. **Hooks**: never rename or remove a `wpbf_` action/filter Premium uses (50), and never change what it passes or expects back. Adding new hooks is fine.
4. **Unhooked callbacks**: Premium replaces the header, pre-header, footer and 404 page by removing `wpbf_do_header`, `wpbf_do_pre_header`, `wpbf_do_footer` and `wpbf_do_404` from their hooks at priority 10. Keep hook, function name and priority exactly as they are.
5. **Customizer builder**: Premium adds about 200 options through the theme's own builder (`wpbf_customizer_field()->id()->type()->addToSection()` …). Keep the 20 builder methods it calls, the 24 control types it uses (`responsive-input-slider`, `headline-toggle`, `repeater` …) and the IDs of the 23 sections and panels it adds options to (`wpbf_menu_options`, `header_panel`, `wpbf_archive_options` …).
6. **Settings**: Premium reads 29 theme settings and shows/hides its options based on them (`menu_position`, `footer_layout`, `button_bg_color` …). Never rename a setting anyway: customers' saved values hang on the name.
7. **Classes**: `WPBF_Breadcrumbs` and its `trail()` method (Premium's breadcrumbs shortcode).
8. **Constants**: `WPBF_VERSION`, `WPBF_THEME_URI`.
9. **Scripts & styles**: Premium loads after the theme's handles (`wpbf-site`, `wpbf-responsive`, `wpbf-woocommerce-smallscreen`, `wpbf-admin-page`, `wpbf-theme-settings`, `heatbox`, `wp-color-picker-alpha`). Keep the handles.
10. **Files**: `img/page-builder-framework-logo.png`.
11. **Markup and CSS classes**: Premium styles and scripts (mega menu, sticky/transparent header, off-canvas menus, WooCommerce) work on the theme's frontend markup. The check can't see this: don't change classes or structure of the header, menus, footer or WooCommerce templates without testing with Premium active.

## Allowed in the theme

- Fixing bugs, escaping, sanitizing, capability checks, as long as everything above stays the same.
- New code, new files, new hooks.
- Code that's only used by the theme can change freely. Check `premium-deps.json` first.

## Release

`bin/`, `PREMIUM-DEPENDENCIES.md`, `composer.json`/`composer.lock`, `phpcs.xml` and dev files stay out of the theme zip.

## Notes for the Premium pass

- Premium fires some of the theme's hooks itself (`wpbf_header_open`, `wpbf_header_close`, `wpbf_customizer_links` …) in its own templates. The theme's callbacks on those hooks then run inside Premium's markup.
- `inc/customizer/controls/settings-compatibility.php` has a Kirki branch (`\Kirki::add_section`): that's how Premium shows its "update the theme" warning in themes from before the theme's own Customizer. Keep it.
