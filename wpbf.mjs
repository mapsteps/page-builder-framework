#!/usr/bin/env zx

import "zx/globals";

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

buildWpPlugin();
