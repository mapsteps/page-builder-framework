import React, { useState, useEffect } from "react";

export type ColorPickerCircleProps = {
	color?: string;
	togglePickerHandler: () => void;
};

export default function ColorPickerCircle(props: ColorPickerCircleProps) {
	const { color = "" } = props;
	const [value, setValue] = useState(() => color);

	// Update the local state when `color` property value is changed.
	useEffect(() => {
		// We don't need to convert the color since it's using the customizer value.
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

	const triggerButtonBgImage =
		'url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAIAAAHnlligAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAHJJREFUeNpi+P///4EDBxiAGMgCCCAGFB5AADGCRBgYDh48CCRZIJS9vT2QBAggFBkmBiSAogxFBiCAoHogAKIKAlBUYTELAiAmEtABEECk20G6BOmuIl0CIMBQ/IEMkO0myiSSraaaBhZcbkUOs0HuBwDplz5uFJ3Z4gAAAABJRU5ErkJggg==")';

	return (
		<div className="kirki-trigger-circle-wrapper">
			<button
				type="button"
				className="kirki-trigger-circle"
				onClick={props.togglePickerHandler}
				style={{
					backgroundImage: triggerButtonBgImage,
				}}
			>
				<div
					className="kirki-color-preview"
					style={{
						backgroundColor: value ? value : "transparent",
					}}
				></div>
			</button>
		</div>
	);
}