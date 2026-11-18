import "./repeater-control.scss";
import { WpbfCustomize } from "../../Base/src/interface";
import { createReactControl } from "../../Base/src/react-base";
import RepeaterForm from "./RepeaterForm";
import { WpbfCustomizeRepeaterControlParams, WpbfCustomizeRepeaterValue } from "./repeater-interface";

declare var wp: {
	customize: WpbfCustomize;
};

wp.customize.controlConstructor["wpbf-repeater"] = createReactControl<
	WpbfCustomizeRepeaterValue,
	WpbfCustomizeRepeaterControlParams
>(RepeaterForm);
