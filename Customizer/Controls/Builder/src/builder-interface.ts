import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/interface";

export interface WpbfCustomizeBuilderControlParams
	extends WpbfCustomizeControlParams<Record<string, any>> {
	mode: string;
	labelStyle: string;
	colorSwatches: string[];
	formComponent?: string;
}

export interface WpbfCustomizeBuilderControl
	extends WpbfCustomizeControl<
		Record<string, any>,
		WpbfCustomizeBuilderControlParams
	> {}
