/**
 * The form of the dimension type (see dimension-control.tsx): a text field for a CSS size, with the label above it
 * or (`labelPosition` "bottom") the label below it. Saves the text as typed; warns when it isn't a CSS size.
 *
 * Keeps the markup of the old template.
 */
import { useEffect } from "@wordpress/element";
import type { ChangeEvent } from "react";
import { WpbfCustomize } from "../../Base/src/interface";
import {
	Notifications,
	ReactControlFormProps,
	useExtraAttrs,
	useSettingValue,
	useTypedText,
} from "../../Base/src/react-base";
import { DimensionValue, WpbfCustomizeDimensionControlParams } from "./interface";

declare var wp: {
	customize: WpbfCustomize;
};

declare var wpbfDimensionControlL10n: Record<string, string>;

type Props = ReactControlFormProps<DimensionValue, WpbfCustomizeDimensionControlParams>;

const VALID_UNITS = ["fr", "rem", "em", "ex", "%", "px", "cm", "mm", "in", "pt", "pc", "ch", "vh", "vw", "vmin", "vmax"];

/**
 * Whether a value is a CSS size: a number with a unit, 0, auto/inherit/initial, calc(), or several of these.
 */
export function isValidCssValue(value: DimensionValue): boolean {
	if (!value || "" === value || 0 === value || "0" === value || "auto" === value || "inherit" === value || "initial" === value) {
		return true;
	}

	const valueStr = typeof value === "string" ? value : value.toString();

	if (0 <= valueStr.indexOf("calc(") && 0 <= valueStr.indexOf(")")) return true;

	const numericValue = parseFloat(valueStr);
	const unit = valueStr.replace(numericValue.toString(), "");

	// Allow unitless.
	if (!unit) return true;

	// Several values ("10px 20px").
	const multiples = valueStr.split(" ");

	if (2 <= multiples.length) {
		return multiples.every((item) => !item || isValidCssValue(item));
	}

	return !isNaN(numericValue) && -1 !== VALID_UNITS.indexOf(unit);
}

/**
 * The value as the field shows it: text only ("%%" shows as "%").
 */
function shownValue(value: DimensionValue): string {
	return value && "string" === typeof value ? value.replace("%%", "%") : "";
}

export default function DimensionForm({ control }: Props) {
	const params = control.params;
	const [value, setValue] = useSettingValue(control, params.value);
	const [textFor, rememberText, forgetText] = useTypedText();

	// The field's input_attrs, after the template's id (the first of duplicates wins); its class is in inputClass.
	const extraAttrs = useExtraAttrs(params.inputAttrs, ["id"]);

	// Warn about a value that isn't a CSS size, whenever the value changes (as before: not for the saved value).
	useEffect(() => {
		const setting = control.setting;
		if (!setting) return;

		const check = (to: DimensionValue) => {
			const code = "long_title";

			if (!isValidCssValue(to) && (!params.allowUnitless || isNaN(to as number))) {
				setting.notifications.add(
					code,
					// @ts-ignore - There's a mistake in the type definition.
					new wp.customize.Notification(code, {
						type: "warning",
						message: wpbfDimensionControlL10n["invalid-value"],
					}),
				);
			} else {
				setting.notifications.remove(code);
			}
		};

		setting.bind(check);

		return () => {
			setting.unbind(check);
		};
	}, [control]);

	const onType = (e: ChangeEvent<HTMLInputElement>) => {
		rememberText("", e.target.value, e.target.value);
		setValue(e.target.value);
	};

	const isBottom = "bottom" === params.labelPosition;

	const field = (
		<div className="wpbf-input-control">
			<input
				ref={extraAttrs}
				id={params.inputId}
				type="text"
				value={textFor("", value) ?? shownValue(value)}
				className={params.inputClass}
				onChange={onType}
				onBlur={forgetText}
			/>
		</div>
	);

	return (
		<>
			{(isBottom || !params.label) && <Notifications control={control} />}

			<div className={`wpbf-control-form${isBottom ? " has-label-bottom" : ""}`}>
				{"top" === params.labelPosition && (
					<label className="wpbf-control-label" htmlFor={params.inputId}>
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
				)}

				{field}

				{isBottom && (
					<label
						className="wpbf-control-label"
						htmlFor={params.inputId}
						dangerouslySetInnerHTML={{ __html: params.label ? `${params.label} ` : "" }}
					/>
				)}
			</div>
		</>
	);
}
