import "./color-control.scss";
import ColorControl from "./ColorControl";

// Register control type with Customizer.
if (window.wp.customize) {
	window.wp.customize.controlConstructor["wpbf-color"] = ColorControl(
		window.wp.customize,
	);
}
