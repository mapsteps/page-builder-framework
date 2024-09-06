import React from "react";
import ColorPickerCircle from "./ColorPickerCircle";
import { colord } from "colord";

export default function ColorPickerTrigger(props: {
	inputValue: string;
	useHueMode: boolean;
	pickerComponent: string;
	isPickerOpen: boolean;
	resetRef: React.LegacyRef<HTMLButtonElement> | null;
	onToggleButtonClick: () => void;
	onResetButtonClick: () => void;
}) {
	return (
		<>
			<button
				type="button"
				ref={props.resetRef}
				className="wpbf-control-reset"
				onClick={props.onResetButtonClick}
				style={{ display: props.isPickerOpen ? "flex" : "none" }}
			>
				<i className="dashicons dashicons-image-rotate"></i>
			</button>

			<ColorPickerCircle
				pickerComponent={props.pickerComponent}
				useHueMode={props.useHueMode}
				color={
					props.useHueMode && typeof props.inputValue === "number"
						? colord({ h: props.inputValue, s: 100, l: 50 }).toHex()
						: props.inputValue
				}
				isPickerOpen={props.isPickerOpen}
				onToggleButtonClick={props.onToggleButtonClick}
			/>
		</>
	);
}
