import ResponsiveInputSliderControl from "./ResponsiveInputSliderControl";

if (window.wp.customize) {
	// Register control type with Customizer.
	window.wp.customize.controlConstructor["wpbf-responsive-input-slider"] =
		ResponsiveInputSliderControl(window.wp.customize);
}
