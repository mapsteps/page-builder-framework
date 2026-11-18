/**
 * The form of the checkbox types (one control, see checkbox-control.tsx):
 *
 * - wpbf-checkbox: a plain checkbox with its label.
 * - wpbf-toggle: a toggle, or with `checkboxType` "switch" a switch with on/off labels.
 *
 * Both save true or false. Each keeps the markup of its old template.
 */
import { Notifications, ReactControlFormProps, useExtraAttrs, useSettingValue } from "../../Base/src/react-base";
import { WpbfCustomizeCheckboxControlParams } from "./interface";

type Props = ReactControlFormProps<unknown, WpbfCustomizeCheckboxControlParams>;

export default function CheckboxForm({ control }: Props) {
	const params = control.params;
	const [value, setValue] = useSettingValue(control, params.value);
	const inputId = `_customize-input-${params.id}`;

	const onChange = (e: { target: HTMLInputElement }) => setValue(e.target.checked);

	if ("wpbf-toggle" === params.type) {
		return <Toggle control={control} checked={!!value} onChange={onChange} />;
	}

	return (
		<>
			<Notifications control={control} />

			<input
				id={inputId}
				type="checkbox"
				aria-describedby={params.description ? `_customize-description-${params.id}` : undefined}
				checked={!!value}
				onChange={onChange}
			/>{" "}
			<label htmlFor={inputId} dangerouslySetInnerHTML={{ __html: params.label ?? "" }} />{" "}
			{params.description && (
				<span
					id={`_customize-description-${params.id}`}
					className="description customize-control-description"
					dangerouslySetInnerHTML={{ __html: params.description }}
				/>
			)}
		</>
	);
}

/**
 * wpbf-toggle: the toggle or switch.
 */
function Toggle(props: Props & { checked: boolean; onChange: (e: { target: HTMLInputElement }) => void }) {
	const { control } = props;
	const params = control.params;
	const kind = params.checkboxType ?? "toggle";
	const inputId = `_customize-input-${params.id}`;
	const choices = (params.choices ?? {}) as Record<string, string>;

	// The field's input_attrs, after the template's own attributes (the first of duplicates wins).
	const extraAttrs = useExtraAttrs(params.inputAttrs, ["id", "type", "value", "name", "class"]);

	const hasLabel = !!(params.label || params.description);

	// Where core used to put the notifications: after the title, or first when there's no title.
	return (
		<>
			{!params.label && <Notifications control={control} />}

			<div className={`wpbf-${kind}-control wpbf-${kind}`}>
				{hasLabel && (
					<div className="wpbf-control-label">
						{params.label && (
							<label
								className="customize-control-title"
								htmlFor={inputId}
								dangerouslySetInnerHTML={{ __html: ` ${params.label} ` }}
							/>
						)}

						{params.label && <Notifications control={control} />}

						{params.description && (
							<span
								className="description customize-control-description"
								dangerouslySetInnerHTML={{ __html: params.description }}
							/>
						)}
					</div>
				)}

				<div className="wpbf-control-form">
					<input
						ref={extraAttrs}
						id={inputId}
						type="checkbox"
						name={`wpbf_${params.id}`}
						className="screen-reader-text wpbf-toggle-switch-input"
						checked={props.checked}
						onChange={props.onChange}
					/>

					<label className="wpbf-toggle-switch-label" htmlFor={inputId}>
						{"switch" === kind && (
							<>
								<span className="toggle-on"> {choices.on || params.defaultChoices?.on} </span>{" "}
								<span className="toggle-off"> {choices.off || params.defaultChoices?.off} </span>
							</>
						)}
					</label>
				</div>
			</div>
		</>
	);
}
