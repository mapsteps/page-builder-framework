import { WpbfCustomizeControl, WpbfCustomizeControlParams } from "../../Base/src/interface";

export interface WpbfCustomizeEditorControlParams extends WpbfCustomizeControlParams<string> {
	default: string;

	// Settings for wp.editor.initialize(): true, false or TinyMCE / Quicktags settings.
	tinymce: boolean | Record<string, any>;
	quicktags: boolean | Record<string, any>;
}

export interface WpbfCustomizeEditorControl extends WpbfCustomizeControl<string, WpbfCustomizeEditorControlParams> {}
