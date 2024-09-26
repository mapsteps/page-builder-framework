import "./margin-padding-control.scss";
import MarginPaddingControl from "./MarginPaddingControl";

declare var wp: {
	customize: WpbfCustomize;
};

wp.customize.controlConstructor["wpbf-margin-padding"] = MarginPaddingControl;

wp.customize.controlConstructor["wpbf-responsive-margin-padding"] =
	MarginPaddingControl;
