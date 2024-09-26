import "./select-control.scss";
import SelectControl from "./SelectControl";

declare var wp: {
	customize: WpbfCustomize;
};

wp.customize.controlConstructor["wpbf-select"] = SelectControl;
