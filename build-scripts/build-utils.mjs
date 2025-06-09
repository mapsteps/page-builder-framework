/**
 * Get error message from unknown error type.
 *
 * @param {unknown} err
 * @returns {string}
 */
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
 * @param {string} file
 * @returns {string}
 */
export function getFileNameWithoutExtension(file) {
	return path.basename(file, path.extname(file));
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
 * @param {import('rollup').InputOption} entries
 * @param {string} distDir
 *
 * @returns {import('vite').UserConfig}
 */
export function getViteConfig(entries, distDir) {
	return {
		css: {
			transformer: "lightningcss",
			preprocessorOptions: {
				scss: {
					includePaths: [
						"assets/scss", // For shared SCSS files
						"Customizer/Controls", // For control-specific SCSS files
						".", // Project root as fallback
					],
					quietDeps: true,
				},
			},
		},
		build: {
			target: "es2020",
			outDir: distDir,
			emptyOutDir: false,
			// Ensure CSS is extracted to separate files
			cssCodeSplit: true, // Changed to true for multiple entries
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
				input: entries,
				output: {
					format: "iife",
					// Custom naming for each entry.
					entryFileNames: (chunkInfo) => {
						const fileName = getFileNameWithoutExtension(chunkInfo.name);
						return `${fileName}-min.js`;
					},
					assetFileNames: (assetInfo) => {
						console.log("assetInfo.names", assetInfo.names);

						if (assetInfo.name && path.extname(assetInfo.name) === ".css") {
							return `${getFileNameWithoutExtension(assetInfo.name)}-min.css`;
						}

						// return assetInfo.name;
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
