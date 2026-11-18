import { Value } from "wordpress__customize-browser/Value";
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
		noResults?: string;
		clear?: string;
		remove?: string;
	};
}

export interface WpbfCustomizeSelectControl
	extends WpbfCustomizeControl<SelectControlValue, SelectControlParams> {
	/** The options shown (params.choices, or what setChoices() put there). */
	choicesValue?: Value<SelectControlChoices>;
	/** The value shown: follows the setting; showValue() sets it without the setting. */
	shownValue?: Value<SelectControlValue>;
	setChoices?: (choices: SelectControlChoices) => void;
	showValue?: (value: SelectControlValue) => void;
}
