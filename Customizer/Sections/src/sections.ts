import setupSectionDependencies from "./section-dependencies";
import { setupSectionTypes } from "./section-types";
import "./sections.scss";

window.wp.customize?.bind("ready", () => {
	if (!window.wp.customize) return;
	setupSectionTypes(window.wp.customize);
});

if (window.wpbfCustomizerSectionDependencies) {
	setupSectionDependencies(window.wpbfCustomizerSectionDependencies);
}
