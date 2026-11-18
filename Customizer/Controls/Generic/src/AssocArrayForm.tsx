/**
 * The form of the assoc-array type (see assoc-array-control.tsx): label, description, and one hidden field per part
 * of the value (as the old template printed them: the parts PHP had, showing the current value).
 */
import { Notifications, ReactControlFormProps, useSettingValue } from "../../Base/src/react-base";
import { AssocArrayControlParams } from "./interface";

type Props = ReactControlFormProps<Record<string, any>, AssocArrayControlParams>;

export default function AssocArrayForm({ control }: Props) {
	const params = control.params;
	const [value] = useSettingValue(control, params.value);
	const keys = params.value && "object" === typeof params.value ? Object.keys(params.value) : [];

	// The text of a part, as the old template showed it (lists and other non-text parts empty).
	const text = (part: unknown) =>
		null === part || "undefined" === typeof part || false === part || "object" === typeof part ? "" : String(part);

	return (
		<>
			{(params.label || params.description) && (
				<div className="customize-control-label">
					{params.label && (
						<label className="customize-control-title" htmlFor={"_customize-input-" + control.id}>
							{params.label}
						</label>
					)}

					{params.description && (
						<span
							className="description customize-control-description"
							dangerouslySetInnerHTML={{ __html: params.description }}
						/>
					)}
				</div>
			)}

			<Notifications control={control} />

			<div className="wpbf-control-form">
				{keys.map((key) => (
					<input
						key={key}
						type="hidden"
						id={"_customize-input-" + control.id + "_" + key}
						value={text(value && "object" === typeof value && key in value ? value[key] : params.value[key])}
						data-setting-prop={key}
					/>
				))}
			</div>
		</>
	);
}
