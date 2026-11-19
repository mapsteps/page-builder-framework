"""Output snapshot of the theme on pbf.local (dev only, never shipped).

Renders a fixed set of frontend and admin pages under several Customizer setting combinations,
with the Premium Add-On on and off, and saves the HTML (noise like nonces removed) plus any new
PHP warnings. Take one before a change and one after, then compare.

    python bin/snapshot/snapshot.py take before
    python bin/snapshot/snapshot.py take after
    python bin/snapshot/snapshot.py diff before after

`take <name> edd1,edd2` renders only those variants (e.g. new hand-made variants with the old code).

Nothing is written to the database: settings are swapped per request by a temporary mu-plugin
(copied in for the run, deleted afterwards). Output lives in bin/snapshot/output/ (gitignored).
variants.json there is generated once from the theme's and Premium's settings; delete it to rebuild.
"""
import os, re, sys, json, time, shutil, subprocess, difflib, urllib.request, urllib.error
from concurrent.futures import ThreadPoolExecutor

HERE = os.path.dirname(os.path.abspath(__file__))
THEME = os.path.normpath(os.path.join(HERE, '..', '..'))
CONTENT = os.path.normpath(os.path.join(THEME, '..', '..'))
WP_ROOT = os.path.dirname(CONTENT)
PREMIUM = os.path.join(CONTENT, 'plugins', 'wpbf-premium')
OUT = os.path.join(HERE, 'output')
MU = os.path.join(CONTENT, 'mu-plugins', 'zz-test-snapshot.php')
LOG = os.path.normpath(os.path.join(WP_ROOT, '..', '..', 'logs', 'php', 'error.log'))
PHP = ['php', '-d', 'extension=mysqli', '-d', 'mysqli.default_port=10035']  # pbf.local's MySQL port (Local).

BASE = 'http://pbf.local'
FRONT = ['/', '/related-posts/', '/checkout/', '/category/blog/', '/category/blog/page/2/', '/author/davidv/',
         '/?s=page', '/?s=zzznothing', '/zz-test-404-not-found/', '/?p=366', '/?p=202', '/?post_type=download',
         '/?m=2020'] + [
    # WooCommerce (shop, a product on sale, cart, checkout (redirects to the empty cart), account, a category), with
    # zz-test products: create them with zz-test-products.php before a run (they 404 otherwise), delete them afterwards.
    '/shop/', '/product/zz-test-sale/', '/cart/', '/checkout-2/', '/my-account/', '/product-category/zz-test-category/']
WOO_FRONT = FRONT[-6:]
ADMIN = ['/wp-admin/themes.php?page=wpbf-premium', '/wp-admin/edit.php', '/wp-admin/edit.php?post_type=page',
         '/wp-admin/customize.php', '/wp-admin/post.php?post=366&action=edit', '/wp-admin/index.php']
VARIANTS = ['live', 'defaults', 'synthetic0', 'synthetic1', 'synthetic2', 'synthetic3', 'general1', 'general2', 'general3',
            'general4', 'footer1', 'footer2', 'footer3', 'footer4', 'footer5', 'edd1', 'edd2', 'edd3', 'edd4', 'edd5',
            'typography1', 'typography2', 'typography3', 'typography4', 'blog1', 'blog2', 'blog3', 'blog4', 'blog5',
            'woocommerce1', 'woocommerce2', 'woocommerce3', 'woocommerce4', 'woocommerce5', 'woocommerce6',
            'header1', 'header2', 'header3', 'header4', 'header5', 'header6', 'header7', 'header8',
            'premium-general1', 'premium-general2', 'premium-general3', 'premium-typography1', 'premium-typography2',
            'premium-typography3']
ADMIN_VARIANTS = ('live', 'synthetic0', 'synthetic1')

# Hand-made variants for the General area, saved the way the Customizer saves them (sliders as text, padding as JSON
# text with numbers and false for empty sides). '__wpbf_settings' swaps in Premium's breakpoints.
PAD = lambda **k: json.dumps(k, separators=(',', ':'))
# A typography value as the Customizer saves it (variant, plus the weight and style composed from it).
TYPO = lambda family, variant: {'font-family': family, 'variant': variant,
                                'font-weight': '400' if variant in ('regular', 'italic') else variant.replace('italic', ''),
                                'font-style': 'italic' if 'italic' in variant else 'normal'}
HAND_VARIANTS = {
    # Everything changed, boxed layout with shadow, custom breakpoints.
    'general1': {
        '__wpbf_settings': {'wpbf_breakpoint_desktop': '1100px', 'wpbf_breakpoint_medium': '700px', 'wpbf_breakpoint_mobile': '400px'},
        'page_max_width': '1100px',
        'page_padding': PAD(desktop_top=30, desktop_right=25, desktop_bottom=30, desktop_left=25, tablet_top=False, tablet_right=15,
                            tablet_bottom=False, tablet_left=15, mobile_top=10, mobile_right=False, mobile_bottom=10, mobile_left=False),
        'page_boxed': True, 'page_boxed_margin': '30', 'page_boxed_padding': '0', 'page_boxed_background': '#eeeeee',
        'page_boxed_box_shadow': True, 'page_boxed_box_shadow_blur': '0', 'page_boxed_box_shadow_spread': '2',
        'page_boxed_box_shadow_horizontal': '3', 'page_boxed_box_shadow_vertical': '4', 'page_boxed_box_shadow_color': 'rgba(1,2,3,0.4)',
        'sidebar_width': '30', 'sidebar_bg_color': '#eaeaea',
        'sidebar_widget_padding': PAD(desktop_top=20, desktop_right=30, desktop_bottom='20', desktop_left=False, tablet_top=12,
                                      mobile_bottom=8),
        'breadcrumbs_alignment': 'center', 'breadcrumbs_background_color': '#cccccc', 'breadcrumbs_font_color': '#111111',
        'breadcrumbs_accent_color': '#222222', 'breadcrumbs_accent_color_alt': '#333333',
        'page_accent_color': '#ff6600', 'page_accent_color_alt': 'rgba(255,102,0,0.7)',
        'button_bg_color': '#010101', 'button_bg_color_alt': '#020202', 'button_text_color': '#030303', 'button_text_color_alt': '#040404',
        'button_primary_bg_color': '#050505', 'button_primary_bg_color_alt': '#060606', 'button_primary_text_color': '#070707',
        'button_primary_text_color_alt': '#080808', 'button_border_radius': '5', 'button_border_width': '2',
        'button_border_color': '#090909', 'button_border_color_alt': '#0a0a0a', 'button_primary_border_color': '#0b0b0b',
        'button_primary_border_color_alt': '#0c0c0c',
        'layout_scrolltop': True, 'scrolltop_position': 'left', 'scrolltop_bg_color': 'rgba(1,1,1,0.5)',
        'scrolltop_bg_color_alt': 'rgba(2,2,2,0.5)', 'scrolltop_icon_color': '#000000', 'scrolltop_icon_color_alt': '#ff0000',
        'scrolltop_border_radius': '50',
    },
    # Everything saved, but equal to the defaults.
    'general2': {
        'page_max_width': '1200px',
        'page_padding': PAD(desktop_top=40, desktop_right=20, desktop_bottom=40, desktop_left=20, tablet_top=False, tablet_right=False,
                            tablet_bottom=False, tablet_left=False, mobile_top=False, mobile_right=False, mobile_bottom=False,
                            mobile_left=False),
        'page_boxed': True, 'page_boxed_margin': '0', 'page_boxed_padding': '20', 'page_boxed_background': '#ffffff',
        'page_boxed_box_shadow': True, 'page_boxed_box_shadow_blur': '25', 'page_boxed_box_shadow_spread': '0',
        'page_boxed_box_shadow_horizontal': '0', 'page_boxed_box_shadow_vertical': '0', 'page_boxed_box_shadow_color': 'rgba(0,0,0,.15)',
        'sidebar_width': '33.3', 'sidebar_bg_color': '#f5f5f7',
        'sidebar_widget_padding': PAD(**{d + '_' + s: 20 for d in ('desktop', 'tablet', 'mobile') for s in ('top', 'right', 'bottom', 'left')}),
        'breadcrumbs_alignment': 'left', 'breadcrumbs_background_color': '#dedee5',
        'page_accent_color': '#3ba9d2', 'page_accent_color_alt': '#79c4e0',
        'button_border_radius': '0', 'button_border_width': '0',
        'layout_scrolltop': True, 'scrolltop_position': 'right', 'scrolltop_bg_color': 'rgba(62,67,73,0.5)',
        'scrolltop_bg_color_alt': 'rgba(62,67,73,0.7)', 'scrolltop_icon_color': '#ffffff', 'scrolltop_border_radius': '0',
    },
    # Odd saved values: numbers instead of text, empty values, single sides, options whose switch is off.
    'general3': {
        'page_max_width': '', 'page_padding': PAD(tablet_top=12, tablet_bottom=12),
        'page_boxed': True, 'page_boxed_margin': '', 'page_boxed_padding': 0, 'page_boxed_box_shadow': False,
        'page_boxed_box_shadow_color': 'rgba(9,9,9,0.9)',
        'sidebar_width': 33.3, 'sidebar_widget_padding': PAD(desktop_top='20', desktop_right=20, mobile_left='5'),
        'breadcrumbs_alignment': 'right', 'page_accent_color': '', 'page_accent_color_alt': '#79c4e0',
        'button_border_width': '0', 'button_border_color': '#111111', 'button_primary_border_color': '#222222',
        'button_text_color': '#333333', 'button_primary_text_color_alt': '#444444',
        'layout_scrolltop': False, 'scrolltop_position': 'left', 'scrolltop_bg_color': '#555555', 'scrolltop_border_radius': '9',
    },
    # Boxed off with boxed options set, scroll to top on with a few colors, a custom width saved as text.
    'general4': {
        'page_max_width': '90%', 'page_boxed': False, 'page_boxed_padding': '40', 'page_boxed_margin': '20',
        'page_boxed_box_shadow': True, 'page_boxed_box_shadow_blur': '10',
        'page_padding': PAD(desktop_top='0', desktop_right='0', desktop_bottom='0', desktop_left='0'),
        'sidebar_width': '25.5', 'button_border_radius': '3', 'button_primary_bg_color': '#123456',
        'button_primary_bg_color_alt': '#654321',
        'layout_scrolltop': True, 'scrolltop_position': 'left', 'scrolltop_icon_color_alt': '#abcdef',
        'scrolltop_bg_color_alt': 'rgba(62,67,73,0.7)', 'scrolltop_icon_color': '#FFFFFF',
    },
    # Footer: everything changed.
    'footer1': {
        'footer_layout': 'one', 'footer_width': '1000px', 'footer_height': '35', 'footer_bg_color': '#222222',
        'footer_font_color': '#eeeeee', 'footer_accent_color': '#ff0000', 'footer_accent_color_alt': 'rgba(1,2,3,0.5)',
        'footer_font_size': '16px',
    },
    # Footer: everything saved, but equal to the defaults.
    'footer2': {
        'footer_layout': 'two', 'footer_width': '', 'footer_height': '20', 'footer_bg_color': '#f5f5f7',
        'footer_font_color': '', 'footer_accent_color': '', 'footer_accent_color_alt': '', 'footer_font_size': '14px',
    },
    # Footer: odd saved values: numbers instead of text, capitals, 1200px with another page width.
    'footer3': {
        'page_max_width': '1100px', 'footer_width': '1200px', 'footer_height': 20, 'footer_bg_color': '#F5F5F7',
        'footer_font_color': '#FFFFFF', 'footer_accent_color_alt': '#ABCDEF', 'footer_font_size': 15,
    },
    # Footer: zeros the controls can't produce, empty values.
    'footer4': {
        'footer_width': '0', 'footer_height': '0', 'footer_font_size': '0', 'footer_accent_color': '0', 'footer_bg_color': '',
        'footer_font_color': '#123456',
    },
    # Footer: no footer, with options set.
    'footer5': {
        'footer_layout': 'none', 'footer_width': '1000px', 'footer_height': '35', 'footer_bg_color': '#222222',
        'footer_font_color': '#eeeeee', 'footer_accent_color': '#ff0000', 'footer_accent_color_alt': '#00ff00',
        'footer_font_size': '16px',
    },
    # EDD: everything changed (accent, theme buttons, menu item colors).
    'edd1': {
        'page_accent_color': '#ff6600',
        'button_bg_color': '#010101', 'button_bg_color_alt': '#020202', 'button_text_color': '#030303', 'button_text_color_alt': '#040404',
        'button_primary_bg_color': '#050505', 'button_primary_bg_color_alt': '#060606', 'button_primary_text_color': '#070707',
        'button_primary_text_color_alt': '#080808', 'button_border_radius': '5', 'button_border_width': '2',
        'button_border_color': '#090909', 'button_border_color_alt': '#0a0a0a', 'button_primary_border_color': '#0b0b0b',
        'button_primary_border_color_alt': '#0c0c0c',
        'menu_font_color': '#111111', 'mobile_menu_font_color': '#222222',
        'edd_menu_item_desktop_color': '#aa0000', 'edd_menu_item_mobile_color': '#00aa00',
    },
    # EDD: everything saved, but equal to the defaults.
    'edd2': {
        'page_accent_color': '#3ba9d2', 'button_border_radius': '0', 'button_border_width': '0', 'button_bg_color': '',
        'button_text_color': '', 'edd_menu_item_desktop': 'show', 'edd_menu_item_mobile': 'show',
        'edd_menu_item_desktop_color': '', 'edd_menu_item_mobile_color': '', 'menu_font_color': '', 'mobile_menu_font_color': '',
    },
    # EDD: odd values: accent in capitals, numbers, border colors without a border width, desktop item hidden (mobile
    # falls back to the desktop color), menu item colors from the menu font colors.
    'edd3': {
        'page_accent_color': '#3BA9D2', 'button_border_radius': 7, 'button_border_width': '0', 'button_border_color': '#111111',
        'button_primary_border_color_alt': '#222222', 'button_bg_color_alt': '#333333', 'button_primary_text_color': '#444444',
        'edd_menu_item_desktop': 'hide', 'edd_menu_item_desktop_color': '#555555', 'menu_font_color': '#666666',
    },
    # EDD: zeros and empty values the controls can't produce.
    'edd4': {
        'page_accent_color': '0', 'button_border_width': '0', 'button_border_radius': '0', 'button_bg_color': '0',
        'button_text_color': '0', 'button_primary_bg_color_alt': '0', 'edd_menu_item_desktop_color': '0',
        'edd_menu_item_mobile_color': '0', 'menu_font_color': '0', 'mobile_menu_font_color': '#777777',
    },
    # EDD: fallbacks: desktop item from the accent color, mobile item hidden, a border width with some colors.
    'edd5': {
        'page_accent_color': '#ff0066', 'edd_menu_item_mobile': 'hide', 'edd_menu_item_mobile_color': '#888888',
        'mobile_menu_font_color': '#999999', 'button_border_width': 3, 'button_border_color_alt': '#abcdef',
        'button_primary_border_color': '#fedcba', 'button_primary_bg_color': '#123123',
    },
    # Typography: everything changed, as the Customizer saves it (family, variant, weight, style). Google fonts that
    # pbf.local has downloaded (Inter, Rubik, Open Sans, Roboto), font stacks with quotes, Premium's custom font, italics.
    'typography1': {
        'page_font_toggle': True, 'page_font_family': TYPO('Inter', '600'), 'page_font_color': '#112233',
        'menu_font_family_toggle': True, 'menu_font_family': TYPO('Rubik', 'regular'),
        'sub_menu_font_family_toggle': True, 'sub_menu_font_family': TYPO('Georgia, serif', 'italic'),
        'page_h1_toggle': True, 'page_h1_font_family': TYPO('Open Sans', '700'),
        'page_h2_toggle': True, 'page_h2_font_family': TYPO('"Times New Roman", Times, serif', '700italic'),
        'page_h3_toggle': True, 'page_h3_font_family': TYPO("'Helvetica Neue', Arial, sans-serif", '300'),
        'page_h4_toggle': True, 'page_h4_font_family': TYPO('Roboto', '700'),
        'page_h5_toggle': True, 'page_h5_font_family': TYPO('kitten, sans-serif', 'regular'),
        'page_h6_toggle': True, 'page_h6_font_family': TYPO('Inter', 'regular'),
        'footer_font_toggle': True, 'footer_font_family': TYPO('Rubik', '700'),
    },
    # Typography: everything switched on and saved, but equal to the defaults (the old code prints the fonts anyway).
    'typography2': {
        'page_font_toggle': True, 'page_font_family': {'font-family': 'Helvetica, Arial, sans-serif', 'variant': 'regular'},
        'page_font_color': '#6d7680',
        'menu_font_family_toggle': True, 'menu_font_family': {'font-family': 'Helvetica, Arial, sans-serif', 'variant': 'regular'},
        'sub_menu_font_family_toggle': True, 'sub_menu_font_family': {'font-family': 'Helvetica, Arial, sans-serif', 'variant': 'regular'},
        **{'page_h%d_toggle' % n: True for n in range(1, 7)},
        **{'page_h%d_font_family' % n: {'font-family': 'Helvetica, Arial, sans-serif', 'variant': '700'} for n in range(1, 7)},
        'footer_font_toggle': True, 'footer_font_family': {'font-family': 'Helvetica, Arial, sans-serif', 'variant': 'regular'},
    },
    # Typography: odd saved values: missing parts, extra parts (older sites, Premium), variant as a number, empty parts,
    # a switch off with a font set, a color in capitals, a font stack saved with HTML entities.
    'typography3': {
        'page_font_toggle': True, 'page_font_family': {'font-family': 'Inter'}, 'page_font_color': '#6D7680',
        'menu_font_family_toggle': True, 'menu_font_family': {'variant': '600'},
        'sub_menu_font_family_toggle': True,
        'sub_menu_font_family': {'font-family': 'Rubik', 'variant': '700', 'font-size': '20px', 'color': '#ff0000',
                                 'text-transform': 'uppercase', 'subsets': ['latin-ext'], 'downloadFont': '1'},
        'page_h1_toggle': True, 'page_h1_font_family': {'font-family': 'Inter', 'variant': 400},
        'page_h2_toggle': True, 'page_h2_font_family': {'font-family': '', 'variant': ''},
        'page_h3_toggle': True, 'page_h3_font_family': {'font-family': 'Helvetica, Arial, sans-serif', 'variant': '700'},
        'page_h4_toggle': False, 'page_h4_font_family': TYPO('Roboto', '700'),
        'page_h5_toggle': True, 'page_h5_font_family': {'font-family': '&quot;Times New Roman&quot;, serif', 'variant': 'italic'},
        'page_h6_toggle': True, 'page_h6_font_family': {'font-family': ' Georgia, serif ', 'variant': '900italic', 'font-style': 'normal'},
        'footer_font_toggle': True, 'footer_font_family': {'font-family': 'Georgia, serif', 'variant': '300italic'},
    },
    # Typography: values no control produces: '0' as a color, switches on with nothing saved, a font saved as text,
    # an empty font, switches saved as '1' / 0.
    'typography4': {
        'page_font_toggle': '1', 'page_font_color': '0',
        'menu_font_family_toggle': True,
        'sub_menu_font_family_toggle': True, 'sub_menu_font_family': '{"font-family":"Inter","variant":"700"}',
        'page_h1_toggle': True, 'page_h1_font_family': {},
        'page_h2_toggle': 0, 'page_h2_font_family': TYPO('Inter', '700'),
        'footer_font_toggle': '1', 'footer_font_family': TYPO('Inter', '600'),
    },
    # Blog: everything changed: pagination, the archives pbf.local has (all archives, search, the docs post type's
    # archive) and the post. Premium's blog/post layouts add the blog page and the docs post type (page snapshots only:
    # the preview check sets the settings that exist on pbf.local).
    'blog1': {
        '__wpbf_settings': {'wpbf_blog_layouts': ['blog', 'search', 'docs-archive'], 'wpbf_post_layouts': ['docs']},
        'blog_pagination_background_color': '#111111', 'blog_pagination_background_color_alt': '#222222',
        'blog_pagination_background_color_active': '#333333', 'blog_pagination_font_color': '#444444',
        'blog_pagination_font_color_alt': '#555555', 'blog_pagination_font_color_active': '#666666',
        'blog_pagination_border_radius': '4', 'blog_pagination_font_size': '15px',
        'archive_custom_width': '900px', 'archive_layout': 'default', 'archive_post_style': 'boxed',
        'archive_boxed_image_streched': True,
        'archive_boxed_padding': PAD(desktop_top=30, desktop_right=25, desktop_bottom=30, desktop_left=25, tablet_top=20, tablet_right=15,
                                     tablet_bottom=False, tablet_left=15, mobile_top=10, mobile_right=10, mobile_bottom=10, mobile_left=10),
        'archive_post_space_between': '30', 'archive_post_content_alignment': 'center', 'archive_post_background_color': '#eeeeee',
        'archive_post_accent_color': '#aa0000', 'archive_post_accent_color_alt': '#00aa00', 'archive_post_title_size': '24px',
        'archive_post_font_size': '15',
        'search_custom_width': '80%', 'search_layout': 'beside', 'search_post_style': 'plain', 'search_post_space_between': '40',
        'search_post_image_alignment': 'right', 'search_post_image_width': '30', 'search_post_title_size': '20',
        'search_post_accent_color': '#123456',
        'docs-archive_custom_width': '1000px', 'docs-archive_layout': 'beside', 'docs-archive_post_style': 'boxed',
        'docs-archive_boxed_image_streched': True, 'docs-archive_boxed_padding': PAD(desktop_top=15, desktop_left=35, mobile_top=5),
        'docs-archive_post_background_color': 'rgba(0,0,0,0.05)', 'docs-archive_post_image_alignment': 'left',
        'docs-archive_post_image_width': '50', 'docs-archive_post_content_alignment': 'right', 'docs-archive_post_font_size': '1.1em',
        'blog_custom_width': '950px', 'blog_post_style': 'boxed', 'blog_post_background_color': '#dddddd', 'blog_post_space_between': '25',
        'single_custom_width': '760px', 'single_post_style': 'boxed', 'single_boxed_image_stretched': True,
        'single_boxed_padding': PAD(desktop_top=40, desktop_right=40, desktop_bottom=40, desktop_left=40, tablet_top=25, tablet_right=25,
                                    mobile_left=12, mobile_right=12),
        'single_post_background_color': '#fafafa', 'single_post_title_size': '32px', 'single_post_font_size': '18',
        'docs_custom_width': '700px', 'docs_post_style': 'boxed', 'docs_boxed_padding': PAD(desktop_top=50), 'docs_post_title_size': '28px',
    },
    # Blog: everything saved, but equal to the defaults.
    'blog2': {
        **{'blog_pagination_' + k: '' for k in ('background_color', 'background_color_alt', 'background_color_active', 'font_color',
                                                 'font_color_alt', 'font_color_active', 'font_size')},
        'blog_pagination_border_radius': '0',
        'archive_custom_width': '', 'archive_layout': 'beside', 'archive_post_style': 'boxed', 'archive_boxed_image_streched': False,
        'archive_boxed_padding': PAD(**{d + '_' + s: False for d in ('desktop', 'tablet', 'mobile') for s in ('top', 'right', 'bottom', 'left')}),
        'archive_post_space_between': '20', 'archive_post_content_alignment': 'left', 'archive_post_background_color': '#f5f5f7',
        'archive_post_accent_color': '', 'archive_post_accent_color_alt': '', 'archive_post_title_size': '', 'archive_post_font_size': '',
        'archive_post_image_alignment': 'left', 'archive_post_image_width': '40',
        'search_layout': 'default', 'search_post_style': 'plain', 'search_post_space_between': '20',
        'single_custom_width': '', 'single_post_style': 'boxed', 'single_boxed_image_stretched': False, 'single_boxed_padding': PAD(),
        'single_post_background_color': '#f5f5f7', 'single_post_title_size': '', 'single_post_font_size': '',
    },
    # Blog: odd saved values: numbers instead of text, capitals, '0' and empty padding sides, an empty alignment, an image
    # alignment the old code prints nothing for, stretched images with the beside layout.
    'blog3': {
        'blog_pagination_border_radius': 3, 'blog_pagination_font_size': 14, 'blog_pagination_background_color': '#ABCDEF',
        'blog_pagination_font_color_active': 'rgba(1,2,3,0.5)',
        'archive_custom_width': '1200px', 'archive_layout': 'beside', 'archive_post_style': 'boxed', 'archive_boxed_image_streched': True,
        'archive_boxed_padding': PAD(desktop_top='0', desktop_right=0, desktop_bottom='15', desktop_left='', tablet_top='0', mobile_bottom=7),
        'archive_post_space_between': 20, 'archive_post_background_color': '#F5F5F7', 'archive_post_image_width': 40,
        'archive_post_image_alignment': 'center', 'archive_post_content_alignment': '', 'archive_post_title_size': 18,
        'archive_post_font_size': '1.2em',
        'search_layout': 'default', 'search_post_style': 'plain', 'search_post_space_between': '20.0',
        'docs-archive_layout': 'default', 'docs-archive_post_style': 'boxed', 'docs-archive_boxed_image_streched': True,
        'docs-archive_boxed_padding': PAD(desktop_top='0', desktop_right='18', desktop_left='0', tablet_left=9, mobile_top=4),
        'single_custom_width': '100%', 'single_post_style': 'boxed', 'single_post_background_color': '#F5F5F7',
        'single_boxed_image_stretched': True, 'single_boxed_padding': PAD(desktop_top='0', desktop_left=22, tablet_top=11),
        'single_post_title_size': 30,
    },
    # Blog: values no control produces: '0' everywhere, padding that isn't JSON or only zeros.
    'blog4': {
        'blog_pagination_background_color': '0', 'blog_pagination_border_radius': '0', 'blog_pagination_font_size': '0',
        'blog_pagination_font_color_alt': '0',
        'archive_custom_width': '0', 'archive_layout': 'beside', 'archive_post_style': 'boxed', 'archive_post_background_color': '0',
        'archive_post_space_between': '0', 'archive_post_title_size': '0', 'archive_post_accent_color': '0',
        'archive_boxed_padding': 'not json', 'archive_post_image_width': '0', 'archive_post_content_alignment': '0',
        'search_layout': 'default', 'search_post_style': 'plain', 'search_post_space_between': '0',
        'single_custom_width': '0', 'single_post_style': 'boxed', 'single_post_background_color': '', 'single_post_font_size': '0',
        'single_boxed_padding': PAD(desktop_top='0', desktop_right='0', desktop_bottom='0', desktop_left='0'),
    },
    # Blog: options set whose switch is off (plain style with boxed options, image width without the beside layout).
    'blog5': {
        'archive_layout': 'default', 'archive_post_style': 'plain', 'archive_post_background_color': '#123123',
        'archive_boxed_padding': PAD(desktop_top=50), 'archive_post_image_width': '25', 'archive_post_image_alignment': 'right',
        'archive_post_space_between': '35', 'archive_boxed_image_streched': True,
        'search_layout': 'beside', 'search_post_style': 'boxed', 'search_boxed_image_streched': True,
        'search_boxed_padding': PAD(desktop_top=30, desktop_right=30, desktop_left=30), 'search_post_space_between': '15',
        'docs-archive_layout': 'default', 'docs-archive_post_style': 'boxed', 'docs-archive_boxed_image_streched': False,
        'docs-archive_boxed_padding': PAD(desktop_top=21, tablet_left=13),
        'single_post_style': 'plain', 'single_post_background_color': '#321321', 'single_boxed_padding': PAD(desktop_top=60),
        'single_boxed_image_stretched': True,
    },
    # WooCommerce: everything changed (notices, cart menu item, theme buttons on WooCommerce buttons, shop loop with the
    # list layout, sale badge, product page, checkout side by side), custom breakpoints.
    'woocommerce1': {
        '__wpbf_settings': {'wpbf_breakpoint_desktop': '1100px', 'wpbf_breakpoint_medium': '700px', 'wpbf_breakpoint_mobile': '400px'},
        'page_accent_color': '#ff0066',
        'woocommerce_store_notice_color': '#101010', 'woocommerce_info_notice_color': '#202020',
        'woocommerce_message_notice_color': '#303030', 'woocommerce_error_notice_color': '#404040',
        'woocommerce_notice_bg_color': '#505050', 'woocommerce_notice_text_color': 'rgba(1,2,3,0.6)',
        'woocommerce_menu_item_desktop': 'show', 'woocommerce_menu_item_desktop_color': '#aa0000',
        'woocommerce_menu_item_mobile': 'show', 'woocommerce_menu_item_mobile_color': '#00aa00',
        'menu_font_color': '#111111', 'mobile_menu_font_color': '#222222',
        'button_border_width': '2', 'button_primary_border_color': '#123456', 'button_primary_border_color_alt': '#654321',
        'button_primary_bg_color': '#0000aa', 'button_primary_text_color': '#fafafa', 'button_border_radius': '6',
        'button_primary_bg_color_alt': '#0000cc', 'button_primary_text_color_alt': '#eeeeee',
        'woocommerce_loop_custom_width': '1100px', 'woocommerce_loop_content_alignment': 'center', 'woocommerce_loop_layout': 'list',
        'woocommerce_loop_image_alignment': 'right', 'woocommerce_loop_image_width': '40',
        'woocommerce_loop_sale_alignment': 'center', 'woocommerce_loop_sale_layout': 'square', 'woocommerce_loop_sale_position': 'inside',
        'woocommerce_loop_sale_font_size': '16px', 'woocommerce_loop_sale_font_color': '#000000',
        'woocommerce_loop_sale_background_color': '#ffcc00',
        'woocommerce_loop_title_size': '18px', 'woocommerce_loop_title_color': '#333333', 'woocommerce_loop_price_size': '17px',
        'woocommerce_loop_price_color': '#444444', 'woocommerce_loop_out_of_stock_font_size': '12px',
        'woocommerce_loop_out_of_stock_font_color': '#eeeeee', 'woocommerce_loop_out_of_stock_background_color': 'rgba(200,0,0,0.8)',
        'woocommerce_single_custom_width': '1000px', 'woocommerce_single_alignment': 'right', 'woocommerce_single_image_width': '60',
        'woocommerce_single_summary_separator': 'show', 'woocommerce_single_tabs': 'default', 'woocommerce_single_tabs_font_size': '18px',
        'woocommerce_single_tabs_font_color': '#555555', 'woocommerce_single_tabs_font_color_alt': '#666666',
        'woocommerce_single_tabs_font_color_active': '#777777', 'woocommerce_single_tabs_background_color': '#dddddd',
        'woocommerce_single_tabs_background_color_alt': '#cccccc', 'woocommerce_single_tabs_background_color_active': '#bbbbbb',
        'woocommerce_single_price_size': '26px', 'woocommerce_single_price_color': '#888888', 'woocommerce_checkout_layout': 'side',
    },
    # WooCommerce: everything saved, but equal to the defaults (the old code prints the success and error notice colors
    # whenever they're saved).
    'woocommerce2': {
        'page_accent_color': '#3ba9d2', 'woocommerce_store_notice_color': '', 'woocommerce_info_notice_color': '',
        'woocommerce_message_notice_color': '#4fe190', 'woocommerce_error_notice_color': '#ff6347', 'woocommerce_notice_bg_color': '',
        'woocommerce_notice_text_color': '', 'woocommerce_menu_item_desktop': 'show', 'woocommerce_menu_item_desktop_color': '',
        'woocommerce_menu_item_mobile': 'show', 'woocommerce_menu_item_mobile_color': '', 'menu_font_color': '', 'mobile_menu_font_color': '',
        'button_border_width': '0', 'button_border_radius': '0', 'button_primary_border_color': '', 'button_primary_bg_color': '',
        'button_primary_text_color': '',
        'woocommerce_loop_custom_width': '', 'woocommerce_loop_content_alignment': 'left', 'woocommerce_loop_layout': 'default',
        'woocommerce_loop_image_alignment': 'left', 'woocommerce_loop_image_width': '50', 'woocommerce_loop_sale_alignment': 'left',
        'woocommerce_loop_sale_layout': 'round', 'woocommerce_loop_sale_position': 'outside', 'woocommerce_loop_sale_font_size': '14px',
        'woocommerce_loop_sale_font_color': '#ffffff', 'woocommerce_loop_sale_background_color': '#4fe190',
        'woocommerce_loop_title_size': '16px', 'woocommerce_loop_title_color': '#3e4349', 'woocommerce_loop_price_size': '16px',
        'woocommerce_loop_price_color': '#3e4349', 'woocommerce_loop_out_of_stock_font_size': '14px',
        'woocommerce_loop_out_of_stock_font_color': '#ffffff', 'woocommerce_loop_out_of_stock_background_color': 'rgba(0,0,0,.7)',
        'woocommerce_single_custom_width': '', 'woocommerce_single_alignment': 'left', 'woocommerce_single_image_width': '50',
        'woocommerce_single_summary_separator': 'hide', 'woocommerce_single_tabs': 'default', 'woocommerce_single_tabs_font_size': '16px',
        'woocommerce_single_tabs_font_color': '#3e4349', 'woocommerce_single_tabs_font_color_alt': '',
        'woocommerce_single_tabs_font_color_active': '', 'woocommerce_single_tabs_background_color': '#e7e7ec',
        'woocommerce_single_tabs_background_color_alt': '#f5f5f7', 'woocommerce_single_tabs_background_color_active': '#ffffff',
        'woocommerce_single_price_size': '22px', 'woocommerce_single_price_color': '#3e4349', 'woocommerce_checkout_layout': 'default',
    },
    # WooCommerce: odd saved values: capitals, numbers instead of text, sizes without a unit, 1200px widths, alignments the
    # old code prints nothing for, the modern tabs with tab colors set, a border width without a border color.
    'woocommerce3': {
        'page_accent_color': '#3BA9D2', 'woocommerce_message_notice_color': '#4FE190',
        'woocommerce_loop_sale_font_color': '#FFFFFF', 'woocommerce_single_price_color': '#3E4349', 'woocommerce_loop_price_color': '#abcabc',
        'woocommerce_loop_layout': 'list', 'woocommerce_loop_image_width': 50, 'woocommerce_loop_image_alignment': 'center',
        'woocommerce_single_image_width': 50, 'woocommerce_single_alignment': 'Right',
        'woocommerce_loop_sale_font_size': '18', 'woocommerce_loop_title_size': '1.2em', 'woocommerce_loop_price_size': 15,
        'woocommerce_single_tabs_font_size': '17', 'woocommerce_single_price_size': '24', 'woocommerce_loop_out_of_stock_font_size': '13',
        'woocommerce_single_custom_width': '1200px', 'woocommerce_loop_custom_width': '1200px',
        'woocommerce_loop_content_alignment': 'right', 'woocommerce_loop_sale_alignment': 'right', 'woocommerce_loop_sale_position': 'inside',
        'woocommerce_loop_sale_layout': 'square', 'woocommerce_single_tabs': 'modern', 'woocommerce_single_tabs_font_color_active': '#ABCDEF',
        'woocommerce_single_tabs_background_color': '#123123', 'woocommerce_loop_out_of_stock_background_color': 'rgba(0, 0, 0, .7)',
        'button_border_width': 1, 'button_border_radius': 4, 'button_primary_border_color': '', 'woocommerce_checkout_layout': 'side',
    },
    # WooCommerce: values no control produces: '0' everywhere, an empty sale alignment with the badge inside.
    'woocommerce4': {
        'page_accent_color': '0', 'woocommerce_single_tabs': 'modern',
        **{'woocommerce_%s_notice_color' % k: '0' for k in ('store', 'info', 'message', 'error')},
        'woocommerce_notice_bg_color': '0', 'woocommerce_notice_text_color': '0',
        'woocommerce_menu_item_desktop_color': '0', 'menu_font_color': '0', 'woocommerce_menu_item_mobile_color': '0', 'mobile_menu_font_color': '0',
        'button_border_width': '0', 'button_primary_border_color': '#111111', 'button_border_radius': '0', 'button_primary_bg_color': '0',
        'button_primary_text_color': '0', 'button_primary_bg_color_alt': '0', 'button_primary_text_color_alt': '0',
        'woocommerce_loop_custom_width': '0', 'woocommerce_single_custom_width': '0', 'woocommerce_loop_content_alignment': '0',
        'woocommerce_loop_layout': 'list', 'woocommerce_loop_image_width': '0', 'woocommerce_single_image_width': '0',
        'woocommerce_loop_sale_alignment': '', 'woocommerce_loop_sale_position': 'inside',
        **{'woocommerce_loop_' + k: '0' for k in ('sale_font_size', 'sale_font_color', 'sale_background_color', 'title_size', 'title_color',
                                                   'price_size', 'price_color', 'out_of_stock_font_size', 'out_of_stock_font_color',
                                                   'out_of_stock_background_color')},
        **{'woocommerce_single_' + k: '0' for k in ('price_size', 'price_color', 'tabs_font_size', 'tabs_font_color', 'tabs_font_color_alt',
                                                     'tabs_font_color_active')},
    },
    # WooCommerce: fallbacks (accent color for the store and info notices, the desktop count color on mobile, the loop
    # price color on the product page), options whose switch is off (hidden menu item, image options without the list
    # layout), empty tabs style (the default tabs), a hover border color only.
    'woocommerce5': {
        'page_accent_color': '#ff0066', 'woocommerce_menu_item_desktop': 'hide', 'woocommerce_menu_item_desktop_color': '#aa0000',
        'woocommerce_menu_item_mobile': 'show', 'menu_font_color': '#888888', 'mobile_menu_font_color': '#999999',
        'woocommerce_message_notice_color': '#4fe190', 'woocommerce_loop_price_color': '#777777',
        'woocommerce_loop_layout': 'default', 'woocommerce_loop_image_alignment': 'right', 'woocommerce_loop_image_width': '30',
        'woocommerce_single_tabs': '', 'woocommerce_single_tabs_background_color': '#121212',
        'woocommerce_single_tabs_background_color_alt': '#232323', 'woocommerce_loop_sale_alignment': 'left',
        'woocommerce_loop_sale_position': 'inside', 'woocommerce_loop_sale_layout': 'round', 'button_border_width': '3',
        'button_primary_border_color_alt': '#999000', 'woocommerce_checkout_layout': 'default',
    },
    # WooCommerce: modern tabs with nothing else set (the fixed accent blue), the menu font color as the only count color,
    # a centered round sale badge.
    'woocommerce6': {
        'woocommerce_single_tabs': 'modern', 'menu_font_color': '#121212', 'woocommerce_loop_sale_alignment': 'center',
        'woocommerce_loop_sale_layout': 'round', 'woocommerce_loop_sale_position': 'outside',
    },
    # Header: everything changed (text logo with font and tagline, centered menu, sub menu with separator, hamburger
    # mobile menu, mobile sub menu, one-column pre header), custom breakpoints. Sliders saved as numbers, as the
    # Customizer saves them.
    'header1': {
        '__wpbf_settings': {'wpbf_breakpoint_desktop': '1100px', 'wpbf_breakpoint_medium': '700px', 'wpbf_breakpoint_mobile': '400px'},
        'custom_logo': '', 'menu_logo_font_toggle': True, 'menu_logo_font_family': {**TYPO('Rubik', '700'), 'color': '#123456'},
        'menu_logo_color': '#101010', 'menu_logo_color_alt': '#202020',
        'menu_logo_font_size': json.dumps({'desktop': '26px', 'tablet': '22px', 'mobile': '18'}),
        'menu_logo_description': True, 'menu_logo_description_toggle': True, 'menu_logo_description_font_family': TYPO('Inter', 'italic'),
        'menu_logo_description_color': '#303030',
        'menu_logo_description_font_size': json.dumps({'desktop': '15px', 'tablet': '14', 'mobile': '13px'}),
        'menu_logo_container_width': 30, 'mobile_menu_logo_container_width': 60,
        'menu_position': 'menu-centered', 'menu_width': '1000px', 'menu_height': 30, 'menu_padding': 25, 'menu_bg_color': '#eeeeee',
        'menu_font_color': '#111111', 'menu_font_color_alt': '#222222', 'menu_font_size': '15px',
        'sub_menu_text_alignment': 'center', 'sub_menu_bg_color': '#fafafa', 'sub_menu_bg_color_alt': '#f0f0f0', 'sub_menu_width': 250,
        'sub_menu_padding': PAD(top=12, right=22, bottom=12, left=22), 'sub_menu_accent_color': '#333333',
        'sub_menu_accent_color_alt': '#444444', 'sub_menu_font_size': '13px', 'sub_menu_separator': True, 'sub_menu_separator_color': '#dddddd',
        'mobile_menu_options': 'menu-mobile-hamburger', 'mobile_menu_height': 15, 'mobile_menu_background_color': '#f8f8f8',
        'mobile_menu_padding': PAD(top=14, right=24, bottom=14, left=24), 'mobile_menu_font_color': '#121212',
        'mobile_menu_font_color_alt': '#232323', 'mobile_menu_border_color': '#cccccc', 'mobile_menu_hamburger_color': '#343434',
        'mobile_menu_hamburger_size': '20px', 'mobile_menu_hamburger_bg_color': '#454545', 'mobile_menu_hamburger_border_radius': 5,
        'mobile_menu_bg_color': '#fefefe', 'mobile_menu_bg_color_alt': '#efefef', 'mobile_menu_submenu_arrow_color': '#565656',
        'mobile_menu_font_size': '15px', 'mobile_sub_menu_indent': 10, 'mobile_sub_menu_bg_color': '#f1f1f1',
        'mobile_sub_menu_bg_color_alt': '#e1e1e1', 'mobile_sub_menu_arrow_color': '#676767', 'mobile_sub_menu_font_size': '13px',
        'mobile_sub_menu_font_color': '#787878', 'mobile_sub_menu_font_color_alt': '#898989',
        'pre_header_layout': 'one', 'pre_header_width': '1000px', 'pre_header_height': 12, 'pre_header_bg_color': '#000000',
        'pre_header_font_color': '#ffffff', 'pre_header_accent_color': '#aaaaaa', 'pre_header_accent_color_alt': '#bbbbbb',
        'pre_header_font_size': '13px',
    },
    # Header: everything saved, but equal to the defaults, as the Customizer saves them (sliders as numbers: the old "is
    # default" checks compared to text, so most of it printed). Stacked menu, two-column pre header.
    'header2': {
        'custom_logo': '', 'menu_logo_font_size': json.dumps({'desktop': '22px', 'tablet': '', 'mobile': ''}),
        'menu_logo_color': '', 'menu_logo_color_alt': '', 'menu_logo_description': True, 'menu_logo_description_color': '',
        'menu_logo_description_font_size': json.dumps({'desktop': '', 'tablet': '', 'mobile': ''}),
        'menu_logo_container_width': 25, 'mobile_menu_logo_container_width': 66,
        'menu_position': 'menu-stacked', 'menu_width': '', 'menu_height': 20, 'menu_padding': 20, 'menu_bg_color': '#f5f5f7',
        'menu_font_color': '', 'menu_font_color_alt': '', 'menu_font_size': '16px',
        'sub_menu_text_alignment': 'left', 'sub_menu_bg_color': '#ffffff', 'sub_menu_bg_color_alt': '#ffffff', 'sub_menu_width': 220,
        'sub_menu_padding': PAD(top=10, right=20, bottom=10, left=20), 'sub_menu_accent_color': '', 'sub_menu_accent_color_alt': '',
        'sub_menu_font_size': '', 'sub_menu_separator': True, 'sub_menu_separator_color': '#f5f5f7',
        'mobile_menu_options': 'menu-mobile-hamburger', 'mobile_menu_height': 20, 'mobile_menu_background_color': '',
        'mobile_menu_padding': PAD(top=10, right=20, bottom=10, left=20), 'mobile_menu_hamburger_color': '',
        'mobile_menu_hamburger_size': '16px', 'mobile_menu_hamburger_bg_color': '', 'mobile_menu_hamburger_border_radius': 0,
        'mobile_menu_bg_color': '#ffffff', 'mobile_menu_bg_color_alt': '#ffffff', 'mobile_menu_border_color': '#d9d9e0',
        'mobile_menu_font_color': '', 'mobile_menu_font_color_alt': '', 'mobile_menu_submenu_arrow_color': '', 'mobile_menu_font_size': '16px',
        'mobile_sub_menu_indent': 0, 'mobile_sub_menu_bg_color': '', 'mobile_sub_menu_bg_color_alt': '', 'mobile_sub_menu_font_color': '',
        'mobile_sub_menu_font_color_alt': '', 'mobile_sub_menu_arrow_color': '', 'mobile_sub_menu_font_size': '',
        'pre_header_layout': 'two', 'pre_header_width': '', 'pre_header_height': 10, 'pre_header_bg_color': '#ffffff',
        'pre_header_font_color': '', 'pre_header_accent_color': '', 'pre_header_accent_color_alt': '', 'pre_header_font_size': '14px',
    },
    # Header: odd saved values: sliders saved as text (older sites), capitals, sizes without a unit, 1200px widths with
    # another page width, padding sides as text, custom logo with sizes; Premium's off-canvas menu and mobile menu.
    'header3': {
        'page_max_width': '1100px', 'custom_logo': 127346,
        'menu_logo_size': json.dumps({'desktop': '200', 'tablet': 180, 'mobile': '150px'}),
        'menu_logo_font_size': json.dumps({'desktop': '30px'}), 'menu_logo_color': '#ABCDEF',
        'menu_position': 'menu-off-canvas', 'mobile_menu_options': 'menu-mobile-off-canvas',
        'menu_width': '1200px', 'menu_height': '20', 'menu_padding': 20, 'menu_bg_color': '#F5F5F7', 'menu_font_size': 16,
        'menu_logo_container_width': '25', 'mobile_menu_logo_container_width': 66,
        'sub_menu_width': '220', 'sub_menu_bg_color': '#FFFFFF', 'sub_menu_padding': PAD(top='10', right=20, bottom=10, left=30),
        'sub_menu_separator': True, 'sub_menu_separator_color': '#F5F5F7', 'sub_menu_font_size': 14,
        'mobile_menu_height': '20', 'mobile_menu_border_color': '#D9D9E0', 'mobile_menu_bg_color': '#FFFFFF',
        'mobile_menu_padding': PAD(top=10, right='20', bottom=12, left=20), 'mobile_menu_hamburger_size': 18,
        'mobile_menu_hamburger_color': '#ABABAB', 'mobile_menu_hamburger_border_radius': 4, 'mobile_menu_font_size': '16',
        'mobile_sub_menu_font_size': 12, 'mobile_sub_menu_indent': '15',
        'pre_header_layout': 'two', 'pre_header_width': '1200px', 'pre_header_height': '10', 'pre_header_bg_color': '#FFFFFF',
        'pre_header_font_size': 14,
    },
    # Header: values no control produces: '0' and 0, empty values, JSON that isn't JSON. Left menu, default mobile menu.
    'header4': {
        'custom_logo': '', 'menu_position': 'menu-left', 'mobile_menu_options': 'menu-mobile-default',
        'menu_logo_font_size': json.dumps({'desktop': 0, 'tablet': '0', 'mobile': ''}), 'menu_logo_color': '0',
        'menu_logo_description': True, 'menu_logo_description_font_size': 'not json', 'menu_logo_description_color': '0',
        'menu_logo_container_width': 0, 'mobile_menu_logo_container_width': '0',
        'menu_width': '0', 'menu_height': 0, 'menu_padding': '0', 'menu_bg_color': '', 'menu_font_color': '0', 'menu_font_size': '0',
        'menu_font_color_alt': '0', 'sub_menu_text_alignment': '', 'sub_menu_bg_color': '0', 'sub_menu_bg_color_alt': '0',
        'sub_menu_width': '0', 'sub_menu_padding': PAD(top='0', right=0, bottom='', left=False), 'sub_menu_accent_color': '0',
        'sub_menu_font_size': '0', 'mobile_menu_height': '0', 'mobile_menu_padding': 'not json', 'mobile_menu_bg_color_alt': '',
        'mobile_menu_border_color': '0', 'mobile_menu_font_size': '', 'mobile_menu_bg_color': '0',
        'mobile_sub_menu_indent': '0', 'mobile_sub_menu_font_color': '0', 'mobile_sub_menu_font_size': '0',
        'pre_header_layout': 'one', 'pre_header_height': '0', 'pre_header_width': '0', 'pre_header_bg_color': '0',
        'pre_header_font_size': '0', 'pre_header_accent_color': '0',
    },
    # Header: options set whose switch is off (custom logo with text logo options, logo font off, tagline off, no pre header,
    # separator off, hamburger options with the default mobile menu); options from old versions nobody registers.
    'header5': {
        'custom_logo': 127346, 'menu_logo_size': json.dumps({'desktop': '', 'tablet': '', 'mobile': ''}),
        'menu_logo_font_toggle': True, 'menu_logo_font_family': TYPO('Rubik', '700'), 'menu_logo_color': '#121212',
        'menu_logo_font_size': json.dumps({'desktop': '30px'}), 'menu_logo_description': False, 'menu_logo_description_color': '#343434',
        'menu_logo_description_toggle': True, 'menu_logo_description_font_family': TYPO('Inter', '600'),
        'pre_header_layout': 'none', 'pre_header_bg_color': '#000000', 'pre_header_height': 20, 'pre_header_font_color': '#ffffff',
        'sub_menu_separator': False, 'sub_menu_separator_color': '#ff0000',
        'mobile_menu_options': 'menu-mobile-default', 'mobile_menu_hamburger_color': '#ff00ff', 'mobile_menu_hamburger_bg_color': '#00ffff',
        'mobile_menu_hamburger_size': '22px', 'mobile_menu_hamburger_border_radius': 6, 'menu_position': 'menu-right', 'menu_height': 35,
        'mobile_sub_menu_border_color': '#abcabc', 'mobile_menu_padding_left': '30', 'mobile_sub_menu_indent': 8,
    },
    # Header: Premium's full screen menu with padding saved as text (old sites), a logo font with odd parts, a tagline font
    # without a variant, the hamburger filled without radius.
    'header6': {
        'custom_logo': '', 'menu_position': 'menu-full-screen', 'menu_padding': '20', 'menu_height': 20,
        'mobile_menu_options': 'menu-mobile-hamburger', 'mobile_menu_hamburger_bg_color': '#123456',
        'mobile_menu_hamburger_border_radius': 0, 'mobile_menu_hamburger_color': '#ffffff',
        'menu_logo_font_toggle': True, 'menu_logo_font_family': {'font-family': 'Georgia, serif', 'variant': '700italic', 'color': '#ff0000'},
        'menu_logo_description': True, 'menu_logo_description_toggle': True, 'menu_logo_description_font_family': {'font-family': 'Inter'},
        'sub_menu_text_alignment': 'right', 'menu_font_color_alt': '#00b1ff', 'mobile_menu_font_color_alt': '#ff00aa',
    },
    # Header: Premium's stacked (advanced) menu, padding saved as the default number, two-column pre header with a hover color.
    'header7': {
        'custom_logo': '', 'menu_position': 'menu-stacked-advanced', 'menu_padding': 20, 'menu_height': 15,
        'menu_logo_container_width': 40, 'mobile_menu_logo_container_width': 50,
        'pre_header_layout': 'two', 'pre_header_accent_color_alt': '#ff6600', 'pre_header_font_color': '#333333',
        'mobile_sub_menu_font_color_alt': '#aa00aa', 'sub_menu_accent_color_alt': '#00aa00',
    },
    # Header: Premium's off-canvas (left) menu and mobile menu, one padding side changed (the others stay the defaults),
    # the logo's tablet size with the desktop size at its default.
    'header8': {
        'custom_logo': '', 'menu_position': 'menu-off-canvas-left', 'menu_padding': 30, 'mobile_menu_options': 'menu-mobile-off-canvas',
        'mobile_menu_padding': PAD(top=10, right=20, bottom=10, left=30), 'sub_menu_padding': PAD(top=10, right=30, bottom=10, left=20),
        'menu_logo_font_size': json.dumps({'desktop': '22px', 'tablet': '18px', 'mobile': ''}),
        'menu_logo_description': True, 'menu_logo_description_font_size': json.dumps({'desktop': '', 'tablet': '12px', 'mobile': ''}),
    },
    # Premium (its CSS areas, premium-<area>): everything changed, with custom breakpoints and a color palette.
    'premium-general1': {
        '__wpbf_settings': {'wpbf_breakpoint_desktop': '1100px', 'wpbf_breakpoint_medium': '700px', 'wpbf_breakpoint_mobile': '400px',
                            'color_palette': ['#101010', '#202020', '', '#404040']},
        'base_color_global': '#eeeeee', 'base_color_alt_global': '#dddddd', 'brand_color_global': '#111111',
        'brand_color_alt_global': '#222222', 'accent_color_global': '#ff6600', 'accent_color_alt_global': 'rgba(255,102,0,0.7)',
    },
    # Premium: everything saved equal to the defaults, some in capitals (the old check compared text).
    'premium-general2': {
        'base_color_global': '#f5f5f7', 'base_color_alt_global': '#DEDEE5', 'brand_color_global': '#3e4349',
        'brand_color_alt_global': '#6D7680', 'accent_color_global': '#3ba9d2', 'accent_color_alt_global': '#79c4e0',
    },
    # Premium: values no control saves ('0', empty).
    'premium-general3': {'base_color_global': '0', 'base_color_alt_global': '', 'accent_color_global': 'var(--x)'},
    # Premium typography: everything changed, custom breakpoints, every heading switch on, sizes with and without a unit.
    'premium-typography1': {
        '__wpbf_settings': {'wpbf_breakpoint_desktop': '1100px', 'wpbf_breakpoint_medium': '700px', 'wpbf_breakpoint_mobile': '400px'},
        'page_font_size': json.dumps({'desktop': '17px', 'tablet': '15', 'mobile': '0.9em'}), 'page_line_height': '1.5',
        'page_bold_color': '#101010', 'menu_letter_spacing': '1', 'menu_text_transform': 'uppercase',
        'sub_menu_letter_spacing': '0.5', 'sub_menu_text_transform': 'lowercase',
        'page_h1_font_color': '#111111', 'page_h1_line_height': '1.4', 'page_h1_letter_spacing': '2', 'page_h1_text_transform': 'uppercase',
        'page_h1_font_size': json.dumps({'desktop': '40px', 'tablet': '30px', 'mobile': '24'}),
        **{k % n: v for n in range(2, 7) for k, v in {
            'page_h%d_toggle': True, 'page_h%d_line_height': '1.3', 'page_h%d_letter_spacing': '1', 'page_h%d_text_transform': 'capitalize',
            'page_h%d_font_color': '#2%d2%d2%d'.replace('%d', '0'), 'page_h%d_font_size': json.dumps({'desktop': '30px', 'tablet': '', 'mobile': '20'})}.items()},
    },
    # Premium typography: everything saved as the defaults, as the Customizer saves them (sliders as numbers), heading
    # switches on. (Sliders saved as text, as older versions did: premium-typography3.)
    'premium-typography2': {
        'page_font_size': json.dumps({'desktop': '16px', 'tablet': '', 'mobile': ''}), 'page_line_height': 1.7, 'page_bold_color': '',
        'menu_letter_spacing': 0, 'menu_text_transform': 'none', 'sub_menu_letter_spacing': 0, 'sub_menu_text_transform': 'none',
        'page_h1_font_color': '#000', 'page_h1_line_height': 1.2, 'page_h1_letter_spacing': 0, 'page_h1_text_transform': 'none',
        'page_h1_font_size': json.dumps({'desktop': '32px', 'tablet': '', 'mobile': ''}),
        'page_h2_toggle': True, 'page_h2_line_height': 1.2, 'page_h2_letter_spacing': 0, 'page_h2_text_transform': 'none',
        'page_h2_font_color': '#000', 'page_h2_font_size': json.dumps({'desktop': '28px', 'tablet': '', 'mobile': ''}),
        'page_h3_toggle': True, 'page_h3_font_size': json.dumps({'desktop': '24px', 'tablet': '', 'mobile': ''}),
    },
    # Premium typography: odd saved values (numbers instead of text, zeros, empty parts, missing parts, broken JSON),
    # heading switches on with nothing else saved, H1 transform/spacing set so the H2-H6 ones override it.
    'premium-typography3': {
        'page_line_height': '1.7', 'menu_letter_spacing': '0', 'sub_menu_letter_spacing': '', 'page_h1_letter_spacing': '0',
        'page_h1_text_transform': 'uppercase', 'page_h1_line_height': 1.2, 'page_h1_font_color': '#000000',
        'page_font_size': json.dumps({'desktop': 16, 'tablet': '0', 'mobile': ''}), 'page_h1_font_size': json.dumps({'tablet': '20px'}),
        'page_h2_font_size': 'not json', 'page_h3_font_size': json.dumps({'desktop': '', 'tablet': '', 'mobile': ''}),
        'page_h2_toggle': True, 'page_h3_toggle': True, 'page_h3_letter_spacing': 0, 'page_h4_toggle': '1', 'page_h4_text_transform': '',
        'page_h5_font_color': '0', 'page_h6_font_color': '#ABCDEF',
    },
}
HAND_ONLY_FRONT = ('/', '/related-posts/', '/category/blog/', '/?p=366', '/checkout/')

RULES = [
    (r'(nonce|_wpnonce|_ajax_nonce|security|_wp_http_referer)(["\'=:\s\\]+)[0-9a-f]{10}', r'\1\2NONCE', re.I),
    (r'([?&;]|&amp;)(ver|v|time|t|_)=[0-9a-zA-Z.\-]+', r'\1\2=X', 0),
    (r'\b1[6-9]\d{11}\b', 'MS', 0),
    (r'\b1[6-9]\d{8}\b', 'TS', 0),
    (r'"(nonce|restNonce|ajax_nonce|wpApiSettings)[^"]*"\s*:\s*"[^"]*"', r'"\1":"X"', 0),
    # One comment only: a looser pattern ran from the first comment in <head> to a later one and ate the CSS.
    (r'<!--(?:(?!-->).)*?(generated|queries|seconds|cached)(?:(?!-->).)*?-->', '', re.I | re.S),
    (r'[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}', 'UUID', 0),
    (r'post_ID[^0-9]{1,20}\d+', 'post_ID=N', 0),
    (r'data-token="[0-9a-f]+"', 'data-token="X"', 0),
    (r'(value|content)=(\\?)"[0-9a-f]{10}(\\?)"', r'\1=\2"NONCE\3"', 0),
    (r'"[0-9a-f]{10}"', '"NONCE10"', 0),
    (r'\d{4}-\d\d-\d\d \d\d:\d\d:\d\d', 'DATETIME', 0),
    (r'days_active=\d+', 'days_active=N', 0),
]

# Settings types the synthetic variants leave alone (no value to vary, or complex structures).
SKIP_TYPES = {'headline', 'headline-toggle', 'divider', 'custom', 'section-tabs', 'code', 'editor', 'repeater',
              'typography', 'image', 'upload', 'sortable'}
COLORS = ['#112233', '#a1b2c3', '#c0ffee', 'rgba(10,20,30,0.5)']


def norm(t):
    for pattern, repl, flags in RULES:
        t = re.sub(pattern, repl, t, flags=flags)
    return t


def build_variants():
    """Every setting registered with wpbf_customizer_field() gets a value per variant (4 combinations)."""
    # The theme's and Premium's settings files leave the type to the option schema (Customizer/Schema/*.php,
    # Premium's inc/customizer/schema/*.php).
    schema_types = {}
    for schema_dir in (os.path.join(THEME, 'Customizer', 'Schema'), os.path.join(PREMIUM, 'inc', 'customizer', 'schema')):
        for f in os.listdir(schema_dir) if os.path.isdir(schema_dir) else ():
            if f.endswith('.php'):
                s = open(os.path.join(schema_dir, f), encoding='utf-8').read()
                schema_types.update(re.findall(r"^\t'([a-z0-9_]+)'\s*=> array\(\s*'type'\s*=> '([a-z\-]+)'", s, re.M))
    fields = {}
    for root in (THEME, PREMIUM):
        for d, dirs, fs in os.walk(root):
            dirs[:] = [x for x in dirs if x not in ('vendor', 'node_modules', '.git', 'bin')]
            for f in fs:
                if not f.endswith('.php'):
                    continue
                s = open(os.path.join(d, f), encoding='utf-8', errors='ignore').read()
                for chunk in s.split('wpbf_customizer_field()')[1:]:
                    head = chunk.split(';', 1)[0]
                    chunk = head if '->addToSection' in head else chunk[:3000]
                    m = re.search(r"->id\(\s*'([a-z0-9_]+)'\s*\)", chunk)
                    t = re.search(r"->type\(\s*'([a-z\-]+)'\s*\)", chunk)
                    t = t.group(1) if t else (schema_types.get(m.group(1)) if m else None)
                    if not m or not t:
                        continue
                    ch = re.search(r"->choices\(\s*(?:\[|array\()(.*?)(?:\]|\))\s*\)", chunk, re.S)
                    fields[m.group(1)] = {
                        'type': t,
                        'choices': re.findall(r"'([A-Za-z0-9_\-]+)'\s*=>", ch.group(1)) if ch else [],
                        'multiple': bool(re.search(r"'multiple'\s*=>\s*(true|[2-9]|\d\d)", chunk)),
                    }

    def value(f, k):
        t = f['type']
        if f['choices'] and f['multiple']:
            return f['choices'][:1 + k % 2]
        if f['choices']:
            return f['choices'][k % len(f['choices'])]
        if t == 'color':
            return COLORS[k % 4]
        if t in ('toggle', 'checkbox'):
            return k % 2 == 0
        if t in ('slider', 'input-slider', 'number'):
            return str(7 + k * 5)
        if t.startswith('responsive'):
            return json.dumps({'desktop': str(10 + k), 'tablet': str(8 + k), 'mobile': str(6 + k)})
        if t in ('dimension', 'text'):
            return str(11 + k) + 'px'
        if t == 'margin-padding':
            return json.dumps({'top': 1 + k, 'right': 2 + k, 'bottom': 3 + k, 'left': 4 + k})
        return None

    variants = {}
    for k in range(4):
        variants['synthetic%d' % k] = {fid: v for fid, f in fields.items() if f['type'] not in SKIP_TYPES
                                       for v in [value(f, k)] if v is not None}
    variants.update(HAND_VARIANTS)
    json.dump(variants, open(os.path.join(OUT, 'variants.json'), 'w'), indent=1)
    print('variants.json:', len(fields), 'settings found,', len(variants['synthetic0']), 'varied')


def jobs(only=None):
    for v in (only or VARIANTS):
        for prem in ('', '1'):
            pages = HAND_ONLY_FRONT + tuple(WOO_FRONT if v.startswith('woocommerce') else ()) if v in HAND_VARIANTS else FRONT
            for u in pages:
                yield (v, prem, u, False)
            if v in ADMIN_VARIANTS:
                for u in ADMIN:
                    yield (v, prem, u, True)


def fetch(job, cookie):
    v, prem, u, admin = job
    url = BASE + u + ('&' if '?' in u else '?') + 'zz_snap=' + v + ('&zz_nopremium=1' if prem else '')
    name = '%s%s__%s' % (v, '-noprem' if prem else '', re.sub(r'[^a-z0-9]+', '_', u.lower()).strip('_') or 'home')
    for _ in range(5):  # Local's PHP answers 502 when busy.
        req = urllib.request.Request(url, headers={'Cookie': cookie} if admin else {})
        try:
            r = urllib.request.urlopen(req, timeout=120)
            code, body = r.status, r.read()
        except urllib.error.HTTPError as e:
            code, body = e.code, e.read()
        if code not in (502, 503, 504):
            break
        time.sleep(3)
    return name, code, norm(body.decode('utf-8', 'replace'))


def take(name, only=None):
    os.makedirs(OUT, exist_ok=True)
    vfile = os.path.join(OUT, 'variants.json')
    if not os.path.exists(vfile):
        build_variants()
    else:  # Keep the generated variants, refresh the hand-made ones.
        variants = json.load(open(vfile))
        variants.update(HAND_VARIANTS)
        json.dump(variants, open(vfile, 'w'), indent=1)
    target = os.path.join(OUT, name)
    shutil.rmtree(target, ignore_errors=True)
    os.makedirs(target)

    db_before = db_state()
    login = subprocess.run(PHP + [os.path.join(HERE, 'login.php'), WP_ROOT, 'create'], capture_output=True, text=True).stdout
    cookie, token = login.strip().split('\n')
    shutil.copy(os.path.join(HERE, 'mu-plugin.php'), MU)
    start = os.path.getsize(LOG) if os.path.exists(LOG) else 0
    bad = []
    try:
        with ThreadPoolExecutor(2) as ex:
            for page, code, text in ex.map(lambda j: fetch(j, cookie), list(jobs(only))):
                open(os.path.join(target, page + '.html'), 'w', encoding='utf-8').write('HTTP %d\n' % code + text)
                if code >= 500 or 'critical error' in text:
                    bad.append(page)
    finally:
        os.remove(MU)
        subprocess.run(PHP + [os.path.join(HERE, 'login.php'), WP_ROOT, 'destroy', token])

    msgs = []
    if os.path.exists(LOG):
        with open(LOG, encoding='utf-8', errors='replace') as f:
            f.seek(start)
            msgs = sorted(set(re.sub(r'^\[[^\]]+\] ', '', l) for l in f.read().splitlines() if l.startswith('[')))
    open(os.path.join(target, '_php-errors.txt'), 'w', encoding='utf-8').write('\n'.join(msgs))
    print('%s: %d pages, %d broken %s, %d PHP log messages' % (name, len(os.listdir(target)) - 1, len(bad), bad, len(msgs)))
    warn_if_db_changed(db_before)


def db_state():
    """Counts and highest ids of the content tables (posts, meta, comments)."""
    return subprocess.run(PHP + [os.path.join(HERE, 'login.php'), WP_ROOT, 'dbstate'], capture_output=True, text=True).stdout.strip()


def warn_if_db_changed(before):
    after = db_state()
    if after != before:
        print('WARNING: content tables changed during the run (someone else working on the site, or the run wrote something):')
        print('  before', before)
        print('  after ', after)


def compare(a, b):
    a, b = os.path.join(OUT, a), os.path.join(OUT, b)
    same = indent = 0
    real = []
    for f in sorted(set(os.listdir(a)) | set(os.listdir(b))):
        pa, pb = os.path.join(a, f), os.path.join(b, f)
        if not (os.path.exists(pa) and os.path.exists(pb)):
            real.append((f, ['only on one side']))
            continue
        x, y = norm(open(pa, encoding='utf-8').read()), norm(open(pb, encoding='utf-8').read())
        if f == '_php-errors.txt':
            # Only messages from the theme or Premium count (other plugins log compile-time notices at random).
            x, y = [re.sub(r'.*\n?', lambda m: m.group(0) if re.search(r'page-builder-framework|wpbf-premium', m.group(0)) else '', s) for s in (x, y)]
        if x == y:
            same += 1
        elif [l.strip() for l in x.splitlines()] == [l.strip() for l in y.splitlines()]:
            indent += 1  # Only the indentation of lines changed: invisible.
        else:
            d = list(difflib.unified_diff([l.strip() for l in x.splitlines()], [l.strip() for l in y.splitlines()], lineterm='', n=0))
            real.append((f, d[2:]))
    for f, d in real:
        print('== %s (%d lines)' % (f, len(d)))
        for line in d[:12]:
            print('   ', line[:220])
    print('%d identical, %d differ only in indentation, %d really differ' % (same, indent, len(real)))
    return not real


if __name__ == '__main__':
    if len(sys.argv) in (3, 4) and sys.argv[1] == 'take':
        take(sys.argv[2], sys.argv[3].split(',') if len(sys.argv) == 4 else None)
    elif len(sys.argv) == 4 and sys.argv[1] == 'diff':
        sys.exit(0 if compare(sys.argv[2], sys.argv[3]) else 1)
    else:
        print(__doc__)
