import React from "react";
import ColorPickerCircle from "./ColorPickerCircle";

export default function ColorPickerTrigger(props: {
	inputValue: string;
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
				color={props.inputValue}
				isPickerOpen={props.isPickerOpen}
				onToggleButtonClick={props.onToggleButtonClick}
			/>
		</>
	);
}
