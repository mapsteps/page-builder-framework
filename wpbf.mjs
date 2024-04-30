#!/usr/bin/env zx

import "zx/globals";

const wpPluginBuildDir = "./build";

function deleteIfDirExists(dir) {
	if (fs.existsSync(dir)) {
		fs.rmSync(dir, { recursive: true });
	}
}

const filesAndDirsToSkip = [
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

function copyRootFilesAndDirsToBuildDirExceptSkippedOnes() {
	const filesAndDirsToCopy = fs.readdirSync(".");

	filesAndDirsToCopy.forEach((fileOrDir) => {
		if (filesAndDirsToSkip.includes(fileOrDir)) {
			return;
		}

		const srcPath = `./${fileOrDir}`;
		const destPath = `${wpPluginBuildDir}/${fileOrDir}`;

		if (fs.lstatSync(srcPath).isDirectory()) {
			fs.mkdirSync(destPath);
			copyRootFilesAndDirsToBuildDirExceptSkippedOnes();
		} else {
			fs.copyFileSync(srcPath, destPath);
		}
	});
}

function deleteMapFilesInsideBuildDir() {
	const filesAndDirs = fs.readdirSync(wpPluginBuildDir);

	filesAndDirs.forEach((fileOrDir) => {
		if (fs.lstatSync(`${wpPluginBuildDir}/${fileOrDir}`).isDirectory()) {
			return;
		}

		// If it's a map file, delete it.
		if (fileOrDir.endsWith(".map")) {
			fs.unlinkSync(`${wpPluginBuildDir}/${fileOrDir}`);
		}

		// If it's a "-min.js" or "-min.css" file, then delete the line that contains "//# sourceMappingURL=".
		if (fileOrDir.endsWith("-min.js") || fileOrDir.endsWith("-min.css")) {
			const fileContent = fs.readFileSync(
				`${wpPluginBuildDir}/${fileOrDir}`,
				"utf8",
			);

			const newFileContent = fileContent.replace(/## sourceMappingURL=.*/g, "");

			fs.writeFileSync(
				`${wpPluginBuildDir}/${fileOrDir}`,
				newFileContent,
				"utf8",
			);
		}
	});
}

function buildWpPlugin() {
	deleteIfDirExists(wpPluginBuildDir);
	fs.mkdirSync(wpPluginBuildDir);
	copyRootFilesAndDirsToBuildDirExceptSkippedOnes();
	deleteMapFilesInsideBuildDir();
}

buildWpPlugin();
