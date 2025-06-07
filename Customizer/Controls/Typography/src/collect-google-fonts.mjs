import ky from "ky";
import { promises as fs } from "fs";
import manifest from "../../../../manifest.json" with { type: "json" };

const distDir = "./Customizer/Controls/Typography/webfonts";
const alphaJsonFilePath = `${distDir}/webfonts-alpha.json`;
const popularityJsonFilePath = `${distDir}/webfonts-popularity.json`;
const trendingJsonFilePath = `${distDir}/webfonts-trending.json`;

/**
 * Function to read JSON files asynchronously.
 *
 * @param {string} filePath - The path to the file to read.
 * @returns {Promise<*>} The parsed JSON data.
 */
async function readJsonFile(filePath) {
	const data = await fs.readFile(filePath, "utf8");
	return JSON.parse(data);
}

/**
 * Function to delete JSON file asynchronously.
 *
 * @param {string} filePath - The path to the file to delete.
 */
async function deleteJsonFile(filePath) {
	try {
		await fs.unlink(filePath);
		console.log(`Deleted JSON file: ${filePath}`);
	} catch (error) {
		console.error("Failed to delete JSON file:", error);
		throw error;
	}
}

/**
 * Processes Google Fonts data.
 *
 * @returns {Promise<void>}
 */
async function processGoogleFonts() {
	const fontFiles = {};
	const fontNames = [];
	const finalObject = {
		items: {},
		order: {
			alpha: [],
			popularity: [],
			trending: [],
		},
	};

	try {
		const alphaFonts = await readJsonFile(alphaJsonFilePath);
		const popularityFonts = await readJsonFile(popularityJsonFilePath);
		const trendingFonts = await readJsonFile(trendingJsonFilePath);

		for (const item of alphaFonts.items) {
			finalObject.order.alpha.push(item.family);
		}

		for (let i = 0; i < popularityFonts.items.length; i++) {
			const family = popularityFonts.items[i].family;
			const variants = popularityFonts.items[i].variants.sort();

			finalObject.items[family] = {
				family,
				category: popularityFonts.items[i].category,
				variants,
			};

			finalObject.order.popularity.push(family);
			fontNames.push(family);
			fontFiles[family] = popularityFonts.items[i].files;
		}

		for (const item of trendingFonts.items) {
			finalObject.order.trending.push(item.family);
		}

		const finalJSON = JSON.stringify(finalObject);

		await fs.writeFile(`${distDir}/webfonts.json`, finalJSON);

		await fs.writeFile(
			`${distDir}/webfont-names.json`,
			JSON.stringify(fontNames),
		);

		await fs.writeFile(
			`${distDir}/webfont-files.json`,
			JSON.stringify(fontFiles),
		);

		console.log("Processed Google Fonts data saved successfully.");
	} catch (error) {
		console.error("Failed to process Google Fonts data:", error);
		throw error;
	}
}

/**
 * Executes the script to fetch, process, and save Google Fonts data.
 *
 * @returns {Promise<void>}
 */
async function run() {
	try {
		await deleteJsonFile(`${distDir}/webfonts.json`);
		await deleteJsonFile(`${distDir}/webfont-names.json`);
		await deleteJsonFile(`${distDir}/webfont-files.json`);

		const sortByOptions = ["alpha", "popularity", "trending"];

		for (const sortBy of sortByOptions) {
			await fetchAndSaveGoogleFontsData(sortBy);
		}

		await processGoogleFonts();

		// Delete the un-used JSON files.
		for (const sortBy of sortByOptions) {
			await deleteJsonFile(`${distDir}/webfonts-${sortBy}.json`);
		}
	} catch (error) {
		console.error("Error:", error);
		process.exit(1);
	}
}

/**
 * Fetches and saves Google Fonts data to a file.
 *
 * @param {string} sortBy - The sorting criteria for the Google Fonts data ('alpha', 'popularity', 'trending').
 * @returns {Promise<void>}
 */
async function fetchAndSaveGoogleFontsData(sortBy) {
	try {
		const response = await ky.get(
			`https://www.googleapis.com/webfonts/v1/webfonts?sort=${sortBy}&key=${manifest.googlefonts.apiKey}`,
		);
		const data = await response.json();
		await fs.writeFile(
			`${distDir}/webfonts-${sortBy}.json`,
			JSON.stringify(data),
		);
		console.log(
			`Google Fonts data sorted by ${sortBy} saved to ${distDir}/webfonts-${sortBy}.json`,
		);
	} catch (error) {
		console.error("Failed to fetch and save Google Fonts data:", error);
		throw error;
	}
}

run();
