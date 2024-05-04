import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/interface";

export interface WpbfCustomizeEditorControlParams
	extends WpbfCustomizeControlParams<string> {
	default: string;
}

export interface WpbfCustomizeEditorControl
	extends WpbfCustomizeControl<string, WpbfCustomizeEditorControlParams> {}
