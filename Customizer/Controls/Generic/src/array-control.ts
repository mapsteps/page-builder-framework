import { WpbfCustomize } from "../../Base/src/interface";
import ArrayControl from "./ArrayControl";

declare var wp: {
	customize: WpbfCustomize;
};

// Register control type with Customizer.
wp.customize.controlConstructor["wpbf-array"] = ArrayControl;
