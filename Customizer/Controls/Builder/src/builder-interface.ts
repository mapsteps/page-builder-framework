import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/base-interface";

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

export type BuilderSidebar = {
	key: string;
	label: string;
}

export type BuilderValue = Record<string, Record<string, string[]>>;

export interface WpbfBuilderControlParams
	extends WpbfCustomizeControlParams<BuilderValue> {
	builder: {
		availableWidgets: BuilderWidget[];
		activeWidgetKeys: string[];
		availableRows: BuilderRow[];
	};
}
export interface WpbfBuilderControl
	extends WpbfCustomizeControl<BuilderValue, WpbfBuilderControlParams> {}
