import "./input-slider-control.scss";
import InputSliderControl from "./InputSliderControl";
import { WpbfCustomize } from "../../Base/src/base-interface";

declare var wp: {
	customize: WpbfCustomize;
};

// Register control type with Customizer.
wp.customize.controlConstructor["wpbf-input-slider"] = InputSliderControl;
