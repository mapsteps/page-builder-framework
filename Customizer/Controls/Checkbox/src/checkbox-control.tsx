import "./toggle-control.scss";
import { WpbfCustomize } from "../../Base/src/interface";
import { createReactControl } from "../../Base/src/react-base";
import CheckboxForm from "./CheckboxForm";
import { WpbfCustomizeCheckboxControlParams } from "./interface";

declare var wp: {
	customize: WpbfCustomize;
};

// One control for both checkbox types; the form picks its layout from the type.
const CheckboxControl = createReactControl<unknown, WpbfCustomizeCheckboxControlParams>(CheckboxForm);

wp.customize.controlConstructor["wpbf-checkbox"] = CheckboxControl;
wp.customize.controlConstructor["wpbf-toggle"] = CheckboxControl;
