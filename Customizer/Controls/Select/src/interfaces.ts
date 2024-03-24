import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/interface";

export interface SelectControlProps {
	isMulti: boolean;
	maxSelections: number;
	placeholder: string;
	isClearable: boolean;
	messages: {
		maxLimitReached: string;
	};
}

export interface WpbfCustomizeSelectControlParams
	extends WpbfCustomizeControlParams<string | string[]> {
	isClearable: boolean;
	isMulti: boolean;
	placeholder: string;
	maxSelections: number;
	messages: Record<string, string>;
}

export interface WpbfCustomizeSelectControl
	extends WpbfCustomizeControl<
		string | string[],
		WpbfCustomizeSelectControlParams
	> {}

export interface WpbfCustomizeSelectOptionGroup {
	label: string;
	options: WpbfCustomizeSelectOptionObject[];
}

export interface WpbfCustomizeSelectOptionObject {
	label: string;
	value: any;
}
