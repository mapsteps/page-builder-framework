import ResponsiveInputSliderControl from "./ResponsiveInputSliderControl";

declare var wp: {
	customize: WpbfCustomize;
};

// Register control type with Customizer.
wp.customize.controlConstructor["wpbf-responsive-input-slider"] =
	ResponsiveInputSliderControl;
