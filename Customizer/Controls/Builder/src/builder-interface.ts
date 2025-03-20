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

export type ResponsiveBuilderValue =
	| {
			desktop: {
				sidebar: string[];
				rows: {
					[rowKey: string]: {
						[columnKey: string]: string[];
					};
				};
			};
			mobile: {
				sidebar: string[];
				rows: {
					[rowKey: string]: {
						[columnKey: string]: string[];
					};
				};
			};
	  }
	| null
	| undefined
	| "";

export interface WpbfResponsiveBuilderControlParams
	extends WpbfCustomizeControlParams<ResponsiveBuilderValue> {
	builder: {
		desktop: {
			availableWidgets: BuilderWidget[];
			activeWidgetKeys: string[];
			availableSlots: {
				sidebar: {
					key: string;
					label: string;
				};
				rows: BuilderRow[];
			};
		};
		mobile: {
			availableWidgets: BuilderWidget[];
			activeWidgetKeys: string[];
			availableSlots: {
				sidebar: {
					key: string;
					label: string;
				};
				rows: BuilderRow[];
			};
		};
	};
}

export interface WpbfResponsiveBuilderControl
	extends WpbfCustomizeControl<
		ResponsiveBuilderValue,
		WpbfResponsiveBuilderControlParams
	> {}
