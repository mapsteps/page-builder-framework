import {
	WpbfCustomizeControl,
	WpbfCustomizeSetting,
} from "../../Base/src/interface";

export interface WpbfCustomizeSortableControl extends WpbfCustomizeControl {
	prototype: WpbfCustomizeSortableControl;
	setting: WpbfCustomizeSetting<any[]>;
	updateComponentState?: (val: any[]) => void;
	getNewValue: () => any[];
}
