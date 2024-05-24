import React, { useRef, useState } from "react";
import {
	HexColorPicker,
	HslaColorPicker,
	HslaStringColorPicker,
	HslColorPicker,
	HslStringColorPicker,
	HsvaColorPicker,
	HsvaStringColorPicker,
	HsvColorPicker,
	HsvStringColorPicker,
	RgbaColorPicker,
	RgbaStringColorPicker,
	RgbColorPicker,
	RgbStringColorPicker,
} from "react-colorful";
import {
	colord,
	HslaColor,
	HslColor,
	HsvaColor,
	HsvColor,
	RgbaColor,
	RgbColor,
} from "colord";
import ColorPickerSwatches from "./components/ColorPickerSwatches";
import ColorPickerInput from "./components/ColorPickerInput";
import convertColorForInput from "./utils/convert-color-for-input";
import convertColorForCustomizer from "./utils/convert-color-for-customizer";
import convertColorForPicker from "./utils/convert-color-for-picker";
import useWindowResize from "./hooks/useWindowResize";
import useFocusOutside from "./hooks/useFocusOutside";
import useClickOutside from "./hooks/useClickOutside";
import ColorPickerCircle from "./components/ColorPickerCircle";
import jQuery from "jquery";
import { WpbfCustomizeColorControl } from "./interface";
import { WpbfCustomizeSetting } from "../../Base/src/interface";
import { ObjectColor } from "colord/types";

// Declare global extends jQuery to have wp property.
declare global {
	interface JQueryStatic {
		wp: any;
	}
}

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

	const saveToCustomizer = (value: any) => {
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
	};

	const initialColor =
		"" !== props.default && "undefined" !== typeof props.default
			? props.default
			: props.value;

	/**
	 * Function to run on picker change.
	 *
	 * @param {string|Object} color The value returned by the picker. It can be a string or a color object.
	 */
	const handlePickerChange = (color: any) => {
		if (props.onChange) props.onChange(color);
		currentPickerValue = color;
		saveToCustomizer(color);
	};

	const handleInputChange = (value: any) => {
		currentInputValue = value;
		saveToCustomizer(value);
	};

	const handleReset = () => {
		if (!initialColor) {
			currentInputValue = "";
			currentPickerValue = "";
		}

		saveToCustomizer(initialColor);
	};

	const handleSwatchesClick = (swatchColor: any) => {
		saveToCustomizer(swatchColor);
	};

	const handleWindowResize = () => {
		setPickerContainerStyle(getPickerContainerStyle());
	};

	let controlLabel = (
		<span
			className="customize-control-title"
			dangerouslySetInnerHTML={{ __html: props.label }}
		/>
	);

	let controlDescription = (
		<span
			className="description customize-control-description"
			dangerouslySetInnerHTML={{ __html: props.description }}
		></span>
	);

	controlLabel = (
		<label className="wpbf-control-label">
			{props.label ? controlLabel : ""}
			{props.description ? controlDescription : ""}
		</label>
	);

	controlLabel = props.label || props.description ? controlLabel : <></>;

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

	function renderColorPickerComponent() {
		// We can't just render `pickerComponent` directly, we need these lines so that the compiler will import them.
		switch (pickerComponent) {
			case "HexColorPicker":
				return (
					<HexColorPicker
						color={pickerValue as string}
						onChange={handlePickerChange}
					/>
				);
			case "RgbColorPicker":
				return (
					<RgbColorPicker
						color={pickerValue as RgbColor}
						onChange={handlePickerChange}
					/>
				);
			case "RgbStringColorPicker":
				return (
					<RgbStringColorPicker
						color={pickerValue as string}
						onChange={handlePickerChange}
					/>
				);
			case "RgbaColorPicker":
				return (
					<RgbaColorPicker
						color={pickerValue as RgbaColor}
						onChange={handlePickerChange}
					/>
				);
			case "RgbaStringColorPicker":
				return (
					<RgbaStringColorPicker
						color={pickerValue as string}
						onChange={handlePickerChange}
					/>
				);
			// We treat HueColorPicker (hue mode) as HslColorPicker.
			case "HueColorPicker":
				return (
					<HslColorPicker
						color={pickerValue as HslColor}
						onChange={handlePickerChange}
					/>
				);
			case "HslColorPicker":
				return (
					<HslColorPicker
						color={pickerValue as HslColor}
						onChange={handlePickerChange}
					/>
				);
			case "HslStringColorPicker":
				return (
					<HslStringColorPicker
						color={pickerValue as string}
						onChange={handlePickerChange}
					/>
				);
			case "HslaColorPicker":
				return (
					<HslaColorPicker
						color={pickerValue as HslaColor}
						onChange={handlePickerChange}
					/>
				);
			case "HslaStringColorPicker":
				return (
					<HslaStringColorPicker
						color={pickerValue as string}
						onChange={handlePickerChange}
					/>
				);
			case "HsvColorPicker":
				return (
					<HsvColorPicker
						color={pickerValue as HsvColor}
						onChange={handlePickerChange}
					/>
				);
			case "HsvStringColorPicker":
				return (
					<HsvStringColorPicker
						color={pickerValue as string}
						onChange={handlePickerChange}
					/>
				);
			case "HsvaColorPicker":
				return (
					<HsvaColorPicker
						color={pickerValue as HsvaColor}
						onChange={handlePickerChange}
					/>
				);
			case "HsvaStringColorPicker":
				return (
					<HsvaStringColorPicker
						color={pickerValue as string}
						onChange={handlePickerChange}
					/>
				);
			default:
				return (
					<HexColorPicker
						color={pickerValue as string}
						onChange={handlePickerChange}
					/>
				);
		}
	}

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

	const controlHeader = (
		<>
			{controlLabel}
			<div
				className="customize-control-notifications-container"
				ref={props.setNotificationContainer}
			/>
		</>
	);

	let formClassName = useHueMode
		? "wpbf-control-form use-hue-mode"
		: "wpbf-control-form";

	formClassName += " has-" + labelStyle + "-label-style";

	let pickerContainerClassName = isPickerOpen
		? pickerComponent + " colorPickerContainer is-open"
		: pickerComponent + " colorPickerContainer";

	const pickerTrigger = (
		<>
			<button
				type="button"
				ref={resetRef}
				className="wpbf-control-reset"
				onClick={handleReset}
				style={{ display: isPickerOpen ? "flex" : "none" }}
			>
				<i className="dashicons dashicons-image-rotate"></i>
			</button>

			<ColorPickerCircle
				pickerComponent={pickerComponent}
				useHueMode={useHueMode}
				color={
					!useHueMode
						? inputValue
						: colord({ h: inputValue, s: 100, l: 50 }).toHex()
				}
				isPickerOpen={isPickerOpen}
				togglePickerHandler={togglePicker}
			/>
		</>
	);

	let pickerHeader;

	switch (labelStyle) {
		case "tooltip":
			pickerHeader = (
				<>
					{pickerTrigger}
					{!isPickerOpen && (
						<div className="wpbf-label-tooltip">{controlHeader}</div>
					)}
				</>
			);
			break;

		case "top":
			pickerHeader = (
				<>
					{controlHeader}
					{pickerTrigger}
				</>
			);
			break;

		default:
			pickerHeader = (
				<>
					<div className="wpbf-control-cols">
						<div className="wpbf-control-left-col">{controlHeader}</div>
						<div className="wpbf-control-right-col">{pickerTrigger}</div>
					</div>
				</>
			);
			break;
	}

	return (
		<>
			<div className={formClassName} ref={formRef} tabIndex={1}>
				{pickerHeader}
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

					{renderColorPickerComponent()}

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
