import "./select-control.scss";
import {WpbfCustomize} from "../../Base/src/interface";
import SelectControl from "./SelectControl";
import {WpbfCustomizeSelectControl} from "./interfaces";

declare var wp: {
	customize: WpbfCustomize;
};

wp.customize.controlConstructor['wpbf-select'] = SelectControl as WpbfCustomizeSelectControl;
