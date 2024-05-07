import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/interface";

export interface WpbfCustomizeRepeaterControlParams
	extends WpbfCustomizeControlParams<any> {
	fields: Record<string, any>;
	rowLabel: Record<string, string>;
	buttonLabel: string;
	limit: number | boolean;
}

export interface WpbfCustomizeRepeaterControl
	extends WpbfCustomizeControl<any, WpbfCustomizeRepeaterControlParams> {}

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
