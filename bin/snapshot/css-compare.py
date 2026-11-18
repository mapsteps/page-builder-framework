"""Compare the Customizer CSS of two snapshots by meaning, not by text (dev only, never shipped).

    python bin/snapshot/css-compare.py before after

The Customizer CSS (<style id="wpbf-style-inline-css">) of each page is split into declarations
(media, selector, property, value). For every page it lists the declarations that win in one snapshot but not in the
other (the last one of a media/selector/property counts), and whether the order of the remaining declarations
changed. Pages with the same differences are grouped.
"""
import os, re, sys
from collections import defaultdict

OUT = os.path.join(os.path.dirname(os.path.abspath(__file__)), 'output')
STYLE = re.compile(r'<style id=["\'](?:wpbf-style|wpbf-premium)-inline-css["\']>(.*?)</style>', re.S)  # Premium moves it.


def declarations(css):
    """Flat list of (media, selector, property, value) in order."""
    found = []
    pos = 0
    stack = []  # media queries
    selector = None
    token = ''
    while pos < len(css):
        ch = css[pos]
        if ch == '{':
            head = token.strip()
            token = ''
            if head.startswith('@media'):
                stack.append(re.sub(r'\s+', ' ', head[6:]).strip())
            else:
                selector = re.sub(r'\s*,\s*', ',', re.sub(r'\s+', ' ', head))
        elif ch == '}':
            if selector is not None:
                body, token = token, ''
                for part in body.split(';'):
                    if ':' in part:
                        prop, value = part.split(':', 1)
                        found.append((' '.join(stack), selector, prop.strip(), re.sub(r'\s+', ' ', value.strip())))
                selector = None
            elif stack:
                stack.pop()
                token = ''
        else:
            if ch == ';' and selector is None:
                token = ''  # @import and the like
            else:
                token += ch
        pos += 1
    return found


def winners(decls):
    win = {}
    for media, selector, prop, value in decls:
        win[(media, selector, prop)] = value
    return win


def page_css(path):
    m = STYLE.search(open(path, encoding='utf-8').read())
    return m.group(1) if m else ''


def main(a, b):
    groups = defaultdict(list)
    for f in sorted(os.listdir(os.path.join(OUT, a))):
        pb = os.path.join(OUT, b, f)
        if not f.endswith('.html') or not os.path.exists(pb):
            continue
        da, db = declarations(page_css(os.path.join(OUT, a, f))), declarations(page_css(pb))
        wa, wb = winners(da), winners(db)
        lines = []
        for key in sorted(set(wa) | set(wb)):
            if wa.get(key) != wb.get(key):
                lines.append('  %s %s { %s: %s  ->  %s }' % ('@media ' + key[0] if key[0] else '', key[1], key[2], wa.get(key, '(none)'), wb.get(key, '(none)')))
        # Order of the declarations that are in both, by their winning position.
        common = [k for k in wa if k in wb and wa[k] == wb[k]]
        last_a = {(m, s, p): i for i, (m, s, p, v) in enumerate(da)}
        last_b = {(m, s, p): i for i, (m, s, p, v) in enumerate(db)}
        order_a = sorted(common, key=lambda k: last_a[k])
        order_b = sorted(common, key=lambda k: last_b[k])
        if order_a != order_b:
            # Only same-property declarations can override each other: compare per property.
            for prop in sorted({k[2] for k in common}):
                if [k for k in order_a if k[2] == prop] != [k for k in order_b if k[2] == prop]:
                    lines.append('  order changed for property %s' % prop)
        if lines:
            groups['\n'.join(lines)].append(f)
    for text, files in groups.items():
        print('== %d pages: %s%s' % (len(files), ', '.join(files[:4]), ' ...' if len(files) > 4 else ''))
        print(text)
    print('%d groups of differences' % len(groups))


if __name__ == '__main__':
    if len(sys.argv) != 3:
        print(__doc__)
        sys.exit(1)
    main(sys.argv[1], sys.argv[2])
