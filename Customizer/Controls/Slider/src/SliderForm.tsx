/**
 * The form of the three slider types (one control, see slider-control.tsx):
 *
 * - wpbf-slider: a range slider with the value next to it; saves a number.
 * - wpbf-input-slider: a range slider plus a text field that accepts a unit ("20px"); saves the text.
 * - wpbf-responsive-input-slider: an input slider per device; saves one value per device (object or JSON text).
 *
 * Each type keeps its markup and the exact values it hands to the setting (the live preview reads them).
 */
import type { ChangeEvent } from "react";
import {
	Notifications,
	ReactControlFormProps,
	usePreviewedDevice,
	useSettingValue,
	useTypedText,
} from "../../Base/src/react-base";
import DeviceButtons from "../../Responsive/src/DeviceButtons";
import { DevicesValue } from "../../Responsive/src/interface";
import { limitNumber, makeLimitedNumberUnitPair } from "../../Generic/src/number-util";
import { encodeJsonOrDefault } from "../../Generic/src/string-util";
import { makeDevicesValue, makeStringValue, makeValueForInput, makeValueForSlider } from "./slider-util";
import { SliderSettingValue, SliderValue, WpbfCustomizeSliderControlParams } from "./interface";

type Props = ReactControlFormProps<SliderSettingValue, WpbfCustomizeSliderControlParams>;

/**
 * Whether a value was given ("" and undefined are "not set").
 */
function isSet(value: unknown): boolean {
	return "undefined" !== typeof value && "" !== value;
}

export default function SliderForm({ control }: Props) {
	const params = control.params;
	const [value, setValue] = useSettingValue(control, params.value);
	const typedText = useTypedText();

	if ("wpbf-responsive-input-slider" === params.type) {
		return <ResponsiveSlider control={control} value={value} setValue={setValue} typedText={typedText} />;
	}

	if ("wpbf-input-slider" === params.type) {
		return <InputSlider control={control} value={value as SliderValue} setValue={setValue} typedText={typedText} />;
	}

	return <PlainSlider control={control} value={value as SliderValue} setValue={setValue} />;
}

type PartProps<V> = Props & {
	value: V;
	setValue: (value: SliderSettingValue) => void;
	typedText: ReturnType<typeof useTypedText>;
};

/**
 * The reset button (shows on hover).
 */
function ResetButton(props: { onClick: () => void }) {
	return (
		<button type="button" className="wpbf-control-reset" onClick={props.onClick}>
			<i className="dashicons dashicons-image-rotate"></i>
		</button>
	);
}

/**
 * wpbf-slider: range slider plus the number.
 */
function PlainSlider({ control, value, setValue }: Omit<PartProps<SliderValue>, "typedText">) {
	const { min, max, step } = control.params;
	const fieldId = `wpbf-control-input-${control.setting?.id}`;

	// A number within min and max (the minimum when it isn't a number).
	const toNumber = (raw: SliderValue | undefined): number => {
		const number = "string" === typeof raw ? parseFloat(raw) : (raw ?? 0);

		if (isNaN(number)) return min;

		return Math.min(Math.max(number, min), max);
	};

	const reset = () => {
		if (isSet(control.params.default)) {
			setValue(toNumber(control.params.default as SliderValue));
		} else if (isSet(control.params.value)) {
			setValue(toNumber(control.params.value as SliderValue));
		} else {
			setValue(min);
		}
	};

	const shown = toNumber(value);

	return (
		<div className="wpbf-control-form" tabIndex={-1}>
			<label className="wpbf-control-label" htmlFor={fieldId}>
				<span className="customize-control-title">{control.params.label}</span>
				<span
					className="customize-control-description description"
					dangerouslySetInnerHTML={{ __html: control.params.description ?? "" }}
				/>
			</label>

			<Notifications control={control} />

			<ResetButton onClick={reset} />

			<div className="wpbf-control-cols">
				<div className="wpbf-control-left-col">
					<input
						type="range"
						id={fieldId}
						value={shown}
						min={min}
						max={max}
						step={step}
						className="wpbf-control-slider"
						onChange={(e) => setValue(toNumber(e.target.value))}
					/>
				</div>
				<div className="wpbf-control-right-col">
					<div className="wpbf-control-value">{shown}</div>
				</div>
			</div>
		</div>
	);
}

/**
 * The range slider and text field of one value (input slider, and each device of the responsive slider).
 */
function SliderCols(props: {
	id?: string;
	min: number;
	max: number;
	step: number;
	sliderValue: number;
	text: string;
	onSlide: (e: ChangeEvent<HTMLInputElement>) => void;
	onType: (e: ChangeEvent<HTMLInputElement>) => void;
	onLeave: () => void;
}) {
	return (
		<div className="wpbf-control-cols">
			<div className="wpbf-control-left-col">
				<input
					type="range"
					id={props.id}
					value={props.sliderValue}
					min={props.min}
					max={props.max}
					step={props.step}
					className="wpbf-control-input-slider wpbf-pro-control-input-slider"
					onChange={props.onSlide}
				/>
			</div>
			<div className="wpbf-control-right-col">
				<input
					type="text"
					value={props.text}
					className="wpbf-control-input"
					onChange={props.onType}
					onBlur={props.onLeave}
				/>
			</div>
		</div>
	);
}

/**
 * wpbf-input-slider: range slider plus a text field that keeps the unit.
 */
function InputSlider({ control, value, setValue, typedText }: PartProps<SliderValue>) {
	const { min, max, step, label, description } = control.params;
	const [textFor, rememberText, forgetText] = typedText;
	const fieldId = `wpbf-control-input-${control.setting?.id}`;
	const text = textFor("", value) ?? makeStringValue(makeValueForInput(value, min, max));

	const onSlide = (e: ChangeEvent<HTMLInputElement>) => {
		// The slider has no unit: keep the one in the text field.
		const unit = makeLimitedNumberUnitPair(text, min, max).unit;

		setValue(String(limitNumber(parseFloat(e.target.value), min, max)) + unit);
	};

	const onType = (e: ChangeEvent<HTMLInputElement>) => {
		const typed = makeValueForInput(e.target.value, min, max);

		rememberText("", e.target.value, typed);
		setValue(typed);
	};

	const reset = () => {
		forgetText();

		if (isSet(control.params.default)) {
			setValue(control.params.default);
		} else {
			setValue(isSet(control.params.value) ? control.params.value : "");
		}
	};

	return (
		<div className="wpbf-control-form" tabIndex={-1}>
			{label || description ? (
				<label className="wpbf-control-label" htmlFor={fieldId}>
					{label && <span className="customize-control-title">{label}</span>}

					{description && (
						<span
							className="customize-control-description description"
							dangerouslySetInnerHTML={{ __html: description }}
						/>
					)}
				</label>
			) : null}

			<Notifications control={control} />

			<ResetButton onClick={reset} />

			<SliderCols
				id={fieldId}
				min={min}
				max={max}
				step={step}
				sliderValue={makeValueForSlider(value, min, max)}
				text={text}
				onSlide={onSlide}
				onType={onType}
				onLeave={forgetText}
			/>
		</div>
	);
}

/**
 * wpbf-responsive-input-slider: an input slider per device.
 */
function ResponsiveSlider({ control, value, setValue, typedText }: PartProps<SliderSettingValue>) {
	const { min, max, step, label, description } = control.params;
	const devices = control.params.devices ?? [];
	const [textFor, rememberText, forgetText] = typedText;
	const current = makeDevicesValue(devices, value as string | DevicesValue, min, max);
	const activeDevice = usePreviewedDevice(devices);

	const save = (device: string, deviceValue: SliderValue) => {
		const devicesValue = { ...current, [device]: deviceValue };

		setValue(control.params.saveAsJson ? encodeJsonOrDefault<DevicesValue>(devicesValue) : devicesValue);
	};

	const onSlide = (device: string, e: ChangeEvent<HTMLInputElement>) => {
		const sliderValue = makeValueForSlider(e.target.value, min, max);
		const existing = makeLimitedNumberUnitPair(current[device], min, max);

		if (current[device] === sliderValue || existing.number === sliderValue) return;

		// The slider has no unit: keep the one the value has.
		save(device, existing.unit ? sliderValue + existing.unit : sliderValue);
	};

	const onType = (device: string, e: ChangeEvent<HTMLInputElement>) => {
		const typed = makeValueForInput(e.target.value, min, max);

		rememberText(device, e.target.value, typed);
		save(device, typed);
	};

	const reset = (device: string) => {
		const defaults = makeDevicesValue(devices, control.params.default as string | DevicesValue, min, max);

		forgetText();
		save(device, defaults[device]);
	};

	return (
		<>
			<header className="wpbf-control-header">
				{label && (
					<label className="customize-control-title" htmlFor={`wpbf-control-input-${control.setting?.id}-${activeDevice}`}>
						<span className="customize-control-title">{label}</span>
					</label>
				)}

				<DeviceButtons devices={devices} active={activeDevice} />
			</header>

			{description && (
				<span
					className="customize-control-description description"
					dangerouslySetInnerHTML={{ __html: description }}
				/>
			)}

			<Notifications control={control} />

			<div className="wpbf-control-form">
				{devices.map((device) => (
					<div
						className={`wpbf-control-device wpbf-control-${device}${device === activeDevice ? " is-active" : ""}`}
						data-wpbf-device={device}
						key={device}
					>
						<ResetButton onClick={() => reset(device)} />

						<SliderCols
							id={`wpbf-control-input-${control.setting?.id}-${device}`}
							min={min}
							max={max}
							step={step}
							sliderValue={makeValueForSlider(current[device], min, max)}
							text={textFor(device, current[device]) ?? makeStringValue(makeValueForInput(current[device], min, max))}
							onSlide={(e) => onSlide(device, e)}
							onType={(e) => onType(device, e)}
							onLeave={forgetText}
						/>
					</div>
				))}
			</div>
		</>
	);
}
