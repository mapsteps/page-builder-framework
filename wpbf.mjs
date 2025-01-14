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
import { Parcel } from "@parcel/core";
import { dirname } from "path";

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

// Parcel shared configuration
const parcelConfig = {
	defaultConfig: "@parcel/config-default",
	mode: "production",
	defaultTargetOptions: {
		engines: {
			browsers: ["> 0.5%", "last 2 versions", "not dead"],
		},
	},
	additionalResolveOptions: {
		// Handled in package.json
		/*
		alias: {
			react: { global: "React" },
			"react-dom": { global: "ReactDOM" },
			"react/jsx-runtime": { global: "_jsx" },
			jquery: { global: "jQuery" },
			wp: { global: "wp" },
			lodash: { global: "_" },
			"@wordpress/editor": { global: "wp.editor" },
			"@wordpress/i18n": { global: "wp.i18n" },
			"@wordpress/hooks": { global: "wp.hooks" },
		},
		*/
	},
	// Handled in package.json
	/*
	namers: ["parcel-namer-rewrite"],
	resolvers: ["parcel-resolver-ignore", "..."],
	nameConfig: {
		rules: {
			"(.*).js": "$1-min.js",
			"(.*).css": "$1-min.css",
		},
		hashing: "never",
		silent: true,
	},
	ignore: ["img/.+"],
	*/
};

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
				message: "Insert the customizer control name (e.g: checkbox):",
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
			loadingSpinner.stop(response);
		}
	}

	outro(`Done!`);
}

/**
 * Bundle the customizer control.
 *
 * @param {string} controlName The customizer control name. E.g: checkbox.
 */
async function bundleCustomizerControl(controlName) {
	const pascalCaseControlName = toPascalCase(controlName);
	const srcDirName = `Customizer/Controls/${pascalCaseControlName}/src`;

	/**
	 * The entries to pass to Parcel.
	 *
	 * @type {string[]}
	 */
	const entries = [];

	const controlPath = path.join(
		__dirname,
		`${srcDirName}/${controlName}-control.ts`,
	);

	entries.push(controlPath);

	// Check if ${controlName}-preview.ts exists in src directory.
	const previewPath = path.join(
		__dirname,
		`${srcDirName}/${controlName}-preview.ts`,
	);

	if (fs.existsSync(previewPath)) {
		entries.push(previewPath);
	}

	const bundler = new Parcel({
		...parcelConfig,
		entries: entries,
		shouldDisableCache: true,
		targets: {
			main: {
				distDir: path.join(
					__dirname,
					`Customizer/Controls/${pascalCaseControlName}/dist`,
				),
				engines: {
					browsers: ["> 0.5%", "last 2 versions", "not dead"],
				},
				// outputFormat: "esmodule",
				sourceMap: true,
				optimize: true,
			},
		},
	});

	try {
		let { bundleGraph, buildTime } = await bundler.run();
		let bundles = bundleGraph.getBundles();

		return `✨ Built ${bundles.length} bundles in ${buildTime}ms!`;
	} catch (err) {
		return String(
			typeof err === "object" && err && "diagnostics" in err
				? err.diagnostics
				: err,
		);
	}
}

/**
 * Convert a string to PascalCase.
 *
 * @param {string} str The string to convert.
 * @returns {string} The converted string.
 */
function toPascalCase(str) {
	return str.replace(/-([a-z])/g, (_, letter) => letter.toUpperCase());
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
