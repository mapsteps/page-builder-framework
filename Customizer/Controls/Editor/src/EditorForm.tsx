/**
 * The form of the editor type (see editor-control.tsx): label and description, then WordPress' editor (Visual and
 * Code tabs). Saves the editor's HTML.
 *
 * React renders the label; the editor's textarea is added next to it and handed to `wp.editor.initialize()`, which
 * builds the editor around it (outside React, which never touches those nodes).
 */
import { useLayoutEffect } from "@wordpress/element";
import { WpbfCustomize } from "../../Base/src/interface";
import { Notifications, ReactControlFormProps, parseAttrs, useSettingValue } from "../../Base/src/react-base";
import { WpbfCustomizeEditorControlParams } from "./editor-interface";

declare var wp: {
	customize: WpbfCustomize;
	editor?: {
		initialize: (id: string, settings: Record<string, any>) => void;
		remove: (id: string) => void;
	};
};

declare var tinyMCE: any;

type Props = ReactControlFormProps<string, WpbfCustomizeEditorControlParams>;

export default function EditorForm({ control }: Props) {
	const params = control.params;
	const [value, setValue] = useSettingValue(control, params.value);
	const editorId = "wpbf-editor-" + control.id.replace("[", "").replace("]", "");

	useLayoutEffect(() => {
		const container = control.container[0];
		const textarea = document.createElement("textarea");

		textarea.id = editorId;

		for (const [name, attrValue] of parseAttrs(params.inputAttrs)) {
			if ("id" !== name) textarea.setAttribute(name, attrValue);
		}

		// As the old template printed it (the textarea's text, which is also its value).
		textarea.textContent = null === params.value || "undefined" === typeof params.value ? "" : String(params.value);
		container.appendChild(textarea);

		// Typing in the Code tab.
		const onType = () => setValue(textarea.value);
		textarea.addEventListener("input", onType);
		textarea.addEventListener("change", onType);

		if (wp.editor && wp.editor.initialize) {
			wp.editor.initialize(
				editorId,
				jQuery.extend(
					{},
					{ tinymce: { wpautop: true }, quicktags: true, mediaButtons: true },
					{ tinymce: params.tinymce, quicktags: params.quicktags },
				),
			);
		}

		// Changes in the Visual tab.
		const editor = "undefined" !== typeof tinyMCE ? tinyMCE.get(editorId) : null;

		if (editor) {
			editor.onChange.add(function (ed: any) {
				ed.save();
				setValue(editor.getContent());
			});
		}

		return () => {
			textarea.removeEventListener("input", onType);
			textarea.removeEventListener("change", onType);
			wp.editor?.remove?.(editorId);
			textarea.remove();
		};
		// eslint-disable-next-line react-hooks/exhaustive-deps
	}, [control]);

	// Changes from elsewhere (a reset, a restored draft): show them in both tabs.
	useLayoutEffect(() => {
		const text = null === value || "undefined" === typeof value ? "" : String(value);
		const textarea = document.getElementById(editorId) as HTMLTextAreaElement | null;
		const editor = "undefined" !== typeof tinyMCE ? tinyMCE.get(editorId) : null;

		if (textarea && textarea.value !== text) textarea.value = text;
		if (editor && !editor.isHidden() && editor.getContent() !== text) editor.setContent(text);
	}, [value]);

	// The notifications go where core used to put them: after the title, or first when there's no title.
	return (
		<>
			{!params.label && <Notifications control={control} />}

			<label>
				{params.label && (
					<span className="customize-control-title" dangerouslySetInnerHTML={{ __html: params.label }} />
				)}

				{params.label && <Notifications control={control} />}

				{params.description && (
					<span
						className="description customize-control-description"
						dangerouslySetInnerHTML={{ __html: params.description }}
					/>
				)}
			</label>
		</>
	);
}
