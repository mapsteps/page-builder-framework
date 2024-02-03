import {WpbfCustomizeControl} from "../../Base/src/interfaces";

export interface SelectControlProps {
	isMulti: boolean;
	maxSelectionNumber: number;
	placeholder: string;
	isClearable: boolean;
	messages: {
		maxLimitReached: string;
	}
}

export interface WpbfCustomizeSelectControl extends WpbfCustomizeControl {
	getFormattedOptions: () => any;
	getOptionProps: (value: any) => any[];
}