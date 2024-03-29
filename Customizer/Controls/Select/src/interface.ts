import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
	WpbfCustomizeSetting,
} from "../../Base/src/interface";

export interface SelectControlProps {
	control: WpbfCustomizeSelectControl;
	customizerSetting: WpbfCustomizeSetting<SelectControlValue>;
	setNotificationContainer: any;
	value: LabelValuePair | LabelValuePair[] | undefined;
	inputId?: string;
	label?: string;
	description?: string;
	isMulti: boolean;
	options: LabelValuePair[] & SelectGroupedOptions[];
	isOptionDisabled?: (option: any) => boolean;
	maxSelections: number;
	placeholder?: string;
	isClearable: boolean;
	openMenuOnFocus?: boolean;
	messages: {
		maxLimitReached: string;
	};
}

export interface LabelValuePair {
	label: string;
	value: string;
}

export type SelectGroupedOptions = {
	label: string;
	options: LabelValuePair[];
};

export type SelectOptions = {
	label: string;
	value?: string;
	options?: LabelValuePair[];
}[];

export type SelectControlValue = string | string[];

export interface SelectControlParams
	extends WpbfCustomizeControlParams<SelectControlValue> {
	choices: SelectOptions;
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
