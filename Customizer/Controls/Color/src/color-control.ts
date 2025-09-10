import "./color-control.scss";
import ColorControl from "./ColorControl";
import MulticolorControl from "./MulticolorControl";

// Register control type with Customizer.
if (window.wp.customize) {
	if (ColorControl) {
		window.wp.customize.controlConstructor["wpbf-color"] = ColorControl;
	}

	if (MulticolorControl) {
		window.wp.customize.controlConstructor["wpbf-multicolor"] =
			MulticolorControl;
	}
}
