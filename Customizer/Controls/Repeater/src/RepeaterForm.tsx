/**
 * The form of the repeater type (see repeater-control.tsx): rows of sub-fields that can be added, removed, reordered
 * (drag a row by its header) and opened/closed.
 *
 * Sub-field types: text-like inputs (text, url, link, email, tel, date, number), hidden, select (single or multiple)
 * and upload: what the theme, Premium (Adobe Fonts, Custom Fonts) and the child theme use. Any other type shows as a
 * text field (its value is kept and still cleaned by its type on save).
 *
 * The value is the setting's (useSettingValue), so the rows follow every change. What the form hands to the setting
 * is unchanged: the rows as URI-encoded JSON text (RepeaterSetting decodes it), each row with exactly the declared
 * fields (a field the row doesn't have gets the field's default); text-like fields and single selects as text, multiple
 * selects as a list of keys, an upload as the attachment id (text) once picked, "" once removed.
 */
import { useEffect, useRef, useState } from "@wordpress/element";
import jQuery from "jquery";
import { Notifications, ReactControlFormProps, useSettingValue } from "../../Base/src/react-base";
import { RepeaterField, RepeaterRowValue, WpbfCustomizeRepeaterControlParams, WpbfCustomizeRepeaterValue } from "./repeater-interface";

declare var wp: {
	media: any;
};

type Props = ReactControlFormProps<WpbfCustomizeRepeaterValue, WpbfCustomizeRepeaterControlParams>;

const textLikeTypes = ["text", "url", "link", "email", "tel", "date", "number"];

/**
 * The rows of a setting value: a list (as PHP hands it over) or the form's URI-encoded JSON text.
 */
function parseRows(value: WpbfCustomizeRepeaterValue): RepeaterRowValue[] {
	let rows: unknown = value;

	if ("string" === typeof value) {
		try {
			rows = value ? JSON.parse(decodeURI(value)) : [];
		} catch {
			rows = [];
		}
	}

	if (rows && "object" === typeof rows && !Array.isArray(rows)) rows = Object.values(rows);

	// Removed rows of old drafts were left as holes (null).
	return Array.isArray(rows) ? rows.filter((row) => row && "object" === typeof row) : [];
}

/**
 * The text of a value for a field (as the old template printed it).
 */
function asText(value: unknown): string {
	return null === value || "undefined" === typeof value || false === value ? "" : String(value);
}

export default function RepeaterForm({ control }: Props) {
	const params = control.params;
	const fields = params.fields && "object" === typeof params.fields ? params.fields : {};
	const l10n = params.l10n;

	const [value, setValue] = useSettingValue(control, params.value);
	const rows = parseRows(value);

	// Which rows are open (rows start closed; an added row starts open). Kept in step when rows are removed or moved.
	const [open, setOpen] = useState<boolean[]>([]);
	const [limitHit, setLimitHit] = useState(false);

	// Names of files picked in this session, by attachment id (the row stores the id only).
	const pickedFiles = useRef<Record<string, string>>({});

	const limit = "number" === typeof params.limit && params.limit > 0 ? params.limit : false;

	/**
	 * A row with exactly the declared fields: the row's value, or the field's default.
	 */
	const normalizeRow = (row: RepeaterRowValue) => {
		const normalized: RepeaterRowValue = {};

		for (const fieldId of Object.keys(fields)) {
			normalized[fieldId] = Object.prototype.hasOwnProperty.call(row, fieldId) ? row[fieldId] : fields[fieldId].default;
		}

		return normalized;
	};

	const save = (newRows: RepeaterRowValue[]) => {
		setValue(encodeURI(JSON.stringify(newRows.map(normalizeRow))));
	};

	// The latest rows for the sortable's handler (set up once).
	const latest = useRef({ rows, open, save });
	latest.current = { rows, open, save };

	const updateField = (rowIndex: number, fieldId: string, fieldValue: unknown) => {
		save(rows.map((row, i) => (i === rowIndex ? { ...normalizeRow(row), [fieldId]: fieldValue } : row)));
	};

	const addRow = () => {
		if (limit && rows.length >= limit) {
			setLimitHit(true);
			return;
		}

		const newOpen = rows.map((_, i) => !!open[i]);
		newOpen.push(true);
		setOpen(newOpen);
		save([...rows, {}]);
	};

	const removeRow = (rowIndex: number, li: HTMLElement) => {
		jQuery(li).slideUp(300, () => {
			// The element is reused for the next row: show it again.
			li.style.display = "";

			const { rows: currentRows, open: currentOpen, save: currentSave } = latest.current;

			setOpen(currentRows.map((_, i) => !!currentOpen[i]).filter((_, i) => i !== rowIndex));
			if (limit && currentRows.length - 1 < limit) setLimitHit(false);
			currentSave(currentRows.filter((_, i) => i !== rowIndex));
		});
	};

	const toggleRow = (rowIndex: number) => {
		const newOpen = rows.map((_, i) => !!open[i]);
		newOpen[rowIndex] = !newOpen[rowIndex];
		setOpen(newOpen);
	};

	// Reorder by dragging a row's header (jQuery UI sortable). The drop is undone in the DOM and redrawn by React in the
	// new order.
	const listRef = useRef<HTMLUListElement>(null);

	useEffect(() => {
		const list = listRef.current;
		if (!list || !jQuery.fn.sortable) return;

		const $list = jQuery(list);

		$list.sortable({
			handle: ".repeater-row-header",
			update: function () {
				const order = $list
					.children(".repeater-row")
					.map((_, el) => parseInt((el as HTMLElement).dataset.row || "0", 10))
					.get() as number[];

				$list.sortable("cancel");

				const { rows: currentRows, open: currentOpen, save: currentSave } = latest.current;

				setOpen(order.map((oldIndex) => !!currentOpen[oldIndex]));
				currentSave(order.map((oldIndex) => currentRows[oldIndex]));
			},
		});

		return () => {
			if ($list.sortable("instance")) $list.sortable("destroy");
		};
	}, []);

	/**
	 * Pick a file from the media library for an upload field.
	 */
	const pickFile = (rowIndex: number, fieldId: string) => {
		if (!wp.media) return;

		const field = fields[fieldId];
		const mimeType = "undefined" !== typeof field.mime_type ? field.mime_type : "image";

		const frame = wp.media({
			states: [
				new wp.media.controller.Library({
					library: wp.media.query({ type: mimeType }),
					multiple: false,
					date: false,
				}),
			],
		});

		frame.on("select", () => {
			const attachment = frame.state().get("selection").first().toJSON();

			pickedFiles.current[String(attachment.id)] = attachment.filename;
			latest.current.save(
				latest.current.rows.map((row, i) =>
					i === rowIndex ? { ...normalizeRow(row), [fieldId]: String(attachment.id) } : row,
				),
			);
			frame.close();
		});

		frame.open();
	};

	/**
	 * The row's label: the text of the label field when it has one, else "<label> <number>".
	 */
	const rowLabel = (row: RepeaterRowValue, rowIndex: number) => {
		const label = params.rowLabel || {};

		if ("field" === label.type && label.field && fields[label.field]) {
			const fieldValue = normalizeRow(row)[label.field];
			const type = fields[label.field].type;
			let text = "";

			if (textLikeTypes.includes(type) || "hidden" === type || !isKnownType(type)) {
				text = asText(fieldValue);
			} else if ("upload" === type) {
				text = asText(fieldValue && "object" === typeof fieldValue ? (fieldValue as any).id : fieldValue);
			}

			if ("" !== text) return text;
		}

		return `${label.value} ${rowIndex + 1}`;
	};

	const renderTitle = (field: RepeaterField) => (
		<>
			{field.label && <span className="customize-control-title" dangerouslySetInnerHTML={{ __html: field.label }} />}
			{field.description && (
				<span
					className="description customize-control-description"
					dangerouslySetInnerHTML={{ __html: field.description }}
				/>
			)}
		</>
	);

	const renderField = (row: RepeaterRowValue, rowIndex: number, field: RepeaterField) => {
		const fieldValue = row[field.id];

		if ("hidden" === field.type) {
			return <input type="hidden" data-field={field.id} value={asText(fieldValue)} />;
		}

		if ("select" === field.type) {
			const multiple = "undefined" !== typeof field.multiple && false !== field.multiple;
			const selected = multiple
				? (Array.isArray(fieldValue) ? fieldValue : asText(fieldValue) ? [fieldValue] : []).map(asText)
				: asText(fieldValue);

			return (
				<label>
					{renderTitle(field)}
					<select
						data-field={field.id}
						multiple={multiple}
						data-multiple={multiple ? String(field.multiple) : undefined}
						value={selected}
						onChange={(e) => {
							const select = e.target as HTMLSelectElement;
							updateField(
								rowIndex,
								field.id,
								multiple ? Array.from(select.selectedOptions).map((o) => o.value) : select.value,
							);
						}}
					>
						{Object.keys(field.choices || {}).map((key) => (
							<option key={key} value={key}>
								{field.choices[key]}
							</option>
						))}
					</select>
				</label>
			);
		}

		if ("upload" === field.type) {
			const isObject = fieldValue && "object" === typeof fieldValue;
			const id = isObject ? (fieldValue as any).id : fieldValue;
			const filename = isObject
				? (fieldValue as any).filename || asText(fieldValue)
				: (pickedFiles.current[asText(fieldValue)] ?? asText(fieldValue));

			return (
				<>
					<label>{renderTitle(field)}</label>

					<figure className="wpbf-file-attachment" data-placeholder={l10n.noFile}>
						{fieldValue ? (
							<span className="file">
								<span className="dashicons dashicons-media-default"></span> {filename}
							</span>
						) : (
							l10n.noFile
						)}
					</figure>

					<div className="actions">
						<button
							type="button"
							className={"button remove-button" + (fieldValue ? "" : " hidden")}
							onClick={() => updateField(rowIndex, field.id, "")}
						>
							{l10n.remove}
						</button>{" "}
						<button
							type="button"
							className="button upload-button"
							data-label={l10n.addFile}
							data-alt-label={l10n.changeFile}
							onClick={() => pickFile(rowIndex, field.id)}
						>
							{fieldValue ? l10n.changeFile : l10n.addFile}
						</button>{" "}
						<input
							type="hidden"
							className="hidden-field"
							value={asText(id || fieldValue)}
							data-field={field.id}
						/>
					</div>
				</>
			);
		}

		// Text-like fields, and any type this form doesn't have.
		const type = "link" === field.type ? "url" : textLikeTypes.includes(field.type) ? field.type : "text";
		const numberAttrs: Record<string, unknown> = {};

		if ("number" === field.type && field.properties) {
			for (const attr of ["min", "max", "step"]) {
				if ("undefined" !== typeof field.properties[attr]) numberAttrs[attr] = field.properties[attr];
			}
		}

		return (
			<label>
				{renderTitle(field)}
				<input
					type={type}
					value={asText(fieldValue)}
					data-field={field.id}
					{...numberAttrs}
					onChange={(e) => updateField(rowIndex, field.id, (e.target as HTMLInputElement).value)}
				/>
			</label>
		);
	};

	const titleShown = !!params.label;

	return (
		<>
			{!titleShown && <Notifications control={control} />}

			<label>
				{params.label && <span className="customize-control-title">{params.label}</span>}
				{titleShown && <Notifications control={control} />}
				{params.description && (
					<span
						className="description customize-control-description"
						dangerouslySetInnerHTML={{ __html: params.description }}
					/>
				)}
			</label>

			<ul className="repeater-fields" ref={listRef}>
				{rows.map((row, rowIndex) => {
					const normalized = normalizeRow(row);
					const isOpen = !!open[rowIndex];

					return (
						<li key={rowIndex} className={"repeater-row" + (isOpen ? "" : " minimized")} data-row={rowIndex}>
							<div className="repeater-row-header" onClick={() => toggleRow(rowIndex)}>
								<span className="repeater-row-label">{rowLabel(row, rowIndex)}</span>
								<i
									className={
										"dashicons repeater-minimize " + (isOpen ? "dashicons-arrow-up" : "dashicons-arrow-down")
									}
								></i>
							</div>
							<div className="repeater-row-content">
								{Object.keys(fields).map((fieldId) => {
									const field = { ...fields[fieldId], id: fieldId };

									return (
										<div
											key={fieldId}
											className={`repeater-field repeater-field-${field.type} repeater-field-${fieldId}`}
										>
											{renderField(normalized, rowIndex, field)}
										</div>
									);
								})}

								<button
									type="button"
									className="button-link repeater-row-remove"
									onClick={(e) => removeRow(rowIndex, (e.target as HTMLElement).closest("li") as HTMLElement)}
								>
									{l10n.remove}
								</button>
							</div>
						</li>
					);
				})}
			</ul>

			{false !== params.limit && (
				<p className={"limit" + (limitHit ? " highlight" : "")}>{l10n.limit}</p>
			)}

			<button type="button" className="button-secondary repeater-add" onClick={addRow}>
				{params.buttonLabel}
			</button>
		</>
	);
}

/**
 * Whether the form has its own field for a sub-field type.
 */
function isKnownType(type: string) {
	return textLikeTypes.includes(type) || ["hidden", "select", "upload"].includes(type);
}
