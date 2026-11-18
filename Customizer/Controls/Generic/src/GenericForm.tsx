/**
 * The form of the generic types (one control, see generic-control.tsx):
 *
 * - wpbf-generic: one field (text, number, number-unit, textarea, email, password, url, hidden or content).
 * - wpbf-responsive-generic: the same field per device; saves an object or, with `saveAsJson`, JSON text.
 *
 * Numbers are kept within min and max while typing; the field keeps what's typed until it's left.
 * Each keeps the markup of the old PHP-rendered form and the values the old control handed to the setting.
 */
import type { ChangeEvent } from "react";
import {
	Notifications,
	ReactControlFormProps,
	useExtraAttrs,
	usePreviewedDevice,
	useSettingValue,
	useTypedText,
} from "../../Base/src/react-base";
import DeviceButtons from "../../Responsive/src/DeviceButtons";
import { DevicesValue } from "../../Responsive/src/interface";
import { makeDevicesValue } from "../../Responsive/src/responsive-util";
import { limitNumber, limitNumberWithUnit } from "./number-util";
import { encodeJsonOrDefault } from "./string-util";
import { GenericSettingValue, WpbfCustomizeGenericControlParams } from "./interface";

type Props = ReactControlFormProps<GenericSettingValue, WpbfCustomizeGenericControlParams>;

type PartProps = Props & {
	value: GenericSettingValue;
	setValue: (value: GenericSettingValue) => void;
	typedText: ReturnType<typeof useTypedText>;
};

/**
 * A value as text (what the field shows).
 */
function asText(value: unknown): string {
	return null === value || "undefined" === typeof value ? "" : String(value);
}

/**
 * What typing `raw` puts into the value: numbers kept within min and max, anything else as typed.
 */
function limitTyped(params: WpbfCustomizeGenericControlParams, raw: string): string | number {
	if ("number" === params.subtype) return limitNumber(raw, params.min, params.max);
	if ("number-unit" === params.subtype) return limitNumberWithUnit(raw, params.min, params.max);

	return raw;
}

export default function GenericForm({ control }: Props) {
	const [value, setValue] = useSettingValue(control, control.params.value);
	const typedText = useTypedText();
	const parts = { control, value, setValue, typedText };

	return "wpbf-responsive-generic" === control.params.type ? <ResponsiveGeneric {...parts} /> : <Generic {...parts} />;
}

/**
 * The field itself: a textarea, or an input of the field's type.
 */
function Field(props: {
	params: WpbfCustomizeGenericControlParams;
	id: string;
	text: string;
	onType: (e: ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => void;
	onLeave: () => void;
}) {
	const { params } = props;

	// The field's input_attrs come first in the old markup, so they win over its own attributes.
	const extraAttrs = useExtraAttrs(params.inputAttrs);

	if ("textarea" === params.inputTag) {
		return (
			<textarea
				ref={extraAttrs}
				id={props.id}
				rows={params.rows}
				value={props.text}
				onChange={props.onType}
				onBlur={props.onLeave}
			/>
		);
	}

	const isNumber = "number" === params.inputType;

	return (
		<input
			ref={extraAttrs}
			type={params.inputType}
			id={props.id}
			value={props.text}
			min={isNumber ? (params.min ?? undefined) : undefined}
			max={isNumber ? (params.max ?? undefined) : undefined}
			step={isNumber ? (params.step ?? undefined) : undefined}
			onChange={props.onType}
			onBlur={props.onLeave}
		/>
	);
}

/**
 * wpbf-generic: label, description, the field.
 */
function Generic({ control, value, setValue, typedText }: PartProps) {
	const params = control.params;
	const [textFor, rememberText, forgetText] = typedText;
	const id = `_customize-input-${params.id}`;

	const onType = (e: ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
		const raw = e.target.value;

		// The old control ended with the field's text after limiting, so numbers are handed on as text.
		const next = "number" === params.subtype || "number-unit" === params.subtype ? asText(limitTyped(params, raw)) : raw;

		rememberText("", raw, next);
		setValue(next);
	};

	return (
		<>
			{(params.label || params.description) && (
				<div className="customize-control-label">
					{params.label && (
						<label className="customize-control-title" htmlFor={id}>
							{` ${params.label} `}
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
				<Field
					params={params}
					id={id}
					text={textFor("", value) ?? asText(value)}
					onType={onType}
					onLeave={forgetText}
				/>
			</div>
		</>
	);
}

/**
 * wpbf-responsive-generic: label with device buttons, description, the field per device.
 */
function ResponsiveGeneric({ control, value, setValue, typedText }: PartProps) {
	const params = control.params;
	const devices = params.devices ?? [];
	const activeDevice = usePreviewedDevice(devices);
	const [textFor, rememberText, forgetText] = typedText;

	const devicesValue = (from: GenericSettingValue): DevicesValue =>
		"string" === typeof from || "number" === typeof from
			? makeDevicesValue(params.subtype, devices, String(from), params.min, params.max)
			: makeDevicesValue(params.subtype, devices, from, params.min, params.max);

	// The values per device as PHP cleaned them, until the value changes.
	const current = value === params.value && params.valueArray ? params.valueArray : devicesValue(value);

	const onType = (device: string, e: ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
		const raw = e.target.value;
		const base = "string" === typeof value ? devicesValue(value) : { ...(value as DevicesValue) };
		let next: GenericSettingValue;

		if (params.saveAsJson) {
			// JSON: the value as limited (numbers stay numbers).
			base[device] = limitTyped(params, raw);
			next = encodeJsonOrDefault<DevicesValue>(base);
		} else {
			// An object: the field's text after limiting, as the old per-device link handed it on.
			base[device] = asText(limitTyped(params, raw));
			next = base;
		}

		rememberText(device, raw, devicesValue(next)[device]);
		setValue(next);
	};

	return (
		<>
			<header className="wpbf-control-header">
				{params.label && (
					<label className="customize-control-title" htmlFor={`_customize-input-${params.id}-${activeDevice}`}>
						{` ${params.label} `}
					</label>
				)}

				<DeviceButtons devices={devices} active={activeDevice} icons={params.deviceIcons} />
			</header>

			{params.description && (
				<span
					className="description customize-control-description"
					dangerouslySetInnerHTML={{ __html: params.description }}
				/>
			)}

			<Notifications control={control} />

			<div className="wpbf-control-form">
				{devices.map((device) => (
					<div
						key={device}
						className={`wpbf-control-device wpbf-control-device-${device}${device === activeDevice ? " is-active" : ""}`}
						data-wpbf-device={device}
					>
						<Field
							params={params}
							id={`_customize-input-${params.id}-${device}`}
							text={textFor(device, current[device]) ?? asText(current[device])}
							onType={(e) => onType(device, e)}
							onLeave={forgetText}
						/>
					</div>
				))}
			</div>
		</>
	);
}
