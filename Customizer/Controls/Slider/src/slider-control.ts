import "./slider-control.scss";
import {Customize} from "wordpress__customize-browser/Customize";
import SliderControl from "./SliderControl";

declare var wp: {
	customize: Customize;
};

// Register control type with Customizer.
wp.customize.controlConstructor['kirki-slider'] = SliderControl;