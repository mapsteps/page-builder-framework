import {
	WpbfCustomizeControl,
	WpbfCustomizeSetting,
} from "../../Base/src/interfaces";

export interface WpbfCustomizeSortableControl extends WpbfCustomizeControl {
	prototype: WpbfCustomizeSortableControl;
	setting: WpbfCustomizeSetting<any[]>;
	updateComponentState?: (val: any[]) => void;
	getNewValue: () => any[];

	extend(protoProps: object, classProps?: object): WpbfCustomizeSortableControl;
}
