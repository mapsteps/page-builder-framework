/**
 * Customizer browser check (dev only, never shipped).
 *
 * Opens the Customizer in headless Chrome with a temporary admin login, expands every section,
 * and reports per control type how many controls rendered, plus any JavaScript errors and failed requests.
 * Nothing is saved.
 *
 *     node bin/snapshot/customizer-check.mjs > before.json
 *     node bin/snapshot/customizer-check.mjs > after.json
 */
import { spawn, execFileSync } from "node:child_process";
import { copyFileSync, mkdtempSync, rmSync } from "node:fs";
import { tmpdir } from "node:os";
import { join, dirname } from "node:path";
import { fileURLToPath } from "node:url";

const here = dirname(fileURLToPath(import.meta.url));
const wpRoot = join(here, "..", "..", "..", "..", "..");
const php = ["-d", "extension=mysqli", "-d", "mysqli.default_port=10035"];
const chromePath = "C:/Program Files/Google/Chrome/Application/chrome.exe";
const port = 9333;

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
	await send("Runtime.enable");
	await send("Fetch.enable", { patterns: [{ urlPattern: "*admin-ajax.php*", requestStage: "Request" }] });
	for (const pair of cookieHeader.split("; ")) {
		const [name, ...rest] = pair.split("=");
		await send("Network.setCookie", { name, value: decodeURIComponent(rest.join("=")), domain: "pbf.local", path: "/" });
	}
	await send("Page.enable");
	await send("Page.navigate", { url: "http://pbf.local/wp-admin/customize.php?zz_nolock=1" });

	// Wait until the Customizer is ready.
	for (let i = 0; i < 100; i++) {
		await sleep(300);
		if (await evaluate("!!(window.wp && wp.customize && wp.customize.state && wp.customize.state('processing') && document.body && document.body.classList.contains('ready'))")) break;
	}

	const result = await evaluate(`(async () => {
		const sleep = (ms) => new Promise((r) => setTimeout(r, ms));
		const sections = [];
		wp.customize.section.each((s) => sections.push(s));
		for (const s of sections) { s.expand({ duration: 0 }); await sleep(120); }
		await sleep(1500);
		const byType = {};
		const empty = [];
		const markup = {};
		wp.customize.control.each((c) => {
			const t = c.params.type;
			byType[t] = byType[t] || { total: 0, rendered: 0 };
			byType[t].total++;
			const el = c.container && c.container[0];
			const hasContent = el && el.innerHTML.trim().length > 0 && el.querySelectorAll('*').length > 0;
			if (hasContent) byType[t].rendered++; else empty.push(c.id);
			// Rendered markup per control (whitespace collapsed), to compare two runs.
			if (el && t && 0 === t.indexOf('wpbf-')) markup[c.id] = el.innerHTML.replace(/\\s+/g, ' ').trim();
		});

		// Round trips on the React and select controls: a value set on the setting must show up in the control, and back.
		const roundTrips = {};
		const firstOf = (type) => { let found; wp.customize.control.each((c) => { if (!found && c.params.type === type) found = c; }); return found; };
		const tries = {
			'wpbf-color': '#123456',
			'wpbf-slider': 7,
			'wpbf-input-slider': '13px',
			'wpbf-select': null,
			'wpbf-toggle': null,
			'wpbf-generic': null,
		};
		for (const [type, value] of Object.entries(tries)) {
			const control = firstOf(type);
			if (!control) { roundTrips[type] = 'no control'; continue; }
			const setting = control.setting;
			const original = setting.get();
			let next = value;
			if (type === 'wpbf-select') next = Object.keys(control.params.choices || {}).find((k) => k !== original) ?? original;
			if (type === 'wpbf-toggle') next = !original;
			if (type === 'wpbf-generic') next = 'zz-test';
			setting.set(next);
			await sleep(400);
			const html = control.container[0].innerHTML;
			const inputs = [...control.container[0].querySelectorAll('input, select, textarea')].map((i) => i.type === 'checkbox' ? String(i.checked) : i.value);
			const shown = inputs.some((v) => String(v).toLowerCase().includes(String(next).toLowerCase().replace(/px$/, ''))) || html.toLowerCase().includes(String(next).toLowerCase());
			setting.set(original);
			await sleep(200);
			roundTrips[type] = { id: control.id, setTo: next, shownInControl: shown, restored: JSON.stringify(setting.get()) === JSON.stringify(original) };
		}

		return {
			sections: sections.length,
			controls: Object.values(byType).reduce((a, b) => a + b.total, 0),
			byType,
			emptyControls: empty.slice(0, 30),
			reactColorPickers: document.querySelectorAll('.react-colorful').length,
			select2: document.querySelectorAll('.select2-container').length,
			sliders: document.querySelectorAll('input[type=range]').length,
			roundTrips,
			unsavedChanges: Object.keys(wp.customize.dirtyValues ? wp.customize.dirtyValues({ unsaved: true }) : {}).length,
			markup,
		};
	})()`);
	report = { ...result, jsErrors: [...new Set(errors)], failedRequests: [...new Set(failed)], blockedRequests: blocked };
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
