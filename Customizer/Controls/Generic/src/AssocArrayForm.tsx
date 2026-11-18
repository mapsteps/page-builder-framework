/**
 * The form of the assoc-array type (see assoc-array-control.tsx): the label and description of a typography field
 * (the theme's customizer.css hides them). The value's parts are edited by the font family / variant selects.
 */
import { Notifications, ReactControlFormProps } from "../../Base/src/react-base";
import { AssocArrayControlParams } from "./interface";

type Props = ReactControlFormProps<Record<string, any>, AssocArrayControlParams>;

export default function AssocArrayForm({ control }: Props) {
	const params = control.params;

	return (
		<>
			{(params.label || params.description) && (
				<div className="customize-control-label">
					{params.label && (
						<label className="customize-control-title" htmlFor={`wpbf-control-input-${control.id}[font-family]`}>
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
		</>
	);
}
