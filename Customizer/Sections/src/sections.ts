import { setupSectionTypes } from "./section-types";
import "./sections.scss";

window.wp.customize?.bind("ready", () => {
	if (!window.wp.customize) return;
	setupSectionTypes(window.wp.customize);
});
