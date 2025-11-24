import { defineConfig } from "vite";
import { getViteConfig } from "./build-scripts/build-utils.mjs";

export default defineConfig(() => {
	const entry = process.env.ENTRY_PATH;
	const outDir = process.env.OUTPUT_DIR;

	if (!entry || !outDir) {
		throw new Error("ENTRY_PATH and OUTPUT_DIR env vars are required.");
	}

	return getViteConfig(entry, outDir, false);
});
