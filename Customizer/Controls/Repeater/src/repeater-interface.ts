import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/interface";

/**
 * The setting value returned via PHP will be associative array
 * because we handle it via PHP in `RepeaterSetting` class.
 *
 * TS type equivalent of that assoc-array is Record<string, any>.
 *
 * But the control.setting.get() in JS will return string
 * because it will be taken from the linked (hidden) setting field.
 */
export type WpbfCustomizeRepeaterValue = Record<string, any>[] | string;

export interface WpbfCustomizeRepeaterControlParams
	extends WpbfCustomizeControlParams<Record<string, any>[]> {
	fields: Record<string, Record<string, any>>;
	rowLabel: Record<string, string>;
	buttonLabel: string;
	limit: number | boolean;
}

export interface WpbfCustomizeRepeaterControl
	extends WpbfCustomizeControl<
		WpbfCustomizeRepeaterValue,
		WpbfCustomizeRepeaterControlParams
	> {
	rows?: WpbfRepeaterRow[];
}

export interface WpbfRepeaterRow {
	rowIndex: number;
	container: JQuery<HTMLElement>;
	label: Record<string, string>;
	header: JQuery<HTMLElement>;
	toggleMinimize: () => void;
	remove: () => void;
	updateLabel: () => void;
	setRowIndex: (rowNum: number) => void;
}

export interface RepeaterImageSelectOptions {
	handles: boolean;
	keys: boolean;
	instance: boolean;
	persistent: boolean;
	imageWidth: string | number;
	imageHeight: string | number;
	aspectRatio: string;
	maxHeight: number | boolean;
	maxWidth: number | boolean;
	x1: number;
	y1: number;
	x2: number;
	y2: number;
}
