import "./margin-padding-control.scss";
import { WpbfCustomize } from "../../Base/src/interface";
import { createReactControl } from "../../Base/src/react-base";
import MarginPaddingForm from "./MarginPaddingForm";
import { MarginPaddingSettingValue, WpbfCustomizeMarginPaddingControlParams } from "./interface";

declare var wp: {
	customize: WpbfCustomize;
};

// One control for both margin/padding types; the form shows device buttons for the responsive one.
const MarginPaddingControl = createReactControl<MarginPaddingSettingValue, WpbfCustomizeMarginPaddingControlParams>(
	MarginPaddingForm,
);

wp.customize.controlConstructor["wpbf-margin-padding"] = MarginPaddingControl;
wp.customize.controlConstructor["wpbf-responsive-margin-padding"] = MarginPaddingControl;
