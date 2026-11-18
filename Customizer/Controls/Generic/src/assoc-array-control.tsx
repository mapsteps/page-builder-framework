/**
 * The assoc-array type: the label and description of a typography field, which holds the field's whole value (an
 * array of font properties). The font family and variant are their own select controls (typography-control.ts ties
 * them to this value); this control only shows the label and the value's parts.
 */
import { WpbfCustomize } from "../../Base/src/interface";
import { createReactControl } from "../../Base/src/react-base";
import AssocArrayForm from "./AssocArrayForm";
import { AssocArrayControlParams } from "./interface";

declare var wp: {
	customize: WpbfCustomize;
};

wp.customize.controlConstructor["wpbf-assoc-array"] = createReactControl<Record<string, any>, AssocArrayControlParams>(
	AssocArrayForm,
);
