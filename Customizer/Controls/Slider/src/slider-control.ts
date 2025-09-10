import "./slider-control.scss";
import SliderControl from "./SliderControl";
import { WpbfCustomize } from "../../Base/src/interface";
import { WpbfCustomizeSliderControl } from "./interface";

declare var wp: {
	customize: WpbfCustomize;
};

// Register control type with Customizer.
wp.customize.controlConstructor["wpbf-slider"] =
	SliderControl as WpbfCustomizeSliderControl;
