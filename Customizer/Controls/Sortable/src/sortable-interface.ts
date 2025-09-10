import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/base-interface";

export interface WpbfSortableControlParams
	extends WpbfCustomizeControlParams<any[]> {}

export interface WpbfSortableControl
	extends WpbfCustomizeControl<any[], WpbfSortableControlParams> {}
