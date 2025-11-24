import { execSync } from "child_process";
import { resolve, dirname } from "path";
import { fileURLToPath } from "url";
import { existsSync } from "fs";
import { getCommandArgValue } from "./build-utils.mjs";

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);
const rootDir = resolve(__dirname, "..");

const assetPath = getCommandArgValue("path");

if (!assetPath) {
	console.error("Asset path is required. Use --path=path/to/asset");
	process.exit(1);
}

const absFilePath = resolve(rootDir, assetPath);

if (!existsSync(absFilePath)) {
	console.error(`Asset file not found: ${absFilePath}`);
	process.exit(1);
}

const fileType = assetPath.split(".").pop();
let outputDir =
	fileType === "scss"
		? resolve(rootDir, "css/min")
		: resolve(rootDir, "js/min");

if (assetPath.includes("Customizer/Panels")) {
	outputDir = resolve(rootDir, "Customizer/Panels/dist");
} else if (assetPath.includes("Customizer/Sections")) {
	outputDir = resolve(rootDir, "Customizer/Sections/dist");
}

console.log(`Building ${assetPath} to ${outputDir}...`);

try {
	execSync("vite build", {
		stdio: "inherit",
		env: {
			...process.env,
			ENTRY_PATH: absFilePath,
			OUTPUT_DIR: outputDir,
		},
	});
} catch (error) {
	console.error(`Failed to build ${assetPath}`);
	process.exit(1);
}
