import {WpbfCustomizeControl} from "../../Base/src/interfaces";

export interface SelectControlProps {
	isMulti: boolean;
	maxSelections: number;
	placeholder: string;
	isClearable: boolean;
	messages: {
		maxLimitReached: string;
	}
}

export interface WpbfCustomizeSelectControl extends WpbfCustomizeControl {
	isMulti: () => boolean;
	isOptionDisabled: (option: any) => boolean;
	disabledSelectOptions: any[],
	doSelectAction: (action: any, args: any) => void;
	formattedOptions: any[];
	formatOptions: () => void;
	getFormattedOptions: () => any;
	getOptionProps: (value: any) => any[];
}