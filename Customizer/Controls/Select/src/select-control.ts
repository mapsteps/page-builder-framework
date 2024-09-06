import "./select-control.scss";
import { WpbfCustomize } from "../../Base/src/base-interface";
import SelectControl from "./SelectControl";

declare var wp: {
	customize: WpbfCustomize;
};

wp.customize.controlConstructor["wpbf-select"] = SelectControl;
