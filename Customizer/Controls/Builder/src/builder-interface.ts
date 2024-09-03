import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/interface";

export type BuilderWidget = {
	key: string;
	label: string;
	section: string;
};

export type BuilderColumn = {
	key: string;
	label: string;
};

export type BuilderRow = {
	key: string;
	label: string;
	columns: BuilderColumn[];
};

export type BuilderValue = Record<string, Record<string, string[]>>;

export interface WpbfCustomizeBuilderControlParams
	extends WpbfCustomizeControlParams<BuilderValue> {
	builder: {
		availableWidgets: BuilderWidget[];
		availableRows: BuilderRow[];
	};
}
export interface WpbfCustomizeBuilderControl
	extends WpbfCustomizeControl<
		BuilderValue,
		WpbfCustomizeBuilderControlParams
	> {}
