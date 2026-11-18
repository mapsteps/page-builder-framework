/**
 * The form of the radio types (one control, see radio-control.tsx):
 *
 * - wpbf-radio: a list of radios; a choice can be a label or [label, description].
 * - wpbf-radio-buttonset: a row of buttons.
 * - wpbf-radio-image: images; a choice is an image URL or { src, alt }.
 *
 * All save the chosen key. Each keeps the markup of its old template.
 */
import type { ChangeEvent } from "react";
import { Notifications, ReactControlFormProps, useExtraAttrs, useSettingValue } from "../../Base/src/react-base";
import { RadioImageChoice, WpbfCustomizeRadioControlParams } from "./interface";

type Props = ReactControlFormProps<unknown, WpbfCustomizeRadioControlParams>;

type LayoutProps = Props & {
	isChecked: (key: string) => boolean;
	onChange: (e: ChangeEvent<HTMLInputElement>) => void;
};

export default function RadioForm({ control }: Props) {
	const params = control.params;
	const [value, setValue] = useSettingValue(control, params.value);

	const layout: LayoutProps = {
		control,
		isChecked: (key) => String(value) === key,
		onChange: (e) => setValue(e.target.value),
	};

	if ("wpbf-radio-buttonset" === params.type) return <Buttonset {...layout} />;
	if ("wpbf-radio-image" === params.type) return <Images {...layout} />;

	return <List {...layout} />;
}

/**
 * The choices in their order (an object from PHP; keys that look like numbers come first, as in the old templates).
 */
function choiceKeys(choices: WpbfCustomizeRadioControlParams["choices"]): string[] {
	return Object.keys(choices ?? {});
}

/**
 * Text as the old templates printed it with `{{ }}` (escaped), for attributes and text.
 */
function asText(value: unknown): string {
	return null === value || "undefined" === typeof value ? "" : String(value);
}

/**
 * HTML the old template printed unescaped next to other content: as text when it's plain text (the usual case),
 * in a box-less wrapper when it has markup.
 */
function asHtml(html: string) {
	return /[<&]/.test(html) ? <span style={{ display: "contents" }} dangerouslySetInnerHTML={{ __html: html }} /> : html;
}

/**
 * wpbf-radio: label, description, one radio per choice.
 */
function List({ control, isChecked, onChange }: LayoutProps) {
	const params = control.params;
	const choices = (params.choices ?? {}) as Record<string, string | [string, string]>;
	const extraAttrs = useExtraAttrs(params.inputAttrs, ["type", "id", "name", "value", "data-id"]);

	return (
		<>
			<span className="customize-control-title" dangerouslySetInnerHTML={{ __html: params.label ?? "" }} />

			<Notifications control={control} />

			{params.description && (
				<span
					className="description customize-control-description"
					dangerouslySetInnerHTML={{ __html: params.description }}
				/>
			)}

			{choiceKeys(choices).map((key) => {
				const choice = choices[key];
				const inputId = `_customize-input-${params.id}_${key}`;

				return (
					<label htmlFor={inputId} key={key}>
						<input
							ref={extraAttrs}
							type="radio"
							id={inputId}
							name={`_customize-radio-${params.id}`}
							value={key}
							data-id={params.id}
							checked={isChecked(key)}
							onChange={onChange}
						/>{" "}
						{Array.isArray(choice) ? (
							<>
								{asHtml(choice[0])}
								<span className="option-description" dangerouslySetInnerHTML={{ __html: choice[1] }} />
							</>
						) : (
							asText(choice)
						)}
					</label>
				);
			})}
		</>
	);
}

/**
 * wpbf-radio-buttonset: label, description, a row of buttons.
 */
function Buttonset({ control, isChecked, onChange }: LayoutProps) {
	const params = control.params;
	const choices = (params.choices ?? {}) as Record<string, string>;

	// The old template printed the input_attrs first: they win over its own attributes.
	const extraAttrs = useExtraAttrs(params.inputAttrs);

	return (
		<>
			{params.label && (
				<span className="customize-control-title" dangerouslySetInnerHTML={{ __html: params.label }} />
			)}

			<Notifications control={control} />

			{params.description && (
				<span
					className="description customize-control-description"
					dangerouslySetInnerHTML={{ __html: params.description }}
				/>
			)}

			<div id={`input_${params.id}`} className="buttonset">
				{choiceKeys(choices).map((key) => {
					const inputId = `${params.id}-${key}`;
					const checked = isChecked(key);

					return [
						<input
							ref={extraAttrs}
							key={`input-${key}`}
							className="switch-input screen-reader-text"
							type="radio"
							value={key}
							name={`_customize-radio-${params.id}`}
							id={inputId}
							checked={checked}
							onChange={onChange}
						/>,
						<label
							key={`label-${key}`}
							className={`switch-label switch-label-${checked ? "on" : "off"}`}
							htmlFor={inputId}
							dangerouslySetInnerHTML={{ __html: asText(choices[key]) }}
						/>,
					];
				})}
			</div>
		</>
	);
}

/**
 * wpbf-radio-image: label and description in a label, one image per choice.
 */
function Images({ control, isChecked, onChange }: LayoutProps) {
	const params = control.params;
	const choices = (params.choices ?? {}) as Record<string, string | RadioImageChoice>;
	const extraAttrs = useExtraAttrs(params.inputAttrs, ["type", "id", "name", "value", "class", "data-alt"]);
	const labelStyle = useExtraAttrs(params.labelStyle, ["for"]);

	return (
		<>
			<label className="customizer-text">
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

			{!params.label && <Notifications control={control} />}

			<div id={`input_${params.id}`} className="image">
				{choiceKeys(choices).map((key) => {
					const choice = choices[key];
					const inputId = `_customize-input-${params.id}_${key}`;
					const isObject = "object" === typeof choice && null !== choice;

					return [
						<input
							ref={extraAttrs}
							key={`input-${key}`}
							type="radio"
							id={inputId}
							name={`_customize-radio-${params.id}`}
							value={key}
							className="image-select"
							data-alt={isObject && "undefined" !== typeof choice.alt ? choice.alt : ""}
							checked={isChecked(key)}
							onChange={onChange}
						/>,
						<label key={`label-${key}`} ref={labelStyle} htmlFor={inputId} className={params.id + key}>
							{isObject ? (
								<>
									<img src={asText(choice.src)} alt={asText(choice.alt)} />
									<span className="image-label">
										<span className="inner">{asText(choice.alt)}</span>
									</span>
								</>
							) : (
								<img src={asText(choice)} />
							)}
							<span className="image-clickable"></span>
						</label>,
					];
				})}
			</div>
		</>
	);
}
