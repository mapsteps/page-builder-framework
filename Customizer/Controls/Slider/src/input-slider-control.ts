import "./input-slider-control.scss";
import InputSliderControl from "./InputSliderControl";

if (window.wp.customize) {
	// Register control type with Customizer.
	window.wp.customize.controlConstructor["wpbf-input-slider"] =
		InputSliderControl(window.wp.customize);
}
