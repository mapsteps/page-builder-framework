import { useEffect, useRef, useState } from "react";
import { colord } from "colord";
import ColorPickerSwatches from "./components/ColorPickerSwatches";
import ColorPickerInput from "./components/ColorPickerInput";
import useWindowResize from "./hooks/useWindowResize";
import useFocusOutside from "./hooks/useFocusOutside";
import useClickOutside from "./hooks/useClickOutside";
import ColorPickerComponent from "./components/ColorPickerComponent";
import ControlHeader from "./components/ControlHeader";
import {
	ColorControlLabelStyle,
	WpbfColorControlValue,
} from "./color-interface";
import convertColorForInput from "./utils/convert-color-for-input";
import convertColorForPicker from "./utils/convert-color-for-picker";

/**
 * The form component of Kirki React Colorful.
 */
export default function ColorForm(props: {
	type: string;
	container: HTMLElement;
	label: string;
	description: string;
	useHueMode: boolean;
	pickerComponent: string;
	labelStyle: ColorControlLabelStyle;
	colorSwatches: Array<string | { color: string } | undefined>;
	value: WpbfColorControlValue;
	default: WpbfColorControlValue;
	formComponent?: string;
	removeHeader?: boolean;
	isPopupOpen?: boolean;
	useExternalPopupToggle?: boolean;
	onChange?: (value: WpbfColorControlValue) => void;
	onReset?: () => void;
	overrideUpdateComponentStateFn?: (
		fn: (val: WpbfColorControlValue) => void,
	) => void;
	setNotificationContainer?: any;
}) {
	const {
		container,
		useHueMode,
		pickerComponent,
		formComponent,
		label,
		description,
		labelStyle,
		useExternalPopupToggle,
	} = props;

	const [inputValue, setInputValue] = useState(() => {
		return convertColorForInput(
			props.value,
			useHueMode,
			pickerComponent,
			formComponent,
		);
	});

	const [pickerValue, setPickerValue] = useState(() => {
		return convertColorForPicker(props.value, useHueMode, pickerComponent);
	});

	let currentInputValue = inputValue;
	let currentPickerValue = pickerValue;

	// This function will be called when this control's customizer value is changed.
	function updateComponentState(value: WpbfColorControlValue) {
		const valueForInput = convertColorForInput(
			value,
			useHueMode,
			pickerComponent,
			formComponent,
		);

		let shouldChangeInputValue = false;

		if (typeof valueForInput === "string" || useHueMode) {
			shouldChangeInputValue = valueForInput !== inputValue;
		} else {
			shouldChangeInputValue =
				JSON.stringify(valueForInput) !== JSON.stringify(currentInputValue);
		}

		if (shouldChangeInputValue) {
			setInputValue(valueForInput);
		}

		const valueForPicker = convertColorForPicker(
			value,
			useHueMode,
			pickerComponent,
		);

		let shouldChangePickerValue: boolean;

		if (typeof valueForPicker === "string" || useHueMode) {
			shouldChangePickerValue = valueForPicker !== pickerValue;
		} else {
			shouldChangePickerValue =
				JSON.stringify(valueForPicker) !== JSON.stringify(currentPickerValue);
		}

		if (shouldChangePickerValue) {
			setPickerValue(valueForPicker);
		}
	}

	props.overrideUpdateComponentStateFn?.(updateComponentState);

	const initialColor =
		"" !== props.default && "undefined" !== typeof props.default
			? props.default
			: props.value;

	function handleWindowResize() {
		setPickerContainerStyle(getPickerContainerStyle());
	}

	// Reference to the form div.
	const formRef = useRef<HTMLDivElement | null>(null);

	// Reference to the color picker popup.
	const pickerRef = useRef<HTMLDivElement | null>(null);

	// Reference to the reset button.
	const resetRef = useRef<HTMLButtonElement | null>(null);

	const [isPopupOpen, setIsPopupOpen] = useState(props.isPopupOpen ?? false);

	// On multicolor control, listen to `value` && `isPopupOpen` properties change.
	if (props.type && props.type === "wpbf-multicolor") {
		useEffect(() => {
			setInputValue(
				convertColorForInput(
					props.value,
					useHueMode,
					pickerComponent,
					formComponent,
				),
			);

			setPickerValue(
				convertColorForPicker(props.value, useHueMode, pickerComponent),
			);
		}, [props.value]);

		useEffect(() => {
			setIsPopupOpen(props.isPopupOpen ?? false);
		}, [props.isPopupOpen]);
	}

	const [pickerContainerStyle, setPickerContainerStyle] = useState({});

	const getPickerContainerStyle = () => {
		let pickerContainerStyle: Record<string, any> = {};

		if ("default" === labelStyle) {
			return pickerContainerStyle;
		}

		const rawPadding = window.getComputedStyle(
			container.parentNode as HTMLElement,
		).paddingLeft;

		const padding = parseInt(rawPadding, 10) * 2;

		pickerContainerStyle.width =
			(container.parentNode as HTMLElement).getBoundingClientRect().width -
			padding;

		const controlLeftOffset = (container.offsetLeft - 9) * -1;

		pickerContainerStyle.left = controlLeftOffset + "px";

		return pickerContainerStyle;
	};

	function convertInputValueTo6Digits() {
		if (
			typeof inputValue === "string" &&
			4 === inputValue.length &&
			inputValue.includes("#")
		) {
			setInputValue(colord(inputValue).toHex());
		}
	}

	function togglePopup() {
		if (useExternalPopupToggle) return;

		if (isPopupOpen) {
			closePopup();
		} else {
			openPopup();
		}
	}

	function openPopup() {
		if (isPopupOpen) return;

		setPickerContainerStyle(getPickerContainerStyle());
		convertInputValueTo6Digits();
		setIsPopupOpen(true);
	}

	function closePopup() {
		if (!isPopupOpen) return;

		setIsPopupOpen(false);
		setTimeout(convertInputValueTo6Digits, 200);
	}

	useWindowResize(handleWindowResize);

	if (!useExternalPopupToggle) {
		// Handle outside focus to close the picker popup.
		useFocusOutside(formRef, closePopup);

		// Handle outside click to close the picker popup.
		useClickOutside(pickerRef, resetRef, closePopup);
	}

	let colorSwatches = props.colorSwatches;

	if (jQuery.wp && jQuery.wp.wpColorPicker) {
		const wpColorPickerSwatches =
			jQuery.wp.wpColorPicker.prototype.options.palettes;

		// If 3rd parties applied custom colors to wpColorPicker swatches, let's use them.
		if (Array.isArray(wpColorPickerSwatches)) {
			if (wpColorPickerSwatches.length < 8) {
				for (let i = wpColorPickerSwatches.length; i < 8; i++) {
					if (wpColorPickerSwatches[i]) {
						wpColorPickerSwatches.push(colorSwatches[i]);
					}
				}
			}

			colorSwatches = wpColorPickerSwatches;
		}
	}

	return (
		<>
			<div
				className={`wpbf-control-form ${useHueMode ? "use-hue-mode" : ""} has-${labelStyle}-label-style`}
				ref={formRef}
				tabIndex={1}
			>
				{!props.removeHeader && (
					<ControlHeader
						label={label}
						description={description}
						labelStyle={labelStyle}
						pickerComponent={pickerComponent}
						useHueMode={useHueMode}
						inputValue={inputValue}
						isPopupOpen={isPopupOpen}
						togglePicker={togglePopup}
						resetRef={resetRef}
						onResetButtonClick={() => {
							if (!initialColor) {
								currentInputValue = "";
								currentPickerValue = "";
							}

							props.onReset?.();
						}}
						setNotificationContainer={props.setNotificationContainer}
					/>
				)}

				<div
					ref={pickerRef}
					className={`${pickerComponent} colorPickerContainer ${isPopupOpen ? "is-open" : ""}`}
					style={pickerContainerStyle}
				>
					{!useHueMode && (
						<ColorPickerSwatches
							colors={colorSwatches}
							onClick={(color) => {
								props.onChange?.(color);
							}}
						/>
					)}

					<ColorPickerComponent
						pickerComponent={pickerComponent}
						value={pickerValue}
						onChange={(color) => {
							currentPickerValue = color;
							props.onChange?.(color);
						}}
					/>

					<ColorPickerInput
						pickerComponent={pickerComponent}
						useHueMode={useHueMode}
						color={inputValue}
						onChange={(value) => {
							currentInputValue = value;
							props.onChange?.(value);
						}}
					/>
				</div>
			</div>
		</>
	);
}
