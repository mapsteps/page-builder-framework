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
         '/?m=2020']
ADMIN = ['/wp-admin/themes.php?page=wpbf-premium', '/wp-admin/edit.php', '/wp-admin/edit.php?post_type=page',
         '/wp-admin/customize.php', '/wp-admin/post.php?post=366&action=edit', '/wp-admin/index.php']
VARIANTS = ['live', 'defaults', 'synthetic0', 'synthetic1', 'synthetic2', 'synthetic3', 'general1', 'general2', 'general3',
            'general4', 'footer1', 'footer2', 'footer3', 'footer4', 'footer5', 'edd1', 'edd2', 'edd3', 'edd4', 'edd5']
ADMIN_VARIANTS = ('live', 'synthetic0', 'synthetic1')

# Hand-made variants for the General area, saved the way the Customizer saves them (sliders as text, padding as JSON
# text with numbers and false for empty sides). '__wpbf_settings' swaps in Premium's breakpoints.
PAD = lambda **k: json.dumps(k, separators=(',', ':'))
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
    # The theme's settings files leave the type to the option schema (Customizer/Schema/*.php).
    schema_types = {}
    schema_dir = os.path.join(THEME, 'Customizer', 'Schema')
    for f in os.listdir(schema_dir):
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
            for u in (HAND_ONLY_FRONT if v in HAND_VARIANTS else FRONT):
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
