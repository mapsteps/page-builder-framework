/**
 * Build the Customizer scripts and styles (dev only, never shipped).
 *
 *     pnpm build                      Build into Customizer/dist/.
 *     pnpm build -- --out=<folder>    Build into <folder>/Customizer/dist/ instead, e.g. to compare.
 *
 * One entry, Customizer/src/customizer-controls.ts, imports every control, panel and section type and their styles:
 * the result is one script and one stylesheet (customizer-controls-min.js / .css). A new control is added there.
 *
 * The dist/ folder only ever holds built files: it's emptied before it's rebuilt.
 */
import { build } from "vite";
import { rmSync, mkdirSync } from "node:fs";
import { dirname, join, relative, resolve } from "node:path";
import { fileURLToPath } from "node:url";
import { getViteConfig } from "./build-utils.mjs";

const root = resolve(dirname(fileURLToPath(import.meta.url)), "..");
const outArg = process.argv.find((arg) => arg.startsWith("--out="));
const outRoot = outArg ? resolve(root, outArg.slice("--out=".length)) : root;

process.env.NODE_ENV = "production";

const entry = join(root, "Customizer/src/customizer-controls.ts");
const distDir = join(outRoot, "Customizer/dist");

rmSync(distDir, { recursive: true, force: true });
mkdirSync(distDir, { recursive: true });

const config = getViteConfig(entry, distDir);

await build({ ...config, configFile: false, root, logLevel: "warn", build: { ...config.build, sourcemap: false } });

console.log(`✓ ${relative(root, distDir)}: ${relative(root, entry)}`);
