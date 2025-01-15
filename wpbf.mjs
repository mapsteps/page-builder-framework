#!/usr/bin/env zx

import "zx/globals";
import { exec } from "child_process";
import { fileURLToPath } from "url";
import {
	intro,
	outro,
	isCancel,
	cancel,
	text,
	select,
	spinner,
} from "@clack/prompts";
import { Parcel } from "@parcel/core";
import { dirname } from "path";

process.env.NODE_ENV = "production";
process.env.context = "browser";
process.env.sourceType = "script";

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

const themeBuildDir = "./build";

const rootFilesAndDirsToSkip = [
	".parcel-cache",
	"node_modules",
	"build",
	".babelrc",
	".editorconfig",
	".git",
	".gitattributes",
	".gitignore",
	".npmrc",
	".parcelrc",
	".prettierrc",
	".eslintrc.json",
	"manifest.json",
	"package.json",
	"package-lock.json",
	"phpcs.xml",
	"pnpm-lock.yaml",
	"readme.md",
	"tsconfig.json",
	"types.js",
	"wpbf.mjs",
];

const loadingSpinner = spinner();

async function main() {
	intro(`Page Builder Framework`);

	const selectedTask = await select({
		message: "Please select a task.",
		options: [
			{ value: "build-wp-plugin", label: "Build WP plugin" },
			{ value: "build-customizer-control", label: "Build customizer control" },
			{ value: "build-asset", label: "Build asset" },
		],
	});

	if (isCancel(selectedTask)) {
		cancel("Task cancelled.");
		process.exit(0);
	}

	if (selectedTask === "build-wp-plugin") {
		loadingSpinner.start("Building WP plugin...");
		buildWpPlugin();
		loadingSpinner.stop();
	} else {
		if (selectedTask === "build-customizer-control") {
			const controlName = await text({
				message: "Insert the customizer control namespace (e.g: slider):",
			});

			if (isCancel(controlName)) {
				cancel("Build customizer control cancelled.");
				process.exit(0);
			}

			loadingSpinner.start(`Building customizer control: ${controlName}...`);

			deleteIfDirExists(
				path.join(
					__dirname,
					`Customizer/Controls/${toPascalCase(controlName)}/dist`,
				),
			);

			const response = await bundleCustomizerControl(controlName);

			if (response.success) {
				loadingSpinner.stop(response.message);
			} else {
				loadingSpinner.stop(response.message, 500);
			}
		}
	}

	outro(`Done`);
}

/**
 * Bundle the customizer control.
 *
 * @param {string} controlName The customizer control name. E.g: checkbox.
 */
async function bundleCustomizerControl(controlName) {
	const pascalCaseControlName = toPascalCase(controlName);

	const srcDir = `Customizer/Controls/${pascalCaseControlName}/src`;
	const absSrcDir = path.join(__dirname, srcDir);

	const distDir = `Customizer/Controls/${pascalCaseControlName}/dist`;
	const absDistDir = path.join(__dirname, distDir);

	// Find files inside `srcDir` directory that suffixed with `-control.ts`.
	const controlFiles = fs.readdirSync(srcDir).filter((file) => {
		return file.endsWith("-control.ts");
	});

	if (controlFiles.length === 0) {
		return {
			success: false,
			message: `No control files found in ${srcDir} directory.`,
		};
	}

	/**
	 * The entries to pass to Parcel.
	 *
	 * @type {string[]}
	 */
	const entries = [];

	for (const controlFile of controlFiles) {
		entries.push(path.join(srcDir, controlFile));

		// Get the control file name without the "-control.ts" suffix.
		const controlFileName = controlFile.replace(/-control\.ts$/, "");

		// Check if ${controlFileName}-preview.ts exists in src directory.
		const previewPath = path.join(srcDir, `${controlFileName}-preview.ts`);

		if (fs.existsSync(previewPath)) {
			entries.push(previewPath);
		}
	}

	const buildViaAPI = false;
	// console.log("entries", entries);

	try {
		if (buildViaAPI) {
			return await bundleViaAPI(entries, absDistDir);
		}

		return await bundleViaCLI(entries, absDistDir);
	} catch (err) {
		if (typeof err === "string") {
			return {
				success: false,
				message: err,
			};
		}

		if (err instanceof Error) {
			return {
				success: false,
				message: err.message,
			};
		}

		if (typeof err === "object" && err) {
			if ("diagnostics" in err && Array.isArray(err.diagnostics)) {
				let msg = "";

				err.diagnostics.forEach((item) => {
					msg += "Error: " + item.message + "\n";
				});

				// Remove trailing newline.
				msg = msg.slice(0, -1);

				return {
					success: false,
					message: msg,
				};
			}

			if ("stderr" in err && err.stderr) {
				return {
					success: false,
					message: err.stderr.toString(),
				};
			}

			if ("stdout" in err && err.stdout) {
				return {
					success: false,
					message: err.stdout.toString(),
				};
			}

			console.log(err);

			return {
				success: false,
				message: "An unknown error occurred during the build process.",
			};
		}

		return {
			success: false,
			message: "Unknown error occurred.",
		};
	}
}

/**
 * Bundle the customizer control using the Parcel API.
 *
 * @param {string[]} entries The entries to pass to Parcel.
 * @param {string} distDir The dist directory path.
 * @returns {Promise<{success: boolean, message: string}>} The result of the bundling process.
 */
async function bundleViaCLI(entries, distDir) {
	const startTime = Date.now();

	// Construct the Parcel CLI command
	let parcelCmd = `parcel build ${entries.join(" ")} --dist-dir ${distDir} --no-cache`;

	// Replace backslashes with forward slashes
	parcelCmd = parcelCmd.replace(/\\/g, "/");

	// Execute the command using zx (doesn't work: No quote function is defined: https://ï.at/no-quote-func)
	// await $`${parcelCmd}`;

	// Lets use exec instead of zx.
	exec(parcelCmd);

	const endTime = Date.now();

	return {
		success: true,
		message: `✨ Built ${entries.length} bundles in ${endTime - startTime}ms!`,
	};
}

/**
 * Bundle the customizer control using the Parcel API.
 *
 * @param {string[]} entries The entries to pass to Parcel.
 * @param {string} distDir The dist directory path.
 * @returns {Promise<{success: boolean, message: string}>} The result of the bundling process.
 */
async function bundleViaAPI(entries, distDir) {
	const bundler = new Parcel({
		entries: entries,
		shouldDisableCache: true,
		defaultConfig: "@parcel/config-default",
		mode: "production",
		env: {
			NODE_ENV: "production",
			context: "browser",
			sourceType: "script",
		},
		defaultTargetOptions: {
			shouldOptimize: true,
			shouldScopeHoist: true,
			isLibrary: false,
			outputFormat: "global",
			publicUrl: "./",
		},
		targets: {
			default: {
				context: "browser",
				distDir: distDir,
				engines: {
					browsers: ["> 0.5%", "last 2 versions", "not dead"],
				},
				outputFormat: "global",
				isLibrary: false,
				scopeHoist: true,
				optimize: true,
				sourceMap: true,
				includeNodeModules: true,
			},
		},
		shouldContentHash: false,
		shouldBuildLazily: false,
		shouldBundleIncrementally: false,
	});

	const { bundleGraph, buildTime } = await bundler.run();
	const bundles = bundleGraph.getBundles();

	return {
		success: true,
		message: `✨ Built ${bundles.length} bundles in ${buildTime}ms!`,
	};
}

/**
 * Convert a string to PascalCase.
 *
 * @param {string} str The string to convert.
 * @returns {string} The converted string.
 */
function toPascalCase(str) {
	return (
		str
			// Split the string by spaces and hyphens.
			.split(/[\s-]+/)
			// Capitalize first letter of each word and make rest lowercase
			.map((word) => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
			// Join all words together
			.join("")
	);
}

/**
 * Delete the build directory if it exists.
 *
 * @param {string} dir The build directory path.
 */
function deleteIfDirExists(dir) {
	if (fs.existsSync(dir)) {
		fs.rmSync(dir, { recursive: true });
	}
}

/**
 * Copy the files and directories from the source directory to the destination directory.
 *
 * @param {string} srcPath The source directory path.
 * @param {string} destPath The destination directory path.
 */
function copyFilesAndDir(srcPath, destPath) {
	const filesAndDirsToCopy = fs.readdirSync(srcPath);

	filesAndDirsToCopy.forEach((fileOrDir) => {
		if (rootFilesAndDirsToSkip.includes(fileOrDir)) {
			return;
		}

		fs.copySync(`${srcPath}/${fileOrDir}`, `${destPath}/${fileOrDir}`);
	});
}

/**
 * Delete the map files inside a directory.
 *
 * @param {string} dir The directory path.
 */
function deleteMapFiles(dir) {
	const filesAndDirs = fs.readdirSync(dir);

	filesAndDirs.forEach((fileOrDir) => {
		if (fs.lstatSync(`${dir}/${fileOrDir}`).isDirectory()) {
			deleteMapFiles(`${dir}/${fileOrDir}`);
			return;
		}

		if (fileOrDir.endsWith(".map")) {
			fs.unlinkSync(`${dir}/${fileOrDir}`);
		}

		if (fileOrDir.endsWith("-min.js") || fileOrDir.endsWith("-min.css")) {
			const fileContent = fs.readFileSync(`${dir}/${fileOrDir}`, "utf8");
			let newFileContent = "";

			/**
			 * Remove the whole line that begins with "//# sourceMappingURL=" or "/*# sourceMappingURL="
			 */
			fileContent.split("\n").forEach((line) => {
				if (
					line.startsWith("//# sourceMappingURL=") ||
					line.startsWith("/*# sourceMappingURL=")
				) {
					return;
				}

				newFileContent += line + "\n";
			});

			// If the file content contains multiple lines, then remove the second line.
			if (newFileContent.includes("\n\n")) {
				newFileContent = newFileContent.replace(/\n\n/g, "\n");
			}

			fs.writeFileSync(`${dir}/${fileOrDir}`, newFileContent, "utf8");
		}
	});
}

function buildWpPlugin() {
	deleteIfDirExists(themeBuildDir);
	fs.mkdirSync(themeBuildDir);

	const wpbfBuildDir = `${themeBuildDir}/page-builder-framework`;
	deleteIfDirExists(wpbfBuildDir);
	fs.mkdirSync(wpbfBuildDir);

	copyFilesAndDir(".", wpbfBuildDir);
	deleteMapFiles(wpbfBuildDir);
}

main();
