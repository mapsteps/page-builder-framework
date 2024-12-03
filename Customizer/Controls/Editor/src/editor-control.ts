import "./editor-control.scss";
import { WpbfEditorControl } from "./editor-interface";

declare var wp: {
	customize: WpbfCustomize;
	editor: any;
};

declare var tinyMCE: any;

/* global tinyMCE */
wp.customize.controlConstructor["wpbf-editor"] =
	wp.customize.wpbfDynamicControl.extend<WpbfEditorControl>({
		initWpbfControl: function (
			this: WpbfEditorControl,
			ctrl?: WpbfEditorControl,
		) {
			const control = ctrl || this;
			const element = control.container.find("textarea");
			const id = "wpbf-editor-" + control.id.replace("[", "").replace("]", "");

			const defaultParams = {
				tinymce: {
					wpautop: true,
				},
				quicktags: true,
				mediaButtons: true,
			};

			// Overwrite the default paramaters if choices is defined.
			if (wp.editor && wp.editor.initialize) {
				wp.editor.initialize(
					id,
					jQuery.extend({}, defaultParams, {
						tinymce: control.params.tinymce,
						quicktags: control.params.quicktags,
					}),
				);
			}

			const editor = tinyMCE.get(id);

			if (editor) {
				editor.onChange.add(function (ed: any) {
					ed.save();
					const content = editor.getContent();
					element.val(content).trigger("change");
					wp.customize.instance(control.id).set(content);
				});
			}
		},
	});
