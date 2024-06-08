import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/interface";

export type ChildSelectControlChoice = {
	text: string;
	id: string;
	disabled?: boolean;
	selected?: boolean;
};

export type SelectControlChoice = {
	text: string;
	id?: string;
	disabled?: boolean;
	selected?: boolean;
	children?: ChildSelectControlChoice[];
};

export type SelectControlChoices = SelectControlChoice[];

export type SelectControlValue = string | string[];

export interface SelectControlParams
	extends WpbfCustomizeControlParams<SelectControlValue> {
	choices: SelectControlChoices;
	isClearable: boolean;
	isMulti: boolean;
	placeholder: string;
	maxSelections: number;
	messages: {
		maxLimitReached: string;
	};
}

export interface WpbfCustomizeSelectControl
	extends WpbfCustomizeControl<SelectControlValue, SelectControlParams> {}
