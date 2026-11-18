import { WpbfCustomize } from "../../Base/src/interface";
import { createReactControl } from "../../Base/src/react-base";
import ImageForm from "./ImageForm";
import { WpbfCustomizeImageControlParams, WpbfCustomizeImageControlValue } from "./image-interface";

declare var wp: {
	customize: WpbfCustomize;
};

wp.customize.controlConstructor["wpbf-image"] = createReactControl<
	WpbfCustomizeImageControlValue,
	WpbfCustomizeImageControlParams
>(ImageForm);
