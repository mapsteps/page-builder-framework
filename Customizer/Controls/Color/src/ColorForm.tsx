/**
 * The form of the color type (see color-control.ts): a color circle that opens a picker with swatches, the picker
 * (react-colorful) and a text field.
 *
 * The value is the setting's (useSettingValue): the circle, picker and field all show it and follow every change
 * (this form, another control, a reset, a restored draft). What each part hands to the setting is unchanged: the
 * picker's color in the format of the mode / form component (convert-color-for-customizer.ts), the hue as a number.
 */
import { useMemo, useRef, useState } from "@wordpress/element";
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
import { colord, HslaColor, HslColor, HsvaColor, HsvColor, RgbaColor, RgbColor } from "colord";
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
import { WpbfCustomizeColorControlParams, WpbfCustomizeColorControlValue } from "./interface";
import { Notifications, ReactControlFormProps, useSettingValue } from "../../Base/src/react-base";

// Declare global extends jQuery to have wp property.
declare global {
	interface JQueryStatic {
		wp: any;
	}
}

type Props = ReactControlFormProps<WpbfCustomizeColorControlValue, WpbfCustomizeColorControlParams>;

/**
 * The picker component of the control: the form component if given, else from the mode.
 */
function pickerComponentOf(params: WpbfCustomizeColorControlParams): string {
	if ("hue" === params.mode) return "HueColorPicker";
	if (params.formComponent) return params.formComponent;

	return "alpha" === params.mode || "hue" === params.mode ? "RgbaStringColorPicker" : "HexColorPicker";
}

const sameValue = (a: unknown, b: unknown) => a === b || JSON.stringify(a) === JSON.stringify(b);

export default function ColorForm({ control }: Props) {
	const params = control.params;
	const useHueMode = "hue" === params.mode;
	const pickerComponent = pickerComponentOf(params);
	const labelStyle = params.labelStyle;

	const [value, setValue] = useSettingValue(control, params.value);

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
			: convertColorForInput(value, pickerComponent, params.formComponent).replace(";", "");
	}

	function parseCustomizerValue(value: any) {
		if ("" === value) return "";

		return convertColorForCustomizer(value, pickerComponent, params.formComponent);
	}

	function parsePickerValue(value: any) {
		value = value || parseEmptyValue();

		// Hard coded saturation and lightness when using hue mode.
		return useHueMode ? { h: value, s: 100, l: 50 } : convertColorForPicker(value, pickerComponent);
	}

	/**
	 * The value as the setting stores it (what the old form handed over).
	 */
	function toSettingValue(value: any) {
		if (useHueMode) {
			/**
			 * When using hue mode, the pickerComponent is HslColorPicker.
			 * If there is value.h, then value is set from the picker.
			 * Otherwise, value is set from the input or the customizer.
			 */
			value = value.h || 0 === value.h ? value.h : value;

			return parseHueModeValue(value);
		}

		return parseCustomizerValue(value);
	}

	// The field shows the value; a short hex is shown long once the picker opens or closes (the value stays).
	const [longHex, setLongHex] = useState<{ value: unknown; text: string } | null>(null);
	const parsedInput = useMemo(() => parseInputValue(value), [value]);
	const inputValue = longHex && longHex.value === value ? longHex.text : parsedInput;

	// The picker shows the color it handed over as long as the value is still the one it produced: converting back
	// from the stored format can round (e.g. hsla → rgb → hsla) and would make the picker jump while dragging.
	const emitted = useRef<{ color: any; stored: unknown } | null>(null);
	const parsedPicker = useMemo(() => parsePickerValue(value), [value]);
	const pickerValue = emitted.current && sameValue(emitted.current.stored, value) ? emitted.current.color : parsedPicker;

	const initialColor = "" !== params.default && "undefined" !== typeof params.default ? params.default : params.value;

	/**
	 * Function to run on picker change.
	 *
	 * @param {string|Object} color The value returned by the picker. It can be a string or a color object.
	 */
	const handlePickerChange = (color: any) => {
		const stored = toSettingValue(color);

		emitted.current = { color, stored };
		setValue(stored);
	};

	const handleInputChange = (color: any) => {
		setValue(toSettingValue(color));
	};

	const handleReset = () => {
		setValue(toSettingValue(initialColor));
	};

	const handleSwatchesClick = (swatchColor: any) => {
		setValue(toSettingValue(swatchColor));
	};

	const handleWindowResize = () => {
		setPickerContainerStyle(getPickerContainerStyle());
	};

	let controlLabel = (
		<span className="customize-control-title" dangerouslySetInnerHTML={{ __html: params.label }} />
	);

	let controlDescription = (
		<span
			className="description customize-control-description"
			dangerouslySetInnerHTML={{ __html: params.description }}
		></span>
	);

	controlLabel = (
		<label className="wpbf-control-label">
			{params.label ? controlLabel : ""}
			{params.description ? controlDescription : ""}
		</label>
	);

	controlLabel = params.label || params.description ? controlLabel : <></>;

	const formRef = useRef(null); // Reference to the form div.
	const pickerRef = useRef(null); // Reference to the picker popup.
	const resetRef = useRef(null); // Reference to the reset button.

	const [isPickerOpen, setIsPickerOpen] = useState(false);

	const usePositionFixed = "default" !== labelStyle;

	const [pickerContainerStyle, setPickerContainerStyle] = useState({});

	const getPickerContainerStyle = () => {
		let pickerContainerStyle: Record<string, any> = {};

		if (!usePositionFixed) return pickerContainerStyle;

		const rawPadding = window.getComputedStyle(control.container[0].parentNode as HTMLElement).paddingLeft;

		const padding = parseInt(rawPadding, 10) * 2;

		pickerContainerStyle.width =
			(control.container[0].parentNode as HTMLElement).getBoundingClientRect().width - padding;

		const controlLeftOffset = (control.container[0].offsetLeft - 9) * -1;

		pickerContainerStyle.left = controlLeftOffset + "px";

		return pickerContainerStyle;
	};

	const convertInputValueTo6Digits = () => {
		if ("string" === typeof inputValue && 4 === inputValue.length && inputValue.includes("#")) {
			setLongHex({ value, text: colord(inputValue).toHex() });
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
				return <HexColorPicker color={pickerValue as string} onChange={handlePickerChange} />;
			case "RgbColorPicker":
				return <RgbColorPicker color={pickerValue as RgbColor} onChange={handlePickerChange} />;
			case "RgbStringColorPicker":
				return <RgbStringColorPicker color={pickerValue as string} onChange={handlePickerChange} />;
			case "RgbaColorPicker":
				return <RgbaColorPicker color={pickerValue as RgbaColor} onChange={handlePickerChange} />;
			case "RgbaStringColorPicker":
				return <RgbaStringColorPicker color={pickerValue as string} onChange={handlePickerChange} />;
			// We treat HueColorPicker (hue mode) as HslColorPicker.
			case "HueColorPicker":
				return <HslColorPicker color={pickerValue as HslColor} onChange={handlePickerChange} />;
			case "HslColorPicker":
				return <HslColorPicker color={pickerValue as HslColor} onChange={handlePickerChange} />;
			case "HslStringColorPicker":
				return <HslStringColorPicker color={pickerValue as string} onChange={handlePickerChange} />;
			case "HslaColorPicker":
				return <HslaColorPicker color={pickerValue as HslaColor} onChange={handlePickerChange} />;
			case "HslaStringColorPicker":
				return <HslaStringColorPicker color={pickerValue as string} onChange={handlePickerChange} />;
			case "HsvColorPicker":
				return <HsvColorPicker color={pickerValue as HsvColor} onChange={handlePickerChange} />;
			case "HsvStringColorPicker":
				return <HsvStringColorPicker color={pickerValue as string} onChange={handlePickerChange} />;
			case "HsvaColorPicker":
				return <HsvaColorPicker color={pickerValue as HsvaColor} onChange={handlePickerChange} />;
			case "HsvaStringColorPicker":
				return <HsvaStringColorPicker color={pickerValue as string} onChange={handlePickerChange} />;
			default:
				return <HexColorPicker color={pickerValue as string} onChange={handlePickerChange} />;
		}
	}

	useWindowResize(handleWindowResize);

	// Handle outside focus to close the picker popup.
	useFocusOutside(formRef, closePicker);

	// Handle outside click to close the picker popup.
	useClickOutside(pickerRef, resetRef, closePicker);

	let colorSwatches: Array<string | { color: string } | undefined> = params.colorSwatches;

	if (jQuery.wp && jQuery.wp.wpColorPicker) {
		const wpColorPickerSwatches = jQuery.wp.wpColorPicker.prototype.options.palettes;

		// If 3rd parties applied custom colors to wpColorPicker swatches (e.g. Premium's palette), let's use them.
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
			<Notifications control={control} />
		</>
	);

	let formClassName = useHueMode ? "wpbf-control-form use-hue-mode" : "wpbf-control-form";

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
				color={!useHueMode ? inputValue : colord({ h: inputValue, s: 100, l: 50 }).toHex()}
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
					{!isPickerOpen && <div className="wpbf-label-tooltip">{controlHeader}</div>}
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
			<div className={formClassName} ref={formRef} tabIndex={-1}>
				{pickerHeader}
				<div ref={pickerRef} className={pickerContainerClassName} style={pickerContainerStyle}>
					{!useHueMode && <ColorPickerSwatches colors={colorSwatches} onClick={handleSwatchesClick} />}

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
