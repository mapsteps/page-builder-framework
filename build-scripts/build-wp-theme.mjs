import { resolve, dirname } from "path";
import { fileURLToPath } from "url";
import fs from "fs-extra";
import { deleteIfDirExists } from "./build-utils.mjs";

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);
const themeDir = resolve(__dirname, "..");

const themeBuildDir = resolve(themeDir, "build");

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
	console.log("Building WP theme...\n");

	deleteIfDirExists(themeBuildDir);
	fs.mkdirSync(themeBuildDir);

	const wpbfBuildDir = `${themeBuildDir}/page-builder-framework`;
	deleteIfDirExists(wpbfBuildDir);
	fs.mkdirSync(wpbfBuildDir);

	copyFilesAndDir(themeDir, wpbfBuildDir);
	deleteMapFiles(wpbfBuildDir);

	console.log("✅ WP theme built successfully!");
	console.log(`📁 Output: ${wpbfBuildDir}`);
}

buildWpTheme();
