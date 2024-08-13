import "./builder-control.scss";
import { WpbfCustomize } from "../../Base/src/interface";
import HeaderBuilderControl from "./HeaderBuilderControl";

declare var wp: {
	customize: WpbfCustomize;
};

wp.customize.controlConstructor["wpbf-header-builder"] = HeaderBuilderControl;
