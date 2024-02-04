import "./slider-control.scss";
import SliderControl from "./SliderControl";
import {WpbfCustomize, WpbfCustomizeControl} from "../../Base/src/interfaces";

declare var wp: {
	customize: WpbfCustomize;
};

// Register control type with Customizer.
wp.customize.controlConstructor['wpbf-slider'] = SliderControl as WpbfCustomizeControl;