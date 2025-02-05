import "./input-slider-control.scss";
import InputSliderControl from "./InputSliderControl";

if (window.wp.customize) {
	window.wp.customize.controlConstructor["wpbf-input-slider"] =
		InputSliderControl(window.wp.customize);
}
