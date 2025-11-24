import { execSync } from "child_process";
import { readdirSync, existsSync } from "fs";
import { resolve, dirname } from "path";
import { fileURLToPath } from "url";
import { getCommandArgValue, toPascalCase } from "./build-utils.mjs";

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);
const rootDir = resolve(__dirname, "..");

const controlName = getCommandArgValue("name");

if (!controlName) {
	console.error("Control name is required. Use --name=control-name");
	process.exit(1);
}

const pascalCaseControlName = toPascalCase(controlName);
const srcDir = resolve(
	rootDir,
	`Customizer/Controls/${pascalCaseControlName}/src`,
);
const distDir = resolve(
	rootDir,
	`Customizer/Controls/${pascalCaseControlName}/dist`,
);

if (!existsSync(srcDir)) {
	console.error(`Control source directory not found: ${srcDir}`);
	process.exit(1);
}

const controlFiles = readdirSync(srcDir).filter((file) => {
	return file.endsWith("-control.ts") || file.endsWith("-control.tsx");
});

if (controlFiles.length === 0) {
	console.error(`No control files found in ${srcDir}`);
	process.exit(1);
}

const entries = [];

for (const controlFile of controlFiles) {
	entries.push(resolve(srcDir, controlFile));

	const controlFileName = controlFile.replace(/-control\.tsx?$/, "");

	const previewPath = resolve(srcDir, `${controlFileName}-preview.ts`);
	if (existsSync(previewPath)) {
		entries.push(previewPath);
	}

	const previewPathTsx = resolve(srcDir, `${controlFileName}-preview.tsx`);
	if (existsSync(previewPathTsx)) {
		entries.push(previewPathTsx);
	}
}

for (const entry of entries) {
	console.log(`Building ${entry}...`);
	try {
		execSync("vite build", {
			stdio: "inherit",
			env: {
				...process.env,
				ENTRY_PATH: entry,
				OUTPUT_DIR: distDir,
			},
		});
	} catch (error) {
		console.error(`Failed to build ${entry}`);
		process.exit(1);
	}
}
