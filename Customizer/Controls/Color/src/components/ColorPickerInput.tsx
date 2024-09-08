import React, { ChangeEvent, useCallback, useEffect, useState } from "react";
import { colorBgImgData } from "../utils/misc";

export default function ColorPickerInput(props: {
	onChange: (color: string) => void;
	pickerComponent: string;
	useHueMode: boolean;
	color?: string | number;
}) {
	const { onChange, pickerComponent, useHueMode, color } = props;
	const [value, setValue] = useState(() => color);

	const handleInputChange = useCallback(
		(e: ChangeEvent) => {
			const target = e.target as HTMLInputElement | undefined;
			let val = target?.value ?? "";

			if (2 === val.length) {
				if (!val.includes("#") && !val.includes("rg") && !val.includes("hs")) {
					val = "#" + val;
				}
			} else if (3 === val.length || 6 === val.length) {
				if (!val.includes("#") && !val.includes("rg") && !val.includes("hs")) {
					val = "#" + val;
				}
			}

			val = val.toLowerCase();

			// Thank you: https://regexr.com/39cgj
			const pattern = new RegExp(
				/(?:#|0x)(?:[a-f0-9]{3}|[a-f0-9]{6}|[a-f0-9]{8})\b|(?:rgb|hsl)a?\([^)]*\)/,
			);

			if ("" === val || pattern.test(val)) {
				// Run onChange handler passed by `ColorForm` component.
				onChange(val);
			}

			setValue(val);
		},
		[onChange],
	);

	// Update the local state when `color` property value is changed.
	useEffect(() => {
		// We don't need to convert the color since it's already handled in parent component.
		setValue(color);
	}, [color]);

	const pickersWithAlpha = [
		"RgbaColorPicker",
		"RgbaStringColorPicker",
		"HslaColorPicker",
		"HslaStringColorPicker",
		"HsvaColorPicker",
		"HsvaStringColorPicker",
	];

	const previewWrapperBgImg = pickersWithAlpha.includes(pickerComponent)
		? `url("${colorBgImgData}")`
		: "none";

	/**
	 * Parse value to be used as background color.
	 *
	 * This is only used for non-hue mode.
	 */
	function parseBgColorValue() {
		if (useHueMode || typeof value === "number") {
			return "transparent";
		}

		return value ?? "transparent";
	}

	return (
		<div className="wpbf-color-input-wrapper">
			<div className="wpbf-color-input-control">
				{!useHueMode && (
					<div
						className="wpbf-color-preview-wrapper"
						style={{
							backgroundImage: previewWrapperBgImg,
						}}
					>
						<button
							type="button"
							className="wpbf-color-preview"
							style={{
								backgroundColor: parseBgColorValue(),
							}}
						></button>
					</div>
				)}
				<input
					type="text"
					value={value ?? ""}
					className="wpbf-color-input"
					spellCheck="false"
					onChange={handleInputChange}
				/>
			</div>
		</div>
	);
}
