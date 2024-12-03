import "./slider-control.scss";
import SliderControl from "./SliderControl";
import { WpbfSliderControl } from "./slider-interface";

declare var wp: {
	customize: WpbfCustomize;
};

// Register control type with Customizer.
wp.customize.controlConstructor["wpbf-slider"] =
	SliderControl as WpbfSliderControl;
