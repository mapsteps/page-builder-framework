import { WpbfCustomize } from "../../Base/src/interface";
import { createReactControl } from "../../Base/src/react-base";
import GenericForm from "./GenericForm";
import { GenericSettingValue, WpbfCustomizeGenericControlParams } from "./interface";

declare var wp: {
	customize: WpbfCustomize;
};

// One control for both generic types; the form picks its layout from the type.
const GenericControl = createReactControl<GenericSettingValue, WpbfCustomizeGenericControlParams>(GenericForm);

wp.customize.controlConstructor["wpbf-generic"] = GenericControl;
wp.customize.controlConstructor["wpbf-responsive-generic"] = GenericControl;
