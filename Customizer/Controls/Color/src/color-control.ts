import "./color-control.scss";
import { WpbfCustomize } from "../../Base/src/interface";
import { createReactControl } from "../../Base/src/react-base";
import ColorForm from "./ColorForm";
import { WpbfCustomizeColorControlParams, WpbfCustomizeColorControlValue } from "./interface";

declare var wp: {
	customize: WpbfCustomize;
};

wp.customize.controlConstructor["wpbf-color"] = createReactControl<
	WpbfCustomizeColorControlValue,
	WpbfCustomizeColorControlParams
>(ColorForm);
