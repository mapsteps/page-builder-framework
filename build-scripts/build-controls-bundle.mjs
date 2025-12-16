import { execSync } from "child_process";
import { resolve } from "path";
import { getErrorMessage } from "./build-utils.mjs";

const bundleSrcDir = resolve(process.cwd(), "Customizer/Controls/Bundle/src");
const bundleDistDir = resolve(process.cwd(), "Customizer/Controls/Bundle/dist");

const entries = [
	{
		name: "controls-bundle",
		path: resolve(bundleSrcDir, "controls-bundle.ts"),
	},
	{
		name: "controls-preview-bundle",
		path: resolve(bundleSrcDir, "controls-preview-bundle.ts"),
	},
];

console.log("Building customizer controls bundle...\n");

for (const entry of entries) {
	console.log(`Building ${entry.name}...`);
	try {
		execSync("vite build", {
			stdio: "inherit",
			env: {
				...process.env,
				ENTRY_PATH: entry.path,
				OUTPUT_DIR: bundleDistDir,
			},
		});
		console.log(`✅ ${entry.name} built successfully\n`);
	} catch (error) {
		console.error(`❌ Failed to build ${entry.name}:`, getErrorMessage(error));
		process.exit(1);
	}
}

console.log("🎉 Controls bundle build completed!");
