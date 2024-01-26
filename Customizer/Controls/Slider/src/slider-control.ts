import "./slider-control.scss";
import {Customize} from "wordpress__customize-browser/Customize";

declare var wp: {
	customize: Customize;
};

// Register control type with Customizer.
wp.customize.controlConstructor['kirki-slider'] = KirkiSliderControl;