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
import { mkdtempSync, rmSync } from "node:fs";
import { tmpdir } from "node:os";
import { join, dirname } from "node:path";
import { fileURLToPath } from "node:url";

const here = dirname(fileURLToPath(import.meta.url));
const wpRoot = join(here, "..", "..", "..", "..", "..");
const php = ["-d", "extension=mysqli", "-d", "mysqli.default_port=10035"];
const chromePath = "C:/Program Files/Google/Chrome/Application/chrome.exe";
const port = 9333;

const [cookieHeader, token] = execFileSync("php", [...php, join(here, "login.php"), wpRoot, "create"], { encoding: "utf8" }).trim().split("\n");
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
	if (msg.method === "Network.loadingFailed" && !msg.params.canceled) failed.push(`failed ${msg.params.errorText}`);
});
const send = (method, params = {}) => new Promise((r) => { const i = ++id; pending.set(i, r); ws.send(JSON.stringify({ id: i, method, params })); });
const evaluate = async (expression) => (await send("Runtime.evaluate", { expression, awaitPromise: true, returnByValue: true })).result?.result?.value;

try {
	await send("Network.enable");
	await send("Runtime.enable");
	for (const pair of cookieHeader.split("; ")) {
		const [name, ...rest] = pair.split("=");
		await send("Network.setCookie", { name, value: decodeURIComponent(rest.join("=")), domain: "pbf.local", path: "/" });
	}
	await send("Page.enable");
	await send("Page.navigate", { url: "http://pbf.local/wp-admin/customize.php" });

	// Wait until the Customizer is ready.
	for (let i = 0; i < 100; i++) {
		await sleep(300);
		if (await evaluate("!!(window.wp && wp.customize && wp.customize.state && wp.customize.state('processing') && document.body.classList.contains('ready'))")) break;
	}

	const result = await evaluate(`(async () => {
		const sleep = (ms) => new Promise((r) => setTimeout(r, ms));
		const sections = [];
		wp.customize.section.each((s) => sections.push(s));
		for (const s of sections) { s.expand({ duration: 0 }); await sleep(120); }
		await sleep(1500);
		const byType = {};
		const empty = [];
		wp.customize.control.each((c) => {
			const t = c.params.type;
			byType[t] = byType[t] || { total: 0, rendered: 0 };
			byType[t].total++;
			const el = c.container && c.container[0];
			const hasContent = el && el.innerHTML.trim().length > 0 && el.querySelectorAll('*').length > 0;
			if (hasContent) byType[t].rendered++; else empty.push(c.id);
		});
		return {
			sections: sections.length,
			controls: Object.values(byType).reduce((a, b) => a + b.total, 0),
			byType,
			emptyControls: empty.slice(0, 30),
			reactColorPickers: document.querySelectorAll('.react-colorful').length,
			select2: document.querySelectorAll('.select2-container').length,
			sliders: document.querySelectorAll('input[type=range]').length,
		};
	})()`);
	console.log(JSON.stringify({ ...result, jsErrors: [...new Set(errors)], failedRequests: [...new Set(failed)] }, null, 1));
} finally {
	ws.close();
	chrome.kill();
	await sleep(500);
	try { rmSync(profile, { recursive: true, force: true }); } catch {}
	execFileSync("php", [...php, join(here, "login.php"), wpRoot, "destroy", token]);
}
