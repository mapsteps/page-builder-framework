/**
 * Customizer browser check (dev only, never shipped).
 *
 * Opens the Customizer in headless Chrome with a temporary admin login, expands every section,
 * and reports per control type how many controls rendered, plus any JavaScript errors and failed requests.
 *
 * previewCss: sets options in the Customizer (each value of the snapshot's general1 and footer1 variants on its own,
 * then the general1-4 and footer1-5 variants whole), waits for the preview, and compares the preview's CSS of each area written with
 * wpbf_css() with what the front end prints for the same values (cleaned like the Customizer cleans them). The whole
 * run uses Premium breakpoints of 1100/700/400px. "matched" must equal "cases".
 *
 * Nothing is saved: save, autosave, trash and dismiss requests are blocked; databaseUnchanged proves it.
 *
 *     node bin/snapshot/customizer-check.mjs > before.json
 *     node bin/snapshot/customizer-check.mjs > after.json
 *
 * --timing=N opens the Customizer N times for the load figures; --layout adds every control's rendered boxes.
 */
import { spawn, execFileSync } from "node:child_process";
import { copyFileSync, mkdtempSync, readFileSync, rmSync } from "node:fs";
import { tmpdir } from "node:os";
import { join, dirname } from "node:path";
import { fileURLToPath } from "node:url";

const here = dirname(fileURLToPath(import.meta.url));
const wpRoot = join(here, "..", "..", "..", "..", "..");
const php = ["-d", "extension=mysqli", "-d", "mysqli.default_port=10035"];
const chromePath = "C:/Program Files/Google/Chrome/Application/chrome.exe";
const port = 9333;

// Areas written with wpbf_css() (CssRules::AREAS) and their hand-made variants of the page snapshots
// (bin/snapshot/output/variants.json, made by snapshot.py; named after the area: general1, footer1, ...).
const cssAreas = ["general", "footer"];
let previewVariants = {};
try {
	const all = JSON.parse(readFileSync(join(here, "output", "variants.json"), "utf8"));
	for (const [name, values] of Object.entries(all)) {
		if (!cssAreas.some((area) => new RegExp("^" + area + "\\d+$").test(name))) continue;
		// Saved values no control can produce (0 on sliders with a minimum of 1): set from code, the instant preview
		// gets them raw while the front-end side here cleans them to the minimum. As saved values (the only way
		// they occur) preview and front end both skip them; the page snapshot covers that.
		if ("footer4" === name) continue;
		const { __wpbf_settings, ...mods } = values;
		previewVariants[name] = mods;
	}
} catch {
	console.error("No bin/snapshot/output/variants.json (run snapshot.py take first): preview CSS check uses the saved values only.");
}

const dbState = () => execFileSync("php", [...php, join(here, "login.php"), wpRoot, "dbstate"], { encoding: "utf8" }).trim();
const dbBefore = dbState();
const [cookieHeader, token] = execFileSync("php", [...php, join(here, "login.php"), wpRoot, "create"], { encoding: "utf8" }).trim().split("\n");

// The snapshot mu-plugin (with ?zz_nolock=1) keeps the Customizer from locking or dismissing drafts on load.
const muPlugin = join(wpRoot, "wp-content", "mu-plugins", "zz-test-snapshot.php");
copyFileSync(join(here, "mu-plugin.php"), muPlugin);
const profile = mkdtempSync(join(tmpdir(), "wpbf-check-"));
const chrome = spawn(chromePath, ["--headless=new", `--remote-debugging-port=${port}`, `--user-data-dir=${profile}`, "--window-size=1400,1000", "about:blank"], { stdio: "ignore" });

const sleep = (ms) => new Promise((r) => setTimeout(r, ms));
let target;
for (let i = 0; i < 50 && !target; i++) {
	await sleep(200);
	try {
		target = (await (await fetch(`http://127.0.0.1:${port}/json/list`)).json()).find((t) => t.type === "page");
	} catch {}
}

const ws = new WebSocket(target.webSocketDebuggerUrl);
await new Promise((r) => ws.addEventListener("open", r));
let id = 0;
const pending = new Map();
const errors = [];
const failed = [];
ws.addEventListener("message", (e) => {
	const msg = JSON.parse(e.data);
	if (msg.id && pending.has(msg.id)) {
		pending.get(msg.id)(msg);
		pending.delete(msg.id);
	}
	if (msg.method === "Runtime.exceptionThrown") errors.push(msg.params.exceptionDetails.exception?.description?.split("\n")[0] || msg.params.exceptionDetails.text);
	if (msg.method === "Runtime.consoleAPICalled" && msg.params.type === "error") errors.push(msg.params.args.map((a) => a.value ?? a.description).join(" ").slice(0, 300));
	if (msg.method === "Network.responseReceived" && msg.params.response.status >= 400) failed.push(`${msg.params.response.status} ${msg.params.response.url}`);
	if (msg.method === "Network.loadingFailed" && !msg.params.canceled && !String(msg.params.errorText).includes("BLOCKED_BY_CLIENT")) failed.push(`failed ${msg.params.errorText}`);

	// Nothing may be saved: block the Customizer's save, autosave, trash and dismiss requests.
	if (msg.method === "Fetch.requestPaused") {
		const request = msg.params.request;
		const body = request.postData || "";
		if ("POST" === request.method && /(^|&)action=customize_(save|dismiss_autosave_or_lock|trash)\b/.test(body)) {
			blocked.push(body.match(/action=([a-z_]+)/)[1]);
			send("Fetch.failRequest", { requestId: msg.params.requestId, errorReason: "BlockedByClient" });
		} else {
			send("Fetch.continueRequest", { requestId: msg.params.requestId });
		}
	}
});
const blocked = [];
const send = (method, params = {}) => new Promise((r) => { const i = ++id; pending.set(i, r); ws.send(JSON.stringify({ id: i, method, params })); });
const evaluate = async (expression) => {
	const response = await send("Runtime.evaluate", { expression, awaitPromise: true, returnByValue: true });
	if (response.error || response.result?.exceptionDetails) {
		errors.push("check script: " + JSON.stringify(response.error || response.result.exceptionDetails.exception?.description || response.result.exceptionDetails.text).slice(0, 500));
	}
	return response.result?.result?.value;
};

let report = {};
try {
	await send("Network.enable");
	// Every open is a first visit: sizes and times include every file.
	await send("Network.setCacheDisabled", { cacheDisabled: true });
	await send("Runtime.enable");
	await send("Fetch.enable", { patterns: [{ urlPattern: "*admin-ajax.php*", requestStage: "Request" }] });
	for (const pair of cookieHeader.split("; ")) {
		const [name, ...rest] = pair.split("=");
		await send("Network.setCookie", { name, value: decodeURIComponent(rest.join("=")), domain: "pbf.local", path: "/" });
	}
	// Premium breakpoints that differ from the defaults for every request of the run (see mu-plugin.php).
	await send("Network.setCookie", { name: "zz_breakpoints", value: "1", domain: "pbf.local", path: "/" });
	await send("Page.enable");
	// When the Customizer is ready to use (core adds "ready" to the body once every control is set up). The resource list
	// is enlarged: the Customizer loads more than the browser's default 250 files, and the theme's files come late.
	await send("Page.addScriptToEvaluateOnNewDocument", {
		source: `performance.setResourceTimingBufferSize(5000); new MutationObserver((list, observer) => { if (document.body && document.body.classList.contains('ready')) { window.__zzReadyMs = Math.round(performance.now()); observer.disconnect(); } }).observe(document, { subtree: true, attributes: true, attributeFilter: ['class'] });`,
	});

	// Open the Customizer and wait until it's ready; returns the load cost of the page itself: theme script and style
	// files, their size, and how long until DOMContentLoaded / load. --timing=N opens it N times and reports medians.
	const open = async () => {
		await send("Page.navigate", { url: "http://pbf.local/wp-admin/customize.php?zz_nolock=1" });
		await sleep(300);
		for (let i = 0; i < 100; i++) {
			await sleep(300);
			if (await evaluate("!!(window.wp && wp.customize && wp.customize.state && wp.customize.state('processing') && document.body && document.body.classList.contains('ready') && 'complete' === document.readyState)")) break;
		}
		// Let the preview finish loading too: Local serves one PHP request at a time, so a preview still loading would
		// hold up the next open's page (and its times) with --timing.
		for (let i = 0; i < 100; i++) {
			if (await evaluate("(() => { try { const w = wp.customize.previewer.preview && wp.customize.previewer.preview.targetWindow(); return !!w && 'complete' === w.document.readyState && !wp.customize.previewer.loading; } catch (e) { return false; } })()")) break;
			await sleep(300);
		}
		return await evaluate(`(() => {
			const nav = performance.getEntriesByType('navigation')[0];
			const all = performance.getEntriesByType('resource');
			const theme = all.filter((r) => r.name.includes('/themes/page-builder-framework/') && /\\.(js|css)(\\?|$)/.test(r.name));
			const kb = (bytes) => Math.round(bytes / 102.4) / 10;
			const sum = (list) => list.reduce((a, r) => a + r.decodedBodySize, 0);
			return {
				themeScripts: theme.filter((r) => /\\.js(\\?|$)/.test(r.name)).length,
				themeStyles: theme.filter((r) => /\\.css(\\?|$)/.test(r.name)).length,
				themeKB: kb(sum(theme)),
				htmlKB: kb(nav.decodedBodySize),
				totalKB: kb(sum(all) + nav.decodedBodySize),
				responseEndMs: Math.round(nav.responseEnd),
				domInteractiveMs: Math.round(nav.domInteractive),
				domContentLoadedStartMs: Math.round(nav.domContentLoadedEventStart),
				domContentLoadedMs: Math.round(nav.domContentLoadedEventEnd),
				loadMs: Math.round(nav.loadEventEnd),
				readyMs: window.__zzReadyMs || null,
				...(${process.argv.includes("--resources")} ? { resources: all.map((r) => [r.name.replace(location.origin, ''), r.decodedBodySize]) } : {}),
			};
		})()`);
	};
	const timingRuns = Math.max(1, parseInt((process.argv.find((a) => a.startsWith("--timing=")) || "--timing=1").slice(9), 10) || 1);
	const loads = [];
	for (let i = 0; i < timingRuns; i++) {
		const metrics = await open();
		if (!metrics) throw new Error("No load metrics: " + errors.join(" | "));
		loads.push(metrics);
	}
	const median = (key) => { const v = loads.map((l) => l[key]).sort((a, b) => a - b); return v[Math.floor(v.length / 2)]; };
	const load = { ...loads[loads.length - 1], runs: timingRuns, responseEndMs: median("responseEndMs"), domInteractiveMs: median("domInteractiveMs"), domContentLoadedStartMs: median("domContentLoadedStartMs"), domContentLoadedMs: median("domContentLoadedMs"), loadMs: median("loadMs"), readyMs: median("readyMs") };

	const result = await evaluate(`(async () => {
		const sleep = (ms) => new Promise((r) => setTimeout(r, ms));
		// Settings changed just by opening the Customizer (a control writing its setting on load).
		const changedOnLoad = Object.keys(wp.customize.dirtyValues ? wp.customize.dirtyValues({ unsaved: true }) : {});
		const savedOnLoad = wp.customize.state('saved').get();
		const sections = [];
		wp.customize.section.each((s) => sections.push(s));
		// --layout: each control's rendered boxes (every element's position and size inside the control, while its section is
		// open), to compare two runs: a change in markup that moves anything shows up here.
		const layout = {};
		const measure = (s) => s.controls().forEach((c) => {
			const el = c.container && c.container[0];
			if (!el || !c.params.type || 0 !== c.params.type.indexOf('wpbf-') || !el.offsetParent) return;
			const box = el.getBoundingClientRect();
			const r = (n) => Math.round(n * 10) / 10;
			layout[c.id] = [el, ...el.querySelectorAll('*')].filter((n) => !n.closest('.mce-tinymce, .tooltip-content')).map((n) => {
				const b = n.getBoundingClientRect();
				return n.tagName.toLowerCase() + (n.className && 'string' === typeof n.className ? '.' + n.className.trim().split(/\\s+/).sort().join('.') : '') + ' ' + [r(b.left - box.left), r(b.top - box.top), r(b.width), r(b.height)].join(',');
			});
		});
		for (const s of sections) { s.expand({ duration: 0 }); await sleep(120); if (${process.argv.includes("--layout")}) { await sleep(200); measure(s); } }
		await sleep(1500);
		const byType = {};
		const empty = [];
		const markup = {};
		// 7d: what a select shows (select2 before, the select form after): the text of the chosen option, or the list of
		// chosen options of a multiple select.
		const selectShown = (c) => {
			const el = c.container[0];
			const text = (n) => (n.getAttribute('title') || n.textContent).replace(/\\u00d7/g, '').trim();
			if (c.params.isMulti) return [...el.querySelectorAll('.select2-selection__choice, .wpbf-select-chip')].map(text);
			const one = el.querySelector('.select2-selection__rendered, .wpbf-select-value');
			return one ? text(one) : null;
		};
		const selects = {};
		wp.customize.control.each((c) => {
			const t = c.params.type;
			byType[t] = byType[t] || { total: 0, rendered: 0 };
			byType[t].total++;
			const el = c.container && c.container[0];
			const hasContent = el && el.innerHTML.trim().length > 0 && el.querySelectorAll('*').length > 0;
			if (hasContent) byType[t].rendered++; else empty.push(c.id);
			// Rendered markup per control (whitespace and select2's random ids collapsed), to compare two runs.
			if (el && t && 0 === t.indexOf('wpbf-')) markup[c.id] = el.innerHTML.replace(/\\s+/g, ' ').replace(/select2-data-\\d+-\\w+/g, 'select2-data').replace(/select2-\\w+-(container|results)/g, 'select2-$1').replace(/choice-\\w{4}-/g, 'choice-').trim();
			if ('wpbf-select' === t) selects[c.id] = { value: c.setting ? c.setting.get() : null, shown: selectShown(c), active: c.active() };
		});

		// Round trips on the React, select and 7b controls: a value set on the setting must show up in the control, and back.
		const roundTrips = {};
		const firstOf = (type) => { let found; wp.customize.control.each((c) => { if (!found && c.params.type === type) found = c; }); return found; };
		const tries = {
			'wpbf-color': '#123456',
			'wpbf-slider': 7,
			'wpbf-input-slider': '13px',
			'wpbf-responsive-input-slider': null,
			'wpbf-select': null,
			'wpbf-toggle': null,
			'wpbf-generic': null,
			'wpbf-checkbox': null,
			'wpbf-radio': null,
			'wpbf-radio-buttonset': null,
			'wpbf-radio-image': null,
			'wpbf-responsive-generic': null,
			'wpbf-dimension': '37px',
			'wpbf-margin-padding': null,
			'wpbf-responsive-margin-padding': null,
			'wpbf-image': null,
			'wpbf-editor': '<p>zz-test</p>',
			'wpbf-assoc-array': null,
			'wpbf-repeater': null,
			// 7c: color variants of the zz-test fields (when they're there): value set, what the control shows.
			'zz_test_color_alpha': ['rgba(1, 2, 3, 0.4)', 'rgba(1, 2, 3, 0.4)'],
			'zz_test_color_transparent': ['rgba(0, 0, 0, 0)', 'rgba(0, 0, 0, 0)'],
			'zz_test_color_hue': [200, '200'],
			'zz_test_color_hsla': ['hsla(10, 20%, 30%, 0.5)', 'hsla(10, 20%, 30%, 0.5)'],
			'zz_test_color_rgba_object': [{ r: 9, g: 8, b: 7, a: 0.5 }, 'rgba(9, 8, 7, 0.5)'],
		};
		for (const [type, value] of Object.entries(tries)) {
			const byId = 0 === type.indexOf('zz_test_');
			const control = byId ? wp.customize.control(type) : firstOf(type);
			if (byId && !control) continue;
			if (!control) { roundTrips[type] = 'no control'; continue; }
			const setting = control.setting;
			const original = setting.get();
			let next = value;
			if (type.startsWith('wpbf-radio')) next = Object.keys(control.params.choices || {}).find((k) => k !== original) ?? original;
			// Selects have their choices as a list of { id, text } (and groups of them).
			if (type === 'wpbf-select') next = (control.params.choices || []).flatMap((ch) => ch.children ? ch.children : [ch]).map((ch) => String(ch.id)).find((k) => k !== original) ?? original;
			if (type === 'wpbf-toggle' || type === 'wpbf-checkbox') next = !original;
			if (type === 'wpbf-generic') next = 'zz-test';
			// A value inside the slider's range (one outside shows as the limit).
			if (type === 'wpbf-slider') next = Math.min(control.params.max, control.params.min + 7 * control.params.step);
			// Responsive sliders: 17 on the first device, in the format the setting uses (JSON text or object).
			let look = next;
			if (type === 'wpbf-responsive-input-slider') {
				const parsed = 'string' === typeof original ? JSON.parse(original || '{}') : { ...original };
				parsed[control.params.devices[0]] = '17';
				next = 'string' === typeof original ? JSON.stringify(parsed) : parsed;
				look = '17';
			}
			// Responsive generic: 17 on the first device; margin/padding: 23 on the first side (same format as the setting).
			if (type === 'wpbf-responsive-generic' || type.endsWith('margin-padding')) {
				const parsed = 'string' === typeof original ? JSON.parse(original || '{}') : { ...original };
				const key = type === 'wpbf-responsive-generic' ? control.params.devices[0] : control.params.dimensions[0];
				look = type === 'wpbf-responsive-generic' ? '17' : '23';
				parsed[key] = 'string' === typeof original || control.params.dontSaveUnit ? look : look + control.params.unit;
				next = 'string' === typeof original ? JSON.stringify(parsed) : parsed;
			}
			// Image: an image of the theme, as a URL (or in the format the setting uses).
			if (type === 'wpbf-image') {
				look = '/inc/customizer/img/align-left.jpg';
				const url = location.origin + '/wp-content/themes/page-builder-framework' + look;
				next = 'array' === control.params.saveAs ? { id: 0, url, width: 0, height: 0 } : url;
			}
			if (type === 'wpbf-editor') look = 'zz-test';
			if (byId) [next, look] = value;
			// Typography (the assoc-array holds the whole value): another font family; the control shows it.
			if (type === 'wpbf-assoc-array') {
				next = { ...original, 'font-family': 'zz-test' };
				look = 'zz-test';
			}
			// Repeater: the first row's first text field changed, in the format the setting uses (URI-encoded JSON text).
			if (type === 'wpbf-repeater') {
				const rows = 'string' === typeof original ? JSON.parse(decodeURI(original || '[]')) : JSON.parse(JSON.stringify(original || []));
				const textField = Object.keys(control.params.fields).find((f) => 'text' === control.params.fields[f].type);
				if (!rows.length) rows.push({});
				rows[0][textField] = 'zz-test';
				next = encodeURI(JSON.stringify(rows));
				look = 'zz-test';
			}
			setting.set(next);
			await sleep(400);
			// The repeater's rows only (its hidden input holds the setting's text).
			const scope = type === 'wpbf-repeater' ? control.container[0].querySelector('.repeater-fields') : control.container[0];
			const html = scope.innerHTML;
			const inputs = [...scope.querySelectorAll('input, select, textarea')].map((i) => i.type === 'checkbox' ? String(i.checked) : i.type === 'radio' ? (i.checked ? i.value : '') : i.value);
			// Selects: the chosen option's text must show (select2 kept showing the old one).
			const selectLabel = type === 'wpbf-select' ? ((control.params.choices || []).flatMap((ch) => ch.children ? ch.children : [ch]).find((ch) => String(ch.id) === String(next)) || {}).text : null;
			const shownText = type === 'wpbf-select' ? selectShown(control) : undefined;
			const shown = type === 'wpbf-select' ? selectShown(control) === selectLabel : type.startsWith('wpbf-radio') ? inputs.includes(String(look)) : inputs.some((v) => String(v).toLowerCase().includes(String(look).toLowerCase().replace(/px$/, ''))) || html.toLowerCase().includes(String(look).toLowerCase());
			setting.set(original);
			await sleep(200);
			roundTrips[type] = { id: control.id, setTo: next, shownInControl: type === 'wpbf-assoc-array' && !control.container[0].querySelector('input') ? 'n/a (7d: the hidden label control shows no value)' : shown, ...(type === 'wpbf-select' ? { shownText } : {}), restored: JSON.stringify(setting.get()) === JSON.stringify(original) };
		}

		// 7d: typography font family / variant changes, one after the other: the typography value composed from them, and
		// the variant select's options, shown variant and visibility (to compare select2 and the select form).
		const typographySteps = {};
		for (const tid of ['page_font_family', 'menu_font_family', 'zz_test_typography']) {
			const fam = wp.customize(tid + '[font-family]'), vari = wp.customize(tid + '[variant]'), typo = wp.customize(tid);
			const vc = wp.customize.control(tid + '[variant]');
			if (!fam || !vari || !typo || !vc) continue;
			const original = { fam: fam.get(), vari: vari.get(), typo: typo.get() };
			const variantChoices = () => vc.choicesValue ? vc.choicesValue.get().map((c) => String(c.id)) : [...vc.container[0].querySelectorAll('select option')].map((o) => o.value);
			const steps = [['fam', 'Roboto'], ['vari', '700italic'], ['vari', '300'], ['fam', 'Helvetica, Arial, sans-serif'], ['vari', 'italic'], ['fam', 'Open Sans'], ['fam', 'zz-unknown-font'], ['vari', '900'], ['fam', 'Inter']];
			const out = [{ step: 'open', typo: typo.get(), variantActive: vc.active(), variantShown: selectShown(vc), variantChoices: variantChoices() }];
			for (const [which, v] of steps) {
				('fam' === which ? fam : vari).set(v);
				await sleep(200);
				out.push({ step: which + '=' + v, typo: typo.get(), variantActive: vc.active(), variantShown: selectShown(vc), variantChoices: variantChoices() });
			}
			fam.set(original.fam); vari.set(original.vari); typo.set(original.typo);
			await sleep(200);
			typographySteps[tid] = out;
		}

		// Preview CSS: set options in the Customizer, wait for the preview, and compare the preview's CSS of each area
		// written with wpbf_css() with what the front end prints for the same values (mu-plugin, ?zz_css=1).
		const previewCss = { cases: 0, matched: 0, customBreakpointSeen: false, defaultBreakpointSeen: false, mismatches: [] };
		const target = () => wp.customize.previewer.preview && wp.customize.previewer.preview.targetWindow();
		const previewText = (area) => { const w = target(); const el = w && w.document.getElementById('wpbf-css-' + area); return el ? el.textContent : null; };
		const settle = async (area) => {
			await sleep(400);
			let last = null, same = 0;
			for (let i = 0; i < 200 && same < 2; i++) {
				await sleep(150);
				const w = target();
				const sr = w && w.wp && w.wp.customize && w.wp.customize.selectiveRefresh;
				const busy = !w || 'complete' !== w.document.readyState || !w.wpbfPreviewCss || !sr || (sr._currentRequest && 'pending' === sr._currentRequest.state()) || sr._debouncedTimeoutId || wp.customize.previewer.loading;
				const text = busy ? null : previewText(area);
				same = null !== text && text === last ? same + 1 : 0;
				last = text;
			}
			return same >= 2 ? last : null;
		};
		const compare = async (label, values) => {
			const originals = {};
			for (const [sid, v] of Object.entries(values)) {
				if (!wp.customize(sid)) continue;
				originals[sid] = wp.customize(sid).get();
				wp.customize(sid).set(v);
			}
			for (const area of cssAreas) {
				const preview = await settle(area);
				const dirty = wp.customize.dirtyValues ? wp.customize.dirtyValues() : {};
				const response = await fetch('/?zz_css=1', { method: 'POST', credentials: 'same-origin', body: JSON.stringify({ area, values: dirty, preview: preview || '' }) });
				const result = await response.json();
				previewCss.cases++;
				// The run uses Premium breakpoints of 1100/700/400px: tablet rules must use them, not 1024px.
				if (preview && preview.includes('(max-width: 1100px)')) previewCss.customBreakpointSeen = true;
				if (preview && /max-width: ?1024px/.test(preview)) previewCss.defaultBreakpointSeen = true;
				if (null !== preview && result.front === result.preview) previewCss.matched++;
				else previewCss.mismatches.push({ case: label, area, front: result.front, preview: null === preview ? '(preview did not settle)' : result.preview });
			}
			for (const [sid, v] of Object.entries(originals)) wp.customize(sid).set(v);
			for (const area of cssAreas) await settle(area);
		};
		const cssAreas = ${JSON.stringify(cssAreas)};
		const variants = ${JSON.stringify(previewVariants)};
		await compare('as saved', {});
		for (const area of cssAreas) {
			for (const [sid, v] of Object.entries(variants[area + '1'] || {})) await compare(area + '1: ' + sid, { [sid]: v });
		}
		for (const [name, values] of Object.entries(variants)) await compare(name, values);
		await compare('as saved again', {});

		return {
			previewCss,
			sections: sections.length,
			controls: Object.values(byType).reduce((a, b) => a + b.total, 0),
			byType,
			emptyControls: empty.slice(0, 30),
			reactColorPickers: document.querySelectorAll('.react-colorful').length,
			select2: document.querySelectorAll('.select2-container').length, selectForms: document.querySelectorAll('.wpbf-select').length,
			sliders: document.querySelectorAll('input[type=range]').length,
			selects,
			typographySteps,
			roundTrips,
			changedOnLoad,
			savedOnLoad,
			unsavedChanges: Object.keys(wp.customize.dirtyValues ? wp.customize.dirtyValues({ unsaved: true }) : {}).length,
			markup,
			layout,
		};
	})()`);
	report = { load, ...result, jsErrors: [...new Set(errors)], failedRequests: [...new Set(failed)], blockedRequests: blocked };
} finally {
	ws.close();
	chrome.kill();
	await sleep(500);
	try { rmSync(profile, { recursive: true, force: true }); } catch {}
	rmSync(muPlugin, { force: true });
	execFileSync("php", [...php, join(here, "login.php"), wpRoot, "destroy", token]);
}

// Proof that the run wrote nothing (or a warning: someone else may be working on the site at the same time).
const dbAfter = dbState();
report.databaseUnchanged = dbAfter === dbBefore;
if (!report.databaseUnchanged) report.databaseState = { before: dbBefore, after: dbAfter };
console.log(JSON.stringify(report, null, 1));
