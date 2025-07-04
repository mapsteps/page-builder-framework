import { execSync } from "child_process";
import { readdirSync, existsSync } from "fs";
import { resolve } from "path";
import { getErrorMessage } from "./build-utils.mjs";

const controlsDir = resolve(process.cwd(), "Customizer/Controls");

if (!existsSync(controlsDir)) {
	console.error("Controls directory not found:", controlsDir);
	process.exit(1);
}

// Group control files by their base name
const controlGroups = new Map();
const controlDirs = readdirSync(controlsDir, { withFileTypes: true })
	.filter((dirent) => dirent.isDirectory())
	.map((dirent) => dirent.name);

for (const controlDir of controlDirs) {
	const srcDir = resolve(controlsDir, controlDir, "src");
	if (!existsSync(srcDir)) continue;

	const files = readdirSync(srcDir);
	const controlFiles = files.filter(
		(file) => file.endsWith("-control.ts") || file.endsWith("-control.tsx"),
	);

	if (controlFiles.length === 0) continue;

	// Group files by their base name pattern
	const groups = new Map();

	for (const controlFile of controlFiles) {
		// Extract potential base names
		const fileName = controlFile.replace(/-control\.tsx?$/, "");

		// Try to find common base names
		const parts = fileName.split("-");
		let baseName = parts[0]; // Start with first part

		// Check if this could be a variation of an existing base name
		let foundGroup = false;
		for (const [existingBase, files] of groups.entries()) {
			if (
				fileName.startsWith(existingBase) ||
				existingBase.startsWith(fileName)
			) {
				// Use the shorter name as the base
				const newBase =
					fileName.length < existingBase.length ? fileName : existingBase;
				if (newBase !== existingBase) {
					// Update the key
					const existingFiles = groups.get(existingBase);
					groups.delete(existingBase);
					groups.set(newBase, [...existingFiles, controlFile]);
				} else {
					groups.get(existingBase).push(controlFile);
				}
				foundGroup = true;
				break;
			}
		}

		if (!foundGroup) {
			groups.set(baseName, [controlFile]);
		}
	}

	// Add to main control groups
	for (const [baseName, files] of groups.entries()) {
		const key = `${baseName}:${controlDir}`;
		controlGroups.set(key, {
			baseName,
			controlDir,
			files,
		});
	}
}

if (controlGroups.size === 0) {
	console.log("No control files found");
	process.exit(0);
}

console.log(`Found ${controlGroups.size} control groups:`);
for (const [key, { baseName, controlDir, files }] of controlGroups.entries()) {
	console.log(`  - ${baseName} in ${controlDir} (${files.length} files):`);

	files.forEach(
		/** @param {string} file */
		(file) => {
			console.log(`    * ${file}`);
		},
	);
}

for (const [key, { baseName, controlDir }] of controlGroups.entries()) {
	console.log(`\nBuilding ${baseName} from ${controlDir}...`);
	try {
		execSync(`pnpm build-control --name=${baseName}`, {
			stdio: "inherit",
			cwd: process.cwd(),
		});
		console.log(`✅ ${baseName} built successfully`);
	} catch (error) {
		console.error(`❌ Failed to build ${baseName}:`, getErrorMessage(error));
	}
}

console.log("\n🎉 All controls build process completed!");
