import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/interface";

export interface WpbfCustomizeSortableControlParams
	extends WpbfCustomizeControlParams<any[]> {}

export interface WpbfCustomizeSortableControl
	extends WpbfCustomizeControl<any[], WpbfCustomizeSortableControlParams> {
}
