import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/base-interface";

export interface WpbfEditorControlParams
	extends WpbfCustomizeControlParams<string> {
	default: string;
}

export interface WpbfEditorControl
	extends WpbfCustomizeControl<string, WpbfEditorControlParams> {}
