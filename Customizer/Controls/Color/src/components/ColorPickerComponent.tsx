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
	HslaColor,
	HslColor,
	HsvaColor,
	HsvColor,
	RgbaColor,
	RgbColor,
} from "colord";
import { WpbfColorPickerValue } from "../color-interface";

export default function ColorPickerComponent(props: {
	pickerComponent: string;
	value: WpbfColorPickerValue;
	onChange: (e: WpbfColorPickerValue) => void;
}) {
	const { pickerComponent, value, onChange } = props;

	switch (pickerComponent) {
		case "HexColorPicker":
			return <HexColorPicker color={value as string} onChange={onChange} />;
		case "RgbColorPicker":
			return <RgbColorPicker color={value as RgbColor} onChange={onChange} />;
		case "RgbStringColorPicker":
			return (
				<RgbStringColorPicker color={value as string} onChange={onChange} />
			);
		case "RgbaColorPicker":
			return <RgbaColorPicker color={value as RgbaColor} onChange={onChange} />;
		case "RgbaStringColorPicker":
			return (
				<RgbaStringColorPicker color={value as string} onChange={onChange} />
			);
		// We treat HueColorPicker (hue mode) as HslColorPicker.
		case "HueColorPicker":
			return <HslColorPicker color={value as HslColor} onChange={onChange} />;
		case "HslColorPicker":
			return <HslColorPicker color={value as HslColor} onChange={onChange} />;
		case "HslStringColorPicker":
			return (
				<HslStringColorPicker color={value as string} onChange={onChange} />
			);
		case "HslaColorPicker":
			return <HslaColorPicker color={value as HslaColor} onChange={onChange} />;
		case "HslaStringColorPicker":
			return (
				<HslaStringColorPicker color={value as string} onChange={onChange} />
			);
		case "HsvColorPicker":
			return <HsvColorPicker color={value as HsvColor} onChange={onChange} />;
		case "HsvStringColorPicker":
			return (
				<HsvStringColorPicker color={value as string} onChange={onChange} />
			);
		case "HsvaColorPicker":
			return <HsvaColorPicker color={value as HsvaColor} onChange={onChange} />;
		case "HsvaStringColorPicker":
			return (
				<HsvaStringColorPicker color={value as string} onChange={onChange} />
			);
		default:
			return <HexColorPicker color={value as string} onChange={onChange} />;
	}
}
