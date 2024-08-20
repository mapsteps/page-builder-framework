import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/interface";

export interface WpbfCustomizeBuilderControlParams
	extends WpbfCustomizeControlParams<Record<string, any>> {
	headerBuilder: {
		availableRows: Record<string, string>;
		availableWidgets: Record<string, string>;
	};
}
export interface WpbfCustomizeBuilderControl
	extends WpbfCustomizeControl<
		Record<string, any>,
		WpbfCustomizeBuilderControlParams
	> {}
