import "./input-slider-control.scss";
import InputSliderControl from "./InputSliderControl";

declare var wp: {
	customize: WpbfCustomize;
};

// Register control type with Customizer.
wp.customize.controlConstructor["wpbf-input-slider"] = InputSliderControl;
