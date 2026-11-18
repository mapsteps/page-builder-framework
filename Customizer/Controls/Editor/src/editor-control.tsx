import "./editor-control.scss";
import { WpbfCustomize } from "../../Base/src/interface";
import { createReactControl } from "../../Base/src/react-base";
import EditorForm from "./EditorForm";
import { WpbfCustomizeEditorControlParams } from "./editor-interface";

declare var wp: {
	customize: WpbfCustomize;
};

wp.customize.controlConstructor["wpbf-editor"] = createReactControl<string, WpbfCustomizeEditorControlParams>(EditorForm);
