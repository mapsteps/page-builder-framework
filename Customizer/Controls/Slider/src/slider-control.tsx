import "./slider-control.scss";
import { WpbfCustomize } from "../../Base/src/interface";
import { createReactControl } from "../../Base/src/react-base";
import SliderForm from "./SliderForm";
import { SliderSettingValue, WpbfCustomizeSliderControlParams } from "./interface";

declare var wp: {
	customize: WpbfCustomize;
};

// One control for the three slider types; the form picks its layout from the type.
const SliderControl = createReactControl<SliderSettingValue, WpbfCustomizeSliderControlParams>(SliderForm);

wp.customize.controlConstructor["wpbf-slider"] = SliderControl;
wp.customize.controlConstructor["wpbf-input-slider"] = SliderControl;
wp.customize.controlConstructor["wpbf-responsive-input-slider"] = SliderControl;
