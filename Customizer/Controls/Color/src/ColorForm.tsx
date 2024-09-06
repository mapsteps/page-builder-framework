import React, { useRef, useState } from "react";
import { colord } from "colord";
import ColorPickerSwatches from "./components/ColorPickerSwatches";
import ColorPickerInput from "./components/ColorPickerInput";
import convertColorForInput from "./utils/convert-color-for-input";
import convertColorForCustomizer from "./utils/convert-color-for-customizer";
import convertColorForPicker from "./utils/convert-color-for-picker";
import useWindowResize from "./hooks/useWindowResize";
import useFocusOutside from "./hooks/useFocusOutside";
import useClickOutside from "./hooks/useClickOutside";
import ColorPickerComponent from "./components/ColorPickerComponent";
import ColorPickerHeader from "./components/ColorPickerHeader";
import { WpbfCustomizeColorControl } from "./color-interface";
import { WpbfCustomizeSetting } from "../../Base/src/interface";
import { ObjectColor } from "colord/types";

/**
 * The form component of Kirki React Colorful.
 */
export function ColorForm(props: {
	control: WpbfCustomizeColorControl;
	label: string;
	description: string;
	customizerSetting?: WpbfCustomizeSetting<any>;
	useHueMode: boolean;
	pickerComponent: string;
	labelStyle: string;
	colorSwatches: Array<string | { color: string } | undefined>;
	value: string | ObjectColor | number;
	default: string | ObjectColor | number;
	setNotificationContainer: any;
	formComponent?: string;
	onChange?: (color: string | ObjectColor) => void;
}) {
	const {
		control,
		customizerSetting,
		useHueMode,
		pickerComponent,
		labelStyle,
	} = props;

	const parseEmptyValue = () => (useHueMode ? 0 : "#000000");

	function parseHueModeValue(hueValue: any) {
		hueValue = hueValue || parseEmptyValue();
		hueValue = hueValue < 0 ? 0 : hueValue;

		return hueValue > 360 ? 360 : hueValue;
	}

	function parseInputValue(value: any) {
		if ("" === value) return "";

		return useHueMode
			? parseHueModeValue(value)
			: convertColorForInput(
					value,
					pickerComponent,
					props.formComponent,
				).replace(";", "");
	}

	function parseCustomizerValue(value: any) {
		if ("" === value) return "";

		return convertColorForCustomizer(
			value,
			pickerComponent,
			props.formComponent,
		);
	}

	function parsePickerValue(value: any) {
		value = value || parseEmptyValue();

		// Hard coded saturation and lightness when using hue mode.
		return useHueMode
			? { h: value, s: 100, l: 50 }
			: convertColorForPicker(value, pickerComponent);
	}

	const [inputValue, setInputValue] = useState(() => {
		return parseInputValue(props.value);
	});

	const [pickerValue, setPickerValue] = useState(() => {
		return parsePickerValue(props.value);
	});

	let currentInputValue = inputValue;
	let currentPickerValue = pickerValue;

	// This function will be called when this control's customizer value is changed.
	control.updateComponentState = (value: any) => {
		const valueForInput = parseInputValue(value);
		let changeInputValue: boolean;

		if (typeof valueForInput === "string" || useHueMode) {
			changeInputValue = valueForInput !== inputValue;
		} else {
			changeInputValue =
				JSON.stringify(valueForInput) !== JSON.stringify(currentInputValue);
		}

		if (changeInputValue) setInputValue(valueForInput);

		const valueForPicker = parsePickerValue(value);
		let changePickerValue: boolean;

		if (typeof valueForPicker === "string" || useHueMode) {
			changePickerValue = valueForPicker !== pickerValue;
		} else {
			changePickerValue =
				JSON.stringify(valueForPicker) !== JSON.stringify(currentPickerValue);
		}

		if (changePickerValue) setPickerValue(valueForPicker);
	};

	function saveToCustomizer(value: any) {
		if (useHueMode) {
			/**
			 * When using hue mode, the pickerComponent is HslColorPicker.
			 * If there is value.h, then value is set from the picker.
			 * Otherwise, value is set from the input or the customizer.
			 */
			value = value.h || 0 === value.h ? value.h : value;
			value = parseHueModeValue(value);
		} else {
			value = parseCustomizerValue(value);
		}

		customizerSetting?.set(value);
	}

	const initialColor =
		"" !== props.default && "undefined" !== typeof props.default
			? props.default
			: props.value;

	/**
	 * Function to run on picker change.
	 *
	 * @param {string|Object} color The value returned by the picker. It can be a string or a color object.
	 */
	function handlePickerChange(color: any) {
		if (props.onChange) props.onChange(color);
		currentPickerValue = color;
		saveToCustomizer(color);
	}

	function handleInputChange(value: any) {
		currentInputValue = value;
		saveToCustomizer(value);
	}

	function handleReset() {
		if (!initialColor) {
			currentInputValue = "";
			currentPickerValue = "";
		}

		saveToCustomizer(initialColor);
	}

	function handleSwatchesClick(swatchColor: any) {
		saveToCustomizer(swatchColor);
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
			control.container[0].parentNode as HTMLElement,
		).paddingLeft;

		const padding = parseInt(rawPadding, 10) * 2;

		pickerContainerStyle.width =
			(control.container[0].parentNode as HTMLElement).getBoundingClientRect()
				.width - padding;

		const controlLeftOffset = (control.container[0].offsetLeft - 9) * -1;

		pickerContainerStyle.left = controlLeftOffset + "px";

		return pickerContainerStyle;
	};

	const convertInputValueTo6Digits = () => {
		if (4 === inputValue.length && inputValue.includes("#")) {
			setInputValue(colord(inputValue).toHex());
		}
	};

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

	let formClassName = useHueMode
		? "wpbf-control-form use-hue-mode"
		: "wpbf-control-form";

	formClassName += " has-" + labelStyle + "-label-style";

	let pickerContainerClassName = isPickerOpen
		? pickerComponent + " colorPickerContainer is-open"
		: pickerComponent + " colorPickerContainer";

	return (
		<>
			<div className={formClassName} ref={formRef} tabIndex={1}>
				<ColorPickerHeader
					label={props.label}
					description={props.description}
					labelStyle={props.labelStyle}
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
