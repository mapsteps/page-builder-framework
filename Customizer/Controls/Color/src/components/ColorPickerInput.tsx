import React, { ChangeEvent, useCallback, useEffect, useState } from "react";

export type ColorPickerInputProps = {
	onChange: (color: string) => void;
	color?: string;
	pickerComponent: string;
	useHueMode: boolean;
};

export default function ColorPickerInput(props: ColorPickerInputProps) {
	const { onChange, color = "" } = props;
	const [value, setValue] = useState(() => color);

	const handleChange = useCallback(
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
				onChange(val); // Run onChange handler passed by `KirkiReactColorfulForm` component.
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

	const previewWrapperBgImg = pickersWithAlpha.includes(props.pickerComponent)
		? 'url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAIAAAHnlligAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAHJJREFUeNpi+P///4EDBxiAGMgCCCAGFB5AADGCRBgYDh48CCRZIJS9vT2QBAggFBkmBiSAogxFBiCAoHogAKIKAlBUYTELAiAmEtABEECk20G6BOmuIl0CIMBQ/IEMkO0myiSSraaaBhZcbkUOs0HuBwDplz5uFJ3Z4gAAAABJRU5ErkJggg==")'
		: "none";

	return (
		<div className="wpbf-color-input-wrapper">
			<div className="wpbf-color-input-control">
				{!props.useHueMode && (
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
								backgroundColor: value,
							}}
						></button>
					</div>
				)}
				<input
					type="text"
					value={value}
					className="wpbf-color-input"
					spellCheck="false"
					onChange={handleChange}
				/>
			</div>
		</div>
	);
}
