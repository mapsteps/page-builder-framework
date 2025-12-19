#!/usr/bin/env zx

import "zx/globals";
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
import { resolve, dirname } from "path";
import { build } from "vite";
import { execSync } from "child_process";
import {
	deleteIfDirExists,
	getErrorMessage,
	getViteConfig,
	toPascalCase,
} from "./build-scripts/build-utils.mjs";

process.env.NODE_ENV = "production";
process.env.context = "browser";
process.env.sourceType = "script";

const ALLOWED_FILE_EXTENSIONS = ["scss", "js", "ts", "jsx", "tsx"];

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

const themeBuildDir = "./build";

// Asset presets for quick building
const ASSET_PRESETS = [
	// --- Admin / Customizer ---
	{ value: "__sep_admin__", label: "─── Admin / Customizer ───", isSeparator: true },
	{
		value: "customizer",
		label: "Customizer",
		hint: "Customizer panel scripts",
		path: "inc/customizer/js/customizer.ts",
		output: "js/min",
	},
	{
		value: "postmessage",
		label: "PostMessage",
		hint: "Customizer live preview",
		path: "inc/customizer/js/postmessage.ts",
		output: "js/min",
	},
	{
		value: "theme-settings",
		label: "Theme settings",
		hint: "Admin settings page",
		path: "assets/js/theme-settings.js",
		output: "js/min",
	},
	{
		value: "edit-post",
		label: "Edit post",
		hint: "Block editor scripts",
		path: "assets/js/edit-post.js",
		output: "js/min",
	},
	{
		value: "activation-notice",
		label: "Activation notice",
		hint: "Admin activation notice",
		path: "assets/js/activation-notice.js",
		output: "js/min",
	},

	// --- Frontend ---
	{ value: "__sep_frontend__", label: "─── Frontend ───", isSeparator: true },
	{
		value: "site-js",
		label: "Site JS",
		hint: "Vanilla JS",
		path: "assets/js/site.js",
		output: "js/min",
	},
	{
		value: "site-jquery",
		label: "Site jQuery",
		hint: "jQuery",
		path: "assets/js/site-jquery.js",
		output: "js/min",
	},
	{
		value: "post-list",
		label: "Post list",
		hint: "Post list scripts",
		path: "assets/js/post-list.js",
		output: "js/min",
	},

	// --- Styles ---
	{ value: "__sep_styles__", label: "─── Styles ───", isSeparator: true },
	{
		value: "style",
		label: "Style",
		hint: "Main theme styles",
		path: "assets/scss/style.scss",
		output: "css/min",
	},
	{
		value: "responsive",
		label: "Responsive",
		hint: "Responsive styles",
		path: "assets/scss/responsive.scss",
		output: "css/min",
	},
	{
		value: "rtl",
		label: "RTL",
		hint: "Right-to-left styles",
		path: "assets/scss/rtl.scss",
		output: "css/min",
	},
	{
		value: "admin-rtl",
		label: "Admin RTL",
		hint: "Admin right-to-left styles",
		path: "assets/scss/admin-rtl.scss",
		output: "css/min",
	},
	{
		value: "edit-post-css",
		label: "Edit post CSS",
		hint: "Block editor styles",
		path: "assets/scss/edit-post.scss",
		output: "css/min",
	},
	{
		value: "iconfont",
		label: "Iconfont",
		hint: "Icon font styles",
		path: "assets/scss/iconfont.scss",
		output: "css/min",
	},
];

const rootFilesAndDirsToSkip = [
	// Directories
	".git",
	".parcel-cache",
	"build",
	"build-scripts",
	"node_modules",

	// Dotfiles
	".babelrc",
	".editorconfig",
	".eslintrc.json",
	".gitattributes",
	".gitignore",
	".npmrc",
	".parcelrc",
	".prettierrc",

	// Package management
	"composer.json",
	"composer.lock",
	"package.json",
	"package-lock.json",
	"pnpm-lock.yaml",
	"pnpm-workspace.yaml",

	// Build tooling
	"manifest.json",
	"tsconfig.json",
	"vite.config.mjs",
	"wpbf.mjs",

	// Dev files
	"phpcs.xml",
	"readme.md",
	"types.ts",
];

const loadingSpinner = spinner();

async function main() {
	intro(`Page Builder Framework`);

	let continueMainLoop = true;

	while (continueMainLoop) {
		const selectedTask = await select({
			message: "Please select a task.",
			options: [
				{
					value: "build-preset",
					label: "Build preset asset (select from common assets)",
				},
				{
					value: "build-custom",
					label: "Build custom asset (enter file path manually)",
				},
				{
					value: "build-controls-bundle",
					label: "Build controls bundle (customizer controls)",
				},
				{
					value: "build-wp-theme",
					label: "Build WP theme (production package)",
				},
				{
					value: "exit",
					label: "Exit",
				},
			],
		});

		if (isCancel(selectedTask) || selectedTask === "exit") {
			continueMainLoop = false;
			break;
		}

		if (selectedTask === "build-wp-theme") {
			loadingSpinner.start("Building WP theme...");
			buildWpTheme();
			loadingSpinner.stop("WP theme built successfully.");
		} else if (selectedTask === "build-controls-bundle") {
			loadingSpinner.start("Building customizer controls bundle...");
			const response = await buildControlsBundle();
			if (response.success) {
				loadingSpinner.stop(response.message);
			} else {
				loadingSpinner.stop(response.message, 500);
			}
		} else if (selectedTask === "build-preset") {
			let continuePresetLoop = true;

			while (continuePresetLoop) {
				const presetOptions = [
					...ASSET_PRESETS.map((preset) =>
						preset.isSeparator
							? { value: preset.value, label: preset.label, disabled: true }
							: { value: preset.value, label: preset.label, hint: preset.hint },
					),
					{ value: "__sep_nav__", label: "───", disabled: true },
					{ value: "__back__", label: "← Back" },
					{ value: "__exit__", label: "Exit" },
				];

				const selectedPreset = await select({
					message: "Select an asset to build:",
					options: presetOptions,
				});

				if (isCancel(selectedPreset) || selectedPreset === "__back__") {
					continuePresetLoop = false;
					break;
				}

				if (selectedPreset === "__exit__") {
					continuePresetLoop = false;
					continueMainLoop = false;
					break;
				}

				// Skip if separator was selected
				if (String(selectedPreset).startsWith("__sep_")) {
					continue;
				}

				const preset = ASSET_PRESETS.find((p) => p.value === selectedPreset);

				if (!preset) {
					cancel("Invalid preset selected.");
					process.exit(1);
				}

				const outputDir = resolve(__dirname, preset.output);

				loadingSpinner.start(`Building ${preset.label}...`);

				const response = await buildAsset(preset.path, outputDir);

				if (response.success) {
					loadingSpinner.stop(response.message);
				} else {
					loadingSpinner.stop(response.message, 500);
				}
			}
		} else if (selectedTask === "build-custom") {
			const filePath = await text({
				message:
					"Insert the file path to build (e.g: assets/js/site.js or assets/scss/style.scss):",
			});

			if (isCancel(filePath)) {
				continue;
			}

			if (!ALLOWED_FILE_EXTENSIONS.some((ext) => filePath.endsWith(`.${ext}`))) {
				cancel(
					`Invalid file extension. Allowed extensions: ${ALLOWED_FILE_EXTENSIONS.join(", ")}`,
				);
				process.exit(0);
			}

			const fileType = filePath.split(".").pop();

			const outputDirFromUser = await text({
				message:
					"Insert the output directory path. If empty, it will use default location (js: js/min, scss: css/min).",
			});

			const outputDir = outputDirFromUser
				? resolve(__dirname, String(outputDirFromUser))
				: fileType === "scss"
					? resolve(__dirname, "css/min")
					: resolve(__dirname, "js/min");

			loadingSpinner.start(`Building asset file: ${filePath}...`);

			const response = await buildAsset(filePath, outputDir);

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
 * Build an asset file.
 *
 * @param {string} filePath The file path to build.
 * @param {string} outputDir The output directory path.
 *
 * @returns {Promise<{success: boolean, message: string}>} The result of the bundling process.}
 */
async function buildAsset(filePath, outputDir) {
	try {
		return await bundleViaViteAPI(filePath, outputDir);
	} catch (err) {
		return {
			success: false,
			message: getErrorMessage(err),
		};
	}
}

/**
 * Bundle the customizer control.
 *
 * @param {string} controlName The customizer control name. E.g: checkbox.
 * @returns {Promise<{success: boolean, message: string}>} The result of the bundling process.}
 */
async function bundleCustomizerControl(controlName) {
	const pascalCaseControlName = toPascalCase(controlName);

	const srcDir = `Customizer/Controls/${pascalCaseControlName}/src`;

	const distDir = `Customizer/Controls/${pascalCaseControlName}/dist`;
	const absDistDir = resolve(__dirname, distDir);

	// Find files inside `srcDir` directory that suffixed with `-control.ts` or `-control.tsx`.
	const controlFiles = fs.readdirSync(srcDir).filter((file) => {
		return file.endsWith("-control.ts") || file.endsWith("-control.tsx");
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
	 * @type {import('vite').Rollup.InputOption}
	 */
	const entries = {};

	for (const controlFile of controlFiles) {
		// Get the control file name without the "-control.ts" and "-control.tsx" suffixes.
		const controlFileName = controlFile.replace(/-control\.tsx?$/, "");

		// Add the control file to the entries.
		entries[
			`${controlFileName}-control${controlFile.endsWith("-control.scss") ? "-style" : ""}`
		] = resolve(srcDir, controlFile);

		// Check if ${controlFileName}-preview.ts exists in src directory.
		const previewPath = resolve(srcDir, `${controlFileName}-preview.ts`);

		if (fs.existsSync(previewPath)) {
			entries[`${controlFileName}-preview`] = previewPath;
		}

		// Check if ${controlFileName}-preview.tsx exists in src directory.
		const previewPathTsx = resolve(srcDir, `${controlFileName}-preview.tsx`);

		if (fs.existsSync(previewPathTsx)) {
			entries[`${controlFileName}-preview`] = previewPathTsx;
		}
	}

	try {
		return await bundleViaViteAPI(entries, absDistDir, true);
	} catch (err) {
		return {
			success: false,
			message: getErrorMessage(err),
		};
	}
}

/**
 * Bundle the customizer control using the Vite API.
 *
 * @param {import('vite').Rollup.InputOption} entries The entries to pass to Vite.
 * @param {string} distDir The dist directory path.
 * @param {boolean} clearDistDir Whether to clear the dist directory before building.
 *
 * @returns {Promise<{success: boolean, message: string}>} The result of the bundling process.
 */
async function bundleViaViteAPI(entries, distDir, clearDistDir = false) {
	try {
		if (typeof entries === "string") {
			await build(getViteConfig(entries, distDir, clearDistDir));

			return {
				success: true,
				message: `✨`,
			};
		}

		/**
		 * Unfortunately, multiple entries are not supported when "output.inlineDynamicImports" is true.
		 *
		 * Vite build failed:
		 * Invalid value for option "output.inlineDynamicImports" - multiple inputs are not supported when "output.inlineDynamicImports" is true.
		 *
		 * So instead of executing `await build(getViteConfig(entries, distDir));`,
		 * We need to loop the entries and build them individually.
		 *
		 * @see https://github.com/rollup/rollup/issues/5601
		 */
		await Promise.all(
			Object.entries(entries).map(([entryKey, filePath]) => {
				return build(getViteConfig(filePath, distDir));
			}),
		);

		return {
			success: true,
			message: `✨`,
		};
	} catch (error) {
		throw new Error(`Vite build failed: ${getErrorMessage(error)}`);
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

function buildWpTheme() {
	deleteIfDirExists(themeBuildDir);
	fs.mkdirSync(themeBuildDir);

	const wpbfBuildDir = `${themeBuildDir}/page-builder-framework`;
	deleteIfDirExists(wpbfBuildDir);
	fs.mkdirSync(wpbfBuildDir);

	copyFilesAndDir(".", wpbfBuildDir);
	deleteMapFiles(wpbfBuildDir);
}

/**
 * Build the customizer controls bundle.
 *
 * @returns {Promise<{success: boolean, message: string}>} The result of the bundling process.
 */
async function buildControlsBundle() {
	const bundleSrcDir = resolve(__dirname, "Customizer/Controls/Bundle/src");
	const bundleDistDir = resolve(__dirname, "Customizer/Controls/Bundle/dist");

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

	try {
		for (const entry of entries) {
			execSync("vite build", {
				stdio: "inherit",
				env: {
					...process.env,
					ENTRY_PATH: entry.path,
					OUTPUT_DIR: bundleDistDir,
				},
			});
		}

		return {
			success: true,
			message: "Controls bundle built successfully.",
		};
	} catch (error) {
		return {
			success: false,
			message: getErrorMessage(error),
		};
	}
}

main();
