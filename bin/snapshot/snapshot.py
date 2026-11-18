"""Output snapshot of the theme on pbf.local (dev only, never shipped).

Renders a fixed set of frontend and admin pages under several Customizer setting combinations,
with the Premium Add-On on and off, and saves the HTML (noise like nonces removed) plus any new
PHP warnings. Take one before a change and one after, then compare.

    python bin/snapshot/snapshot.py take before
    python bin/snapshot/snapshot.py take after
    python bin/snapshot/snapshot.py diff before after

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
VARIANTS = ['live', 'defaults', 'synthetic0', 'synthetic1', 'synthetic2', 'synthetic3']
ADMIN_VARIANTS = ('live', 'synthetic0', 'synthetic1')

RULES = [
    (r'(nonce|_wpnonce|_ajax_nonce|security|_wp_http_referer)(["\'=:\s\\]+)[0-9a-f]{10}', r'\1\2NONCE', re.I),
    (r'([?&;]|&amp;)(ver|v|time|t|_)=[0-9a-zA-Z.\-]+', r'\1\2=X', 0),
    (r'\b1[6-9]\d{11}\b', 'MS', 0),
    (r'\b1[6-9]\d{8}\b', 'TS', 0),
    (r'"(nonce|restNonce|ajax_nonce|wpApiSettings)[^"]*"\s*:\s*"[^"]*"', r'"\1":"X"', 0),
    (r'<!--.*?(generated|queries|seconds|cached).*?-->', '', re.I | re.S),
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
    json.dump(variants, open(os.path.join(OUT, 'variants.json'), 'w'), indent=1)
    print('variants.json:', len(fields), 'settings found,', len(variants['synthetic0']), 'varied')


def jobs():
    for v in VARIANTS:
        for prem in ('', '1'):
            for u in FRONT:
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


def take(name):
    os.makedirs(OUT, exist_ok=True)
    if not os.path.exists(os.path.join(OUT, 'variants.json')):
        build_variants()
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
            for page, code, text in ex.map(lambda j: fetch(j, cookie), list(jobs())):
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
    if len(sys.argv) == 3 and sys.argv[1] == 'take':
        take(sys.argv[2])
    elif len(sys.argv) == 4 and sys.argv[1] == 'diff':
        sys.exit(0 if compare(sys.argv[2], sys.argv[3]) else 1)
    else:
        print(__doc__)
