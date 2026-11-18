"""Compare the controls of two Customizer check runs (dev only, never shipped).

    python bin/snapshot/controls-compare.py markup before.json after.json [ignored-attr,...]
    python bin/snapshot/controls-compare.py layout before.json after.json      (runs made with --layout)

markup: each control's rendered markup, ignoring whitespace between tags, attribute order, class order and how
boolean attributes are written (e.g. ignore data-customize-setting-link when a control stops using core's links).
layout: each control's element boxes (position and size inside the control); elements without a size are skipped.
Whitespace the old templates had between inline elements moves things: layout shows it, markup doesn't.
"""
import difflib
import json
import re
import sys
from html.parser import HTMLParser

BOOL = {'checked', 'disabled', 'selected', 'readonly', 'hidefocus', 'multiple'}


class Canon(HTMLParser):
    def __init__(self, drop):
        super().__init__(convert_charrefs=True)
        self.out, self.drop = [], drop

    def attrs(self, attrs):
        res = []
        for k, v in attrs:
            if k in self.drop:
                continue
            v = '' if v is None or k in BOOL else v
            if k == 'class':
                v = ' '.join(sorted(v.split()))
            if k == 'style':
                v = ';'.join(sorted(p.strip() for p in v.split(';') if p.strip()))
            res.append(f'{k}="{v}"')
        return ' '.join(sorted(res))

    def handle_starttag(self, tag, attrs):
        self.out.append(f'<{tag} {self.attrs(attrs)}>')

    def handle_startendtag(self, tag, attrs):
        self.out.append(f'<{tag} {self.attrs(attrs)}>')

    def handle_endtag(self, tag):
        if tag not in ('input', 'img', 'br', 'hr'):
            self.out.append(f'</{tag}>')

    def handle_data(self, data):
        d = re.sub(r'\s+', ' ', data).strip()
        if d:
            self.out.append(d)


def canon(html, drop):
    p = Canon(drop)
    p.feed(html or '')
    return ''.join(p.out)


def boxes(entries):
    out = []
    for e in entries or []:
        tag_cls, rect = e.rsplit(' ', 1)
        x, y, w, h = [float(v) for v in rect.split(',')]
        if w or h:
            out.append(tag_cls.split('.')[0] + ' ' + rect)
    return out


mode = sys.argv[1]
a = json.load(open(sys.argv[2], encoding='utf-8'))
b = json.load(open(sys.argv[3], encoding='utf-8'))
same, different = 0, 0

if mode == 'markup':
    drop = set(sys.argv[4].split(',')) if len(sys.argv) > 4 else set()
    for k in sorted(set(a['markup']) | set(b['markup'])):
        x, y = canon(a['markup'].get(k), drop), canon(b['markup'].get(k), drop)
        if x == y:
            same += 1
            continue
        different += 1
        i = next((i for i in range(min(len(x), len(y))) if x[i] != y[i]), min(len(x), len(y)))
        print('##', k)
        print('  old:', x[max(0, i - 150):i + 250])
        print('  new:', y[max(0, i - 150):i + 250])
else:
    for k in sorted(set(a['layout']) | set(b['layout'])):
        x, y = boxes(a['layout'].get(k)), boxes(b['layout'].get(k))
        if x == y:
            same += 1
            continue
        different += 1
        print('##', k)
        for line in difflib.unified_diff(x, y, lineterm='', n=0):
            if not line.startswith(('---', '+++', '@@')):
                print('   ', line)

print(f'identical: {same}, different: {different}')
