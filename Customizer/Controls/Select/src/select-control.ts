import "./select-control.scss";
import { WpbfCustomize } from "../../Base/src/interface";
import SelectControl from "./SelectControl";

declare var wp: {
	customize: WpbfCustomize;
};

wp.customize.controlConstructor["wpbf-select"] = SelectControl;
