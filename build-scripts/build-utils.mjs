import path from "path";
import fs from "fs";

/**
 * Get error message from unknown error type.
 * @returns {string}
 */
/** @param {unknown} err */
export function getErrorMessage(err) {
	if (err instanceof Error) {
		return err.message;
	}

	if (typeof err === "string") {
		return err;
	}

	if (typeof err === "object" && err) {
		if ("diagnostics" in err && Array.isArray(err.diagnostics)) {
			let msg = "";

			/** @param {{message: string}} item */
			err.diagnostics.forEach((item) => {
				msg += "Error: " + item.message + "\n";
			});

			// Remove trailing newline.
			return msg.slice(0, -1);
		}

		if ("stderr" in err && err.stderr) {
			return err.stderr.toString();
		}

		if ("stdout" in err && err.stdout) {
			return err.stdout.toString();
		}
	}

	return "Unknown error";
}

/**
 * Convert a string from dash-case to PascalCase.
 *
 * @param {string} str
 * @returns {string}
 */
export function dashToPascalCase(str) {
	if (str.includes("-")) {
		return str.replace(/(^\w|-\w)/g, (c) => c.replace("-", "").toUpperCase());
	}

	return str.charAt(0).toUpperCase() + str.slice(1);
}

/**
 * Get the value of a command-line argument like --key=value
 * @param {string} key - The argument key, without "--"
 * @returns {string|undefined} - The value if present, `true` if passed without value, or `undefined` if not passed
 */
export function getCommandArgValue(key) {
	const prefix = `--${key}=`;
	for (const arg of process.argv.slice(2)) {
		if (arg.startsWith(prefix)) {
			return arg.slice(prefix.length);
		}
	}
	return undefined;
}

/**
 * Get the base filename without extension to use it in output naming.
 *
 * @param {string} filePath The file path.
 * @returns {string} The filename without extension.
 */
export function getFileNameWithoutExtension(filePath) {
	const fileNameWithExt = path.basename(filePath);

	return path.parse(fileNameWithExt).name;
}

/**
 * Convert a string to PascalCase.
 *
 * @param {string} str The string to convert.
 * @returns {string} The converted string.
 */
export function toPascalCase(str) {
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
export function deleteIfDirExists(dir) {
	if (fs.existsSync(dir)) {
		fs.rmSync(dir, { recursive: true });
	}
}

/**
 * Generate Vite configuration for building.
 *
 * Unfortunately, multiple entries are not supported when "output.inlineDynamicImports" is true.
 *
 * Vite build will fail with:
 * Invalid value for option "output.inlineDynamicImports" - multiple inputs are not supported when "output.inlineDynamicImports" is true.
 *
 * @see https://github.com/rollup/rollup/issues/5601
 *
 * @param {import('vite').Rollup.InputOption} entries The entry points for the build. Should be a string due to above issue.
 * @param {string} distDir The output directory for the build.
 * @param {boolean} clearDistDir Whether to clear the dist directory before building.
 *
 * @returns {import('vite').UserConfig}
 */
export function getViteConfig(entries, distDir, clearDistDir = false) {
	const keyName =
		typeof entries === "string"
			? getFileNameWithoutExtension(entries)
			: undefined;

	return {
		logLevel: "info",
		css: {
			transformer: "lightningcss",
			preprocessorOptions: {
				scss: {
					// includePaths: [
					// 	"assets/scss", // For shared SCSS files
					// 	"Customizer/Controls", // For control-specific SCSS files
					// 	".", // Project root as fallback
					// ],
					quietDeps: true,
				},
			},
		},
		build: {
			target: "es2020",
			outDir: distDir,
			emptyOutDir: clearDistDir,
			cssCodeSplit: false,
			minify: "terser",
			sourcemap: true,

			rollupOptions: {
				// Externalize deps that shouldn't be bundled
				external: [
					"react",
					"react-dom",
					"react/jsx-runtime",
					"jquery",
					"wp",
					"lodash",
					"@wordpress/editor",
					"@wordpress/i18n",
					"@wordpress/hooks",
					"choices.js",
				],
				/**
				 * Unfortunately, multiple entries are not supported when "output.inlineDynamicImports" is true.
				 *
				 * Vite build failed:
				 * Invalid value for option "output.inlineDynamicImports" - multiple inputs are not supported when "output.inlineDynamicImports" is true.
				 *
				 * @see https://github.com/rollup/rollup/issues/5601
				 */
				input: entries,
				output: {
					format: "iife",
					// Inline dynamic imports to prevent JS code splitting
					inlineDynamicImports: true,
					// Custom naming for each entry
					entryFileNames: (chunkInfo) => {
						// console.log(`chunkInfo`, chunkInfo);
						const isStyle = chunkInfo.facadeModuleId?.endsWith(".css");

						return `${chunkInfo.name}-min.${isStyle ? "css" : "js"}`;
					},
					/**
					 * Here, the CSS asset loses its original name.
					 * Thus, we need to rename it to match the JS file.
					 */
					assetFileNames: (assetInfo) => {
						// console.log("assetInfo", assetInfo);
						const fileName = assetInfo.names[0];

						if (fileName.endsWith(".css")) {
							return `${keyName ? keyName : getFileNameWithoutExtension(fileName)}-min.css`;
						}

						return "[name]-min.js";
					},
					globals: {
						react: "React",
						"react-dom": "ReactDOM",
						"react/jsx-runtime": "ReactJSXRuntime",
						jquery: "jQuery",
						wp: "wp",
						lodash: "_",
						"@wordpress/editor": "wp.editor",
						"@wordpress/i18n": "wp.i18n",
						"@wordpress/hooks": "wp.hooks",
						"choices.js": "Choices",
					},
				},
			},
		},
	};
}
