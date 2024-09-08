import React, { useEffect, useState } from "react";
import { colorBgImgData } from "../utils/misc";

export default function ColorPickerCircle(props: {
	color?: string;
	onToggleButtonClick?: () => void;
}) {
	const { color, onToggleButtonClick } = props;
	const [value, setValue] = useState(() => color);

	// Update the local state when `color` property value is changed.
	useEffect(() => {
		// We don't need to convert the color since it's using the customizer value.
		setValue(color);
	}, [color]);

	// Thanks Blocksy!
	const triggerButtonBgImage = `url("${colorBgImgData}")`;

	return (
		<div className="wpbf-trigger-circle-wrapper">
			<button
				type="button"
				className="wpbf-trigger-circle"
				onClick={onToggleButtonClick}
				style={{
					backgroundImage: triggerButtonBgImage,
				}}
			>
				<div
					className="wpbf-color-preview"
					style={{
						backgroundColor: value ? value : "transparent",
					}}
				></div>
			</button>
		</div>
	);
}
