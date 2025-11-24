import { execSync } from "child_process";
import { readdirSync, existsSync } from "fs";
import { resolve } from "path";
import { getErrorMessage } from "./build-utils.mjs";

const controlsDir = resolve(process.cwd(), "Customizer/Controls");

if (!existsSync(controlsDir)) {
	console.error("Controls directory not found:", controlsDir);
	process.exit(1);
}

const controlDirs = readdirSync(controlsDir, { withFileTypes: true })
	.filter((dirent) => dirent.isDirectory())
	.map((dirent) => dirent.name);

const validControls = [];

for (const controlDir of controlDirs) {
	const srcDir = resolve(controlsDir, controlDir, "src");
	if (!existsSync(srcDir)) continue;

	const files = readdirSync(srcDir);
	const hasControlFile = files.some(
		(file) => file.endsWith("-control.ts") || file.endsWith("-control.tsx"),
	);

	if (hasControlFile) {
		validControls.push(controlDir);
	}
}

if (validControls.length === 0) {
	console.log("No valid controls found");
	process.exit(0);
}

console.log(`Found ${validControls.length} controls:`);
validControls.forEach((control) => console.log(`  - ${control}`));

for (const control of validControls) {
	console.log(`\nBuilding ${control}...`);
	try {
		execSync(`pnpm build-control --name=${control}`, {
			stdio: "inherit",
			cwd: process.cwd(),
		});
		console.log(`✅ ${control} built successfully`);
	} catch (error) {
		console.error(`❌ Failed to build ${control}:`, getErrorMessage(error));
		// Don't exit process, try building other controls
	}
}

console.log("\n🎉 All controls build process completed!");
