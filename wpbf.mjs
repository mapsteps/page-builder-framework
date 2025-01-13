#!/usr/bin/env zx

import "zx/globals";
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

const loadingSpinner = spinner();

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
		//
		loadingSpinner.stop();
	}
}

outro(`Done!`);

/**
 * Bundle the customizer control.
 *
 * @param {string} controlName The customizer control name. E.g: checkbox.
 */
async function bundleCustomizerControl(controlName) {
	const pascalCaseControlName = controlName.replace(/-([a-z])/g, (_, letter) =>
		letter.toUpperCase(),
	);

	const controlPath = path.join(
		__dirname,
		`Customizer/Controls/${pascalCaseControlName}/src/${controlName}-control.ts`,
	);

	const bundler = new Parcel({
		entries: controlPath,
		defaultConfig: "@parcel/config-default",
		mode: "production",
		defaultTargetOptions: {
			engines: {
				browsers: ["> 0.5%", "last 2 versions", "not dead"],
			},
		},
		targets: {
			main: {
				distDir: path.join(__dirname, "Customizer/Controls/Checkbox/dist"),
				engines: {
					browsers: ["> 0.5%", "last 2 versions", "not dead"],
				},
				outputFormat: "esmodule",
				sourceMap: true,
				optimize: true,
			},
		},
	});

	try {
		let { bundleGraph, buildTime } = await bundler.run();
		let bundles = bundleGraph.getBundles();
		console.log(`✨ Built ${bundles.length} bundles in ${buildTime}ms!`);
	} catch (err) {
		console.log(
			typeof err === "object" && err && "diagnostics" in err ? err.diagnostics : err,
		);
	}
}

const themeBuildDir = "./build";

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
