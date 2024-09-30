import { defineConfig } from "vite";
import path from "path";

// Get files passed as command-line arguments and filter non-file arguments.
const inputFiles = process.argv
	.slice(2)
	.filter((arg) => arg.endsWith(".ts") || arg.endsWith(".js"));

// Throw an error if no valid files are specified
if (inputFiles.length === 0) {
	throw new Error(
		"No valid input files specified. Please pass files as arguments.",
	);
}

// Dynamically calculate the output directory based on the file's path.
const getOutDir = (file) => {
	const srcFolder = "src";
	const srcIndex = file.indexOf(srcFolder);

	if (srcIndex === -1) {
		throw new Error(`The file path ${file} does not contain a 'src' folder.`);
	}

	// Calculate the directory above the 'src' folder.
	const outDir = path.dirname(file.slice(0, srcIndex + srcFolder.length - 1));
	return outDir ? path.resolve(outDir) : ".";
};

// Get the base filename without extension to use it in output naming.
const getFileName = (file) => {
	return path.basename(file, path.extname(file));
};

export default defineConfig({
	build: {
		rollupOptions: {
			input: inputFiles.reduce((inputs, file) => {
				const fileName = getFileName(file);
				inputs[fileName] = file;
				return inputs;
			}, {}),
			// output: {
			// 	// Output minified file and corresponding source map.
			// 	entryFileNames: (chunkInfo) => {
			// 		const fileName = getFileName(chunkInfo.name);
			// 		return `${fileName}-min.js`;
			// 	},
			// 	sourcemap: true,
			// 	// Add the mapping for the map files to be in the same directory.
			// 	assetFileNames: "[name]-min.js.map",
			// 	chunkFileNames: "[name]-min.js",
			// },
			output: {
				entryFileNames: (chunkInfo) => {
					const fileName = getFileName(chunkInfo.name);
					return `${fileName}-min.js`;
				},
				sourcemap: true,
				assetFileNames: (assetInfo) => {
					const ext = path.extname(assetInfo.name);

					if (ext === ".css") {
						return `${getFileName(assetInfo.name)}-min.css`;
					}

					return "[name]-min.js";
				},
				chunkFileNames: (chunkInfo) => {
					const ext = path.extname(chunkInfo.name);

					if (ext === ".css") {
						return `${getFileName(chunkInfo.name)}-min.css`;
					}

					return "[name]-min.js";
				},
			},
		},
		// Output directly in the 'dist' folder.
		outDir: path.join(getOutDir(inputFiles[0]), "dist"),
		emptyOutDir: false,
		minify: true,
	},
	css: {
		devSourcemap: true,
		sourceMap: true,
	},
});
