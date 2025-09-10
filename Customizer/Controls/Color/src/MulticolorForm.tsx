import { useRef, useState } from "react";
import ColorForm from "./ColorForm";
import {
	WpbfMulticolorControlValue,
	ColorControlLabelStyle,
} from "./color-interface";
import ControlLabel from "./components/ControlLabel";
import ColorPickerCirleTrigger from "./components/ColorPickerCircleTrigger";
import convertColorForInput from "./utils/convert-color-for-input";
import useFocusOutside from "./hooks/useFocusOutside";
import useClickOutside from "./hooks/useClickOutside";

export default function MulticolorForm(props: {
	id: string;
	container: HTMLElement;
	choices: Record<string, string>;
	keys: string[];
	label: string;
	description: string;
	useHueMode: boolean;
	pickerComponent: string;
	labelStyle: ColorControlLabelStyle;
	colorSwatches: Array<string | { color: string } | undefined>;
	value: WpbfMulticolorControlValue;
	default: WpbfMulticolorControlValue;
	formComponent?: string;
	onChange?: (value: WpbfMulticolorControlValue) => void;
	onReset?: () => void;
	overrideUpdateComponentStateFn?: (
		fn: (val: WpbfMulticolorControlValue) => void,
	) => void;
	setNotificationContainer?: any;
}) {
	const {
		container,
		choices,
		setNotificationContainer,
		useHueMode,
		pickerComponent,
		formComponent,
		label,
		description,
	} = props;

	const [value, setValue] = useState<WpbfMulticolorControlValue>(props.value);

	const [openedPopupKey, setOpenedPopupKey] = useState<string | undefined>(
		undefined,
	);

	// This function will be called when this control's customizer value is changed.
	function updateComponentState(value: WpbfMulticolorControlValue) {
		setValue(value);
	}

	props.overrideUpdateComponentStateFn?.(updateComponentState);

	function togglePopup(key: string) {
		if (openedPopupKey) {
			setOpenedPopupKey(undefined);
		} else {
			setOpenedPopupKey(key);
		}
	}

	function closePopup() {
		setOpenedPopupKey(undefined);
	}

	// Reference to the form div.
	const formRef = useRef<HTMLDivElement | null>(null);

	// Reference to the color picker popup.
	const pickerRef = useRef<HTMLDivElement | null>(null);

	// Reference to the reset button.
	const resetRef = useRef<HTMLButtonElement | null>(null);

	// Handle outside focus to close the picker popup.
	useFocusOutside(formRef, closePopup);

	// Handle outside click to close the picker popup.
	useClickOutside(pickerRef, resetRef, closePopup);

	return (
		<>
			<div className="wpbf-multicolor" ref={formRef}>
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
								className={`wpbf-control-reset${openedPopupKey ? " is-shown" : ""}`}
								title="Reset colors set"
								onClick={() => props.onReset?.()}
							>
								<i className="dashicons dashicons-image-rotate"></i>
							</button>

							{props.keys.map((key, i) => {
								const circleColor = convertColorForInput(
									value[key] ?? "",
									useHueMode,
									pickerComponent,
									formComponent,
								);

								return (
									<ColorPickerCirleTrigger
										key={`${key}-${i}`}
										color={circleColor}
										isPopupOpen={openedPopupKey === key}
										tooltip={choices[key] ?? undefined}
										onToggleButtonClick={() => togglePopup(key)}
									/>
								);
							})}
						</div>
					</div>
				</div>

				<div ref={pickerRef} className="wpbf-color-picker-popup">
					{props.keys.map((key, i) => {
						return (
							<ColorForm
								key={`${key}-${i}`}
								type="wpbf-multicolor"
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
								isPopupOpen={openedPopupKey === key}
								useExternalPopupToggle={true}
								onChange={(newValue) => {
									const val = { ...value };
									val[key] = newValue;

									props.onChange?.(val);
								}}
							/>
						);
					})}
				</div>
			</div>
		</>
	);
}
