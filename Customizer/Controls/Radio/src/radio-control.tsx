import "./radio-control.scss";
import { WpbfCustomize } from "../../Base/src/interface";
import { createReactControl } from "../../Base/src/react-base";
import RadioForm from "./RadioForm";
import { WpbfCustomizeRadioControlParams } from "./interface";

declare var wp: {
	customize: WpbfCustomize;
};

// One control for the three radio types; the form picks its layout from the type.
const RadioControl = createReactControl<unknown, WpbfCustomizeRadioControlParams>(RadioForm);

wp.customize.controlConstructor["wpbf-radio"] = RadioControl;
wp.customize.controlConstructor["wpbf-radio-buttonset"] = RadioControl;
wp.customize.controlConstructor["wpbf-radio-image"] = RadioControl;
