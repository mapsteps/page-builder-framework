import React, { useRef, useState } from "react";
import { colord } from "colord";
import ColorPickerSwatches from "./components/ColorPickerSwatches";
import ColorPickerInput from "./components/ColorPickerInput";
import useWindowResize from "./hooks/useWindowResize";
import useFocusOutside from "./hooks/useFocusOutside";
import useClickOutside from "./hooks/useClickOutside";
import ColorPickerComponent from "./components/ColorPickerComponent";
import ControlHeader from "./components/ControlHeader";
import {
	WpbfColorPickerValue,
	WpbfCustomizeColorControlValue,
} from "./color-interface";
import convertColorForInput from "./utils/convert-color-for-input";
import convertColorForPicker from "./utils/convert-color-for-picker";
import { AnyWpbfCustomizeControl } from "../../Base/src/base-interface";

/**
 * The form component of Kirki React Colorful.
 */
export function ColorForm(props: {
	control: AnyWpbfCustomizeControl;
	container: HTMLElement;
	label: string;
	description: string;
	useHueMode: boolean;
	pickerComponent: string;
	labelStyle: string;
	colorSwatches: Array<string | { color: string } | undefined>;
	value: WpbfCustomizeColorControlValue;
	default: WpbfCustomizeColorControlValue;
	setNotificationContainer: any;
	formComponent?: string;
	onChange?: (value: WpbfCustomizeColorControlValue) => void;
	onReset?: () => void;
}) {
	const {
		control,
		container,
		useHueMode,
		pickerComponent,
		formComponent,
		label,
		description,
		labelStyle,
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
	control.updateColorPicker = (value: WpbfCustomizeColorControlValue) => {
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
	};

	const initialColor =
		"" !== props.default && "undefined" !== typeof props.default
			? props.default
			: props.value;

	/**
	 * Function to run on picker change.
	 *
	 * @param {WpbfCustomizeColorControlValue} color The value returned by the picker. It can be a string or a color object.
	 */
	function handlePickerChange(color: WpbfColorPickerValue) {
		currentPickerValue = color;
		if (props.onChange) props.onChange(color);
	}

	function handleInputChange(value: string) {
		currentInputValue = value;
		if (props.onChange) props.onChange(value);
	}

	function handleReset() {
		if (!initialColor) {
			currentInputValue = "";
			currentPickerValue = "";
		}

		if (props.onReset) props.onReset();
	}

	function handleSwatchesClick(swatchColor: string) {
		if (props.onChange) props.onChange(swatchColor);
	}

	function handleWindowResize() {
		setPickerContainerStyle(getPickerContainerStyle());
	}

	const formRef = useRef(null); // Reference to the form div.
	const pickerRef = useRef(null); // Reference to the picker popup.
	const resetRef = useRef(null); // Reference to the picker popup.

	const [isPickerOpen, setIsPickerOpen] = useState(false);

	const usePositionFixed = "default" !== labelStyle;

	const [pickerContainerStyle, setPickerContainerStyle] = useState({});

	const getPickerContainerStyle = () => {
		let pickerContainerStyle: Record<string, any> = {};

		if (!usePositionFixed) return pickerContainerStyle;

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

	const togglePicker = () => {
		if (isPickerOpen) {
			closePicker();
		} else {
			openPicker();
		}
	};

	const openPicker = () => {
		if (isPickerOpen) return;

		setPickerContainerStyle(getPickerContainerStyle());
		convertInputValueTo6Digits();
		setIsPickerOpen(true);
	};

	const closePicker = () => {
		if (!isPickerOpen) return;

		setIsPickerOpen(false);
		setTimeout(convertInputValueTo6Digits, 200);
	};

	useWindowResize(handleWindowResize);

	// Handle outside focus to close the picker popup.
	useFocusOutside(formRef, closePicker);

	// Handle outside click to close the picker popup.
	useClickOutside(pickerRef, resetRef, closePicker);

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

	const formClassName = `wpbf-control-form ${useHueMode ? "use-hue-mode" : ""} has-${labelStyle}-label-style`;
	const pickerContainerClassName = `${pickerComponent} colorPickerContainer ${isPickerOpen ? "is-open" : ""}`;

	return (
		<>
			<div className={formClassName} ref={formRef} tabIndex={1}>
				<ControlHeader
					label={label}
					description={description}
					labelStyle={labelStyle}
					pickerComponent={pickerComponent}
					useHueMode={useHueMode}
					inputValue={inputValue}
					isPickerOpen={isPickerOpen}
					togglePicker={togglePicker}
					resetRef={resetRef}
					onResetButtonClick={handleReset}
					setNotificationContainer={props.setNotificationContainer}
				/>
				<div
					ref={pickerRef}
					className={pickerContainerClassName}
					style={pickerContainerStyle}
				>
					{!useHueMode && (
						<ColorPickerSwatches
							colors={colorSwatches}
							onClick={handleSwatchesClick}
						/>
					)}

					<ColorPickerComponent
						pickerComponent={pickerComponent}
						value={pickerValue}
						onChange={handlePickerChange}
					/>

					<ColorPickerInput
						pickerComponent={pickerComponent}
						useHueMode={useHueMode}
						color={inputValue}
						onChange={handleInputChange}
					/>
				</div>
			</div>
		</>
	);
}
