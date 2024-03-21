import "./margin-padding-control.scss";
import MarginPaddingControl from "./MarginPaddingControl";
import { WpbfCustomize } from "../../Base/src/interface";
import { WpbfCustomizeMarginPaddingControl } from "./interface";

declare var wp: {
	customize: WpbfCustomize;
};

wp.customize.controlConstructor["wpbf-margin-padding"] =
	MarginPaddingControl as WpbfCustomizeMarginPaddingControl;

wp.customize.controlConstructor["wpbf-responsive-margin-padding"] =
	MarginPaddingControl as WpbfCustomizeMarginPaddingControl;
