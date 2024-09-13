import "./color-control.scss";
import ColorControl from "./ColorControl";
import MulticolorControl from "./MulticolorControl";

// Register control type with Customizer.
if (window.wp.customize) {
	window.wp.customize.controlConstructor["wpbf-color"] = ColorControl(
		window.wp.customize,
	);

	window.wp.customize.controlConstructor["wpbf-multicolor"] = MulticolorControl(
		window.wp.customize,
	);
}
