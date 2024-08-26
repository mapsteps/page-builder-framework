import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/interface";

export type HeaderBuilderWidget = {
	key: string;
	label: string;
};

export type HeaderBuilderColumn = {
	key: string;
	label: string;
	widgets: string[];
};

export type HeaderBuilderRow = {
	key: string;
	label: string;
	columns: HeaderBuilderColumn[];
};

export type HeaderBuilderValue = Record<string, Record<string, string[]>>;

export interface WpbfCustomizeBuilderControlParams
	extends WpbfCustomizeControlParams<HeaderBuilderValue> {
	headerBuilder: {
		availableWidgets: HeaderBuilderWidget[];
		availableRows: HeaderBuilderRow[];
	};
}
export interface WpbfCustomizeBuilderControl
	extends WpbfCustomizeControl<
		HeaderBuilderValue,
		WpbfCustomizeBuilderControlParams
	> {}
