import "./dimension-control.scss";
import { WpbfCustomize } from "../../Base/src/interface";
import { createReactControl } from "../../Base/src/react-base";
import DimensionForm from "./DimensionForm";
import { DimensionValue, WpbfCustomizeDimensionControlParams } from "./interface";

declare var wp: {
	customize: WpbfCustomize;
};

wp.customize.controlConstructor["wpbf-dimension"] = createReactControl<DimensionValue, WpbfCustomizeDimensionControlParams>(
	DimensionForm,
);
