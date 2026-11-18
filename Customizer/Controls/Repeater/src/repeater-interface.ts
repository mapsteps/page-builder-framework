import { WpbfCustomizeControl, WpbfCustomizeControlParams } from "../../Base/src/interface";

/**
 * One row: field id => value.
 */
export type RepeaterRowValue = Record<string, any>;

/**
 * The setting value: the rows as PHP hands them over (a list), or as the form hands them to the setting (the list as
 * URI-encoded JSON text, decoded by RepeaterSetting on the PHP side).
 */
export type WpbfCustomizeRepeaterValue = RepeaterRowValue[] | string;

/**
 * A sub-field as declared in the field's `fields` property (plus its id).
 */
export type RepeaterField = {
	id: string;
	type: string;
	label: string;
	description?: string;
	default: any;
	choices?: Record<string, string> | any;
	multiple?: number | boolean | string;
	mime_type?: string | string[];
	properties?: Record<string, any>;
	[key: string]: any;
};

export interface WpbfCustomizeRepeaterControlParams extends WpbfCustomizeControlParams<WpbfCustomizeRepeaterValue> {
	fields: Record<string, RepeaterField>;
	rowLabel: { type: string; value: string; field: string | false };
	buttonLabel: string;
	limit: number | boolean;
	l10n: {
		remove: string;
		noFile: string;
		addFile: string;
		changeFile: string;
		limit: string;
	};
}

export interface WpbfCustomizeRepeaterControl
	extends WpbfCustomizeControl<WpbfCustomizeRepeaterValue, WpbfCustomizeRepeaterControlParams> {}
