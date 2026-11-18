/**
 * Build the Customizer scripts and styles (dev only, never shipped).
 *
 *     pnpm build                      Build everything into each folder's dist/.
 *     pnpm build -- --out=<folder>    Build into <folder> instead (same structure), e.g. to compare.
 *
 * Entries are found by name, so a new control needs no config:
 * - Customizer/Controls/<Name>/src/*-control.ts(x), *-preview.ts(x) → <Name>/dist/*-min.js (+ *-min.css from the SCSS it imports)
 * - Customizer/Controls/<Name>/src/*-control.scss that no script imports → <Name>/dist/*-min.css (style-only controls)
 * - Customizer/{Panels,Sections}/src/*-types.ts → {Panels,Sections}/dist/*-types-min.js (+ css)
 *
 * dist/ folders only ever hold built files: each is emptied before it's rebuilt.
 */
import { build } from "vite";
import { existsSync, readdirSync, readFileSync, rmSync, mkdirSync } from "node:fs";
import { basename, dirname, join, relative, resolve } from "node:path";
import { fileURLToPath } from "node:url";
import { getViteConfig } from "./build-utils.mjs";

const root = resolve(dirname(fileURLToPath(import.meta.url)), "..");
const outArg = process.argv.find((arg) => arg.startsWith("--out="));
const outRoot = outArg ? resolve(root, outArg.slice("--out=".length)) : root;

process.env.NODE_ENV = "production";

/**
 * Find the entry files of one src folder.
 *
 * @param {string} srcDir Absolute path of a src folder.
 * @returns {string[]} Absolute paths of its entry files.
 */
function findEntries(srcDir) {
	const files = readdirSync(srcDir);

	// Files imported by another script or stylesheet of the folder are part of that entry, not entries themselves.
	const sources = files.filter((file) => /\.(tsx?|scss)$/.test(file)).map((file) => readFileSync(join(srcDir, file), "utf8"));
	const isImported = (/** @type {string} */ file) => {
		const name = file.replace(/\.(tsx?|scss)$/, "").replace(/[-.]/g, "\\$&");
		const pattern = file.endsWith(".scss") ? `["']\\./${name}\\.scss["']` : `["']\\./${name}(\\.tsx?)?["']`;
		return sources.some((source) => new RegExp(pattern).test(source));
	};

	return files
		.filter((file) => /-(control|preview|types)\.tsx?$/.test(file) || /-control\.scss$/.test(file))
		.filter((file) => !isImported(file))
		.map((file) => join(srcDir, file));
}

const srcDirs = [
	...readdirSync(join(root, "Customizer/Controls")).map((name) => join(root, "Customizer/Controls", name, "src")),
	join(root, "Customizer/Panels/src"),
	join(root, "Customizer/Sections/src"),
].filter((dir) => existsSync(dir));

let count = 0;

for (const srcDir of srcDirs) {
	const entries = findEntries(srcDir);

	if (!entries.length) {
		continue;
	}

	const distDir = join(outRoot, relative(root, dirname(srcDir)), "dist");

	rmSync(distDir, { recursive: true, force: true });
	mkdirSync(distDir, { recursive: true });

	// One build per entry: Rollup can't inline dynamic imports for several inputs at once.
	for (const entry of entries) {
		const config = getViteConfig(entry, distDir);

		await build({ ...config, configFile: false, root, logLevel: "warn", build: { ...config.build, sourcemap: false } });
		count++;

		// A style-only entry leaves an empty script behind.
		if (entry.endsWith(".scss")) {
			rmSync(join(distDir, basename(entry, ".scss") + "-min.js"), { force: true });
		}
	}

	console.log(`✓ ${relative(root, distDir)}: ${entries.map((entry) => relative(srcDir, entry)).join(", ")}`);
}

console.log(`Built ${count} entries.`);
