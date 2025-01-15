import "./slider-control.scss";
import SliderControl from "./SliderControl";

if (window.wp.customize) {
	// Register control type with Customizer.
	window.wp.customize.controlConstructor["wpbf-slider"] = SliderControl(
		window.wp.customize,
	);
}
