import { execSync } from "child_process";
import { readdirSync, existsSync } from "fs";
import { resolve } from "path";
import { getErrorMessage } from "./build-utils.mjs";

// Define asset directories to scan
const assetDirs = [
	"assets/js/site-jquery.js",
	"assets/js/site.js",
	"assets/scss/style.scss",
	"inc/customizer/js/customizer.ts",
	"inc/customizer/js/postmessage.ts",
	"Customizer/Panels/src/panel-types.ts", // Output/target dir should be "Customizer/Panels/dist"
	"Customizer/Sections/src/sections.ts", // Output/target dir should be "Customizer/Sections/dist"
];

const assetBuilds = [];

for (const assetDir of assetDirs) {
	const fullPath = resolve(process.cwd(), assetDir);

	if (!existsSync(fullPath)) {
		console.log(`Skipping ${assetDir} - directory not found`);
		continue;
	}

	const files = readdirSync(fullPath);
	const tsFiles = files.filter((file) => {
		return (
			(file.endsWith(".scss") ||
				file.endsWith(".js") ||
				file.endsWith(".ts") ||
				file.endsWith(".tsx")) &&
			!file.endsWith(".d.ts")
		);
	});

	for (const file of tsFiles) {
		const name = file
			.replace(/\.tsx?$/, "")
			.replace(/\.js$/, "")
			.replace(/\.scss$/, "");

		assetBuilds.push({
			name,
			path: assetDir,
			file,
		});
	}
}

if (assetBuilds.length === 0) {
	console.log("No asset files found in the specified directories");
	process.exit(0);
}

console.log(`Found ${assetBuilds.length} asset files:`);

assetBuilds.forEach(({ name, path, file }) => {
	console.log(`  - ${name} (${path}/${file})`);
});

for (const { name, path } of assetBuilds) {
	console.log(`\nBuilding ${name} from ${path}...`);

	try {
		execSync(`pnpm build-control --name=${name} --path=${path}`, {
			stdio: "inherit",
			cwd: process.cwd(),
		});
		console.log(`✅ ${name} built successfully`);
	} catch (error) {
		console.error(`❌ Failed to build ${name}:`, getErrorMessage(error));
	}
}

console.log("\n🎉 All assets build process completed!");
