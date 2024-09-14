import React, { useRef, useState } from "react";
import ColorForm from "./ColorForm";
import {
	WpbfCustomizeMulticolorControlValue,
	WpbfCustomizeMulticolorControl,
	ColorControlLabelStyle,
	WpbfCustomizeColorControlValue,
} from "./color-interface";
import ControlLabel from "./components/ControlLabel";
import ColorPickerCirleTrigger from "./components/ColorPickerCircleTrigger";
import convertColorForInput from "./utils/convert-color-for-input";

export default function MulticolorForm(props: {
	control: WpbfCustomizeMulticolorControl;
	container: HTMLElement;
	choices: Record<string, string>;
	keys: string[];
	label: string;
	description: string;
	useHueMode: boolean;
	pickerComponent: string;
	labelStyle: ColorControlLabelStyle;
	colorSwatches: Array<string | { color: string } | undefined>;
	value: WpbfCustomizeMulticolorControlValue;
	default: WpbfCustomizeMulticolorControlValue;
	setNotificationContainer: any;
	formComponent?: string;
}) {
	const {
		control,
		container,
		choices,
		setNotificationContainer,
		useHueMode,
		pickerComponent,
		formComponent,
		label,
		description,
	} = props;

	const [value, setValue] = useState<WpbfCustomizeMulticolorControlValue>(
		() => {
			return props.value;
		},
	);

	const [openedPopupKey, setOpenedPopupKey] = useState<string | undefined>(
		undefined,
	);

	// This function will be called when this control's customizer value is changed.
	control.updateColorPickers = function (value) {
		setValue(value);
	};

	function handleChange(key: string, newValue: WpbfCustomizeColorControlValue) {
		const val = { ...value };
		val[key] = newValue;

		control.onChange?.(val);
	}

	function isPopupOpen(key: string) {
		return openedPopupKey === key;
	}

	function togglePopup(key: string) {
		if (isPopupOpen(key)) {
			setOpenedPopupKey(undefined);
		} else {
			setOpenedPopupKey(key);
		}
	}

	// Reference to the picker popup.
	const resetRef = useRef<HTMLButtonElement | null>(null);

	return (
		<>
			<div className="wpbf-multicolor">
				<div className="wpbf-control-cols">
					<div className="wpbf-control-left-col">
						<ControlLabel
							label={label}
							description={description}
							setNotificationContainer={setNotificationContainer}
						/>
					</div>
					<div className="wpbf-control-right-col">
						<div className="wpbf-buttons">
							<button
								type="button"
								ref={resetRef}
								className="wpbf-control-reset"
								title="Reset colors set"
								onClick={() => control.onReset?.()}
							>
								<i className="dashicons dashicons-image-rotate"></i>
							</button>

							{props.keys.map((key) => {
								const circleColor = convertColorForInput(
									value[key] ?? "",
									useHueMode,
									pickerComponent,
									formComponent,
								);

								return (
									<ColorPickerCirleTrigger
										color={circleColor}
										isPopupOpen={isPopupOpen(key)}
										tooltip={choices[key] ?? undefined}
										onToggleButtonClick={() => togglePopup(key)}
									/>
								);
							})}
						</div>
					</div>
				</div>

				{props.keys.map((key) => {
					return (
						<ColorForm
							control={control}
							container={container}
							label={props.label}
							description={props.description}
							useHueMode={useHueMode}
							formComponent={formComponent}
							pickerComponent={pickerComponent}
							labelStyle="none"
							colorSwatches={props.colorSwatches}
							value={value[key] ?? ""}
							default={props.default[key]}
							setNotificationContainer={props.setNotificationContainer}
							removeHeader={true}
							isPopupOpen={isPopupOpen(key)}
							onChange={(newValue) => handleChange(key, newValue)}
						/>
					);
				})}
			</div>
		</>
	);
}
