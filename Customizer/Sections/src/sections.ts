import setupSectionDependencies from "./section-dependencies";
import { setupSectionTypes } from "./section-types";
import "./sections.scss";

window.wp.customize?.bind("ready", () => {
	if (!window.wp.customize) return;
	setupSectionTypes(window.wp.customize);
});

if (window.wp.customize && window.wpbfCustomizerSectionDependencies) {
	setupSectionDependencies(
		window.wp.customize,
		window.wpbfCustomizerSectionDependencies,
	);
}
