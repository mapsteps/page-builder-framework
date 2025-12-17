import SliderControl from "./SliderControl";

if (window.wp.customize) {
	window.wp.customize.controlConstructor["wpbf-slider"] = SliderControl(
		window.wp.customize,
	);
}
