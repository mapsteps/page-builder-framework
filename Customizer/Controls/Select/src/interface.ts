import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
	WpbfCustomizeSetting,
} from "../../Base/src/interface";

export interface SelectControlProps {
	control: WpbfCustomizeSelectControl;
	customizerSetting: WpbfCustomizeSetting<SelectControlValue>;
	setNotificationContainer: any;
	value: SelectControlValue;
	inputId?: string;
	label?: string;
	description?: string;
	isMulti: boolean;
	formattedOptions: LabelValuePair[] | SelectGroupedOptions[];
	isOptionDisabled?: (option: any) => boolean;
	maxSelections: number;
	placeholder: string;
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

/**
 * The `SelectOptions` type are built based on:
 * - Kirki docs: https://docs.themeum.com/kirki/controls/select/
 * - And Ari's comment (for options group): https://github.com/themeum/kirki/issues/1120#issuecomment-304480821
 */
export type SelectOptions = Record<
	string,
	string | Array<string | Record<string, string>>
>;

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
