import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/base-interface";

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

export type SelectControlValue = string | string[];

export interface SelectControlParams
	extends WpbfCustomizeControlParams<SelectControlValue> {
	choices: SelectControlChoice[];
	searchable: boolean;
	clearable: boolean;
	multiple: boolean;
	placeholder: string;
	maxSelections: number;
	messages: {
		maxLimitReached: string;
	};
	choicesGlobalVar?: string;
	preventSave?: boolean;
}

export interface WpbfSelectControl
	extends WpbfCustomizeControl<SelectControlValue, SelectControlParams> {}
