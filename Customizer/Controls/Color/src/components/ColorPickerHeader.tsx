import React from "react";
import ControlHeader from "./ControlHeader";
import ColorPickerTrigger from "./ColorPickerTrigger";
import { colord } from "colord";

export default function ColorPickerHeader(props: {
	label: string;
	description: string;
	labelStyle: string;
	pickerComponent: string;
	useHueMode: boolean;
	inputValue: string | number;
	isPickerOpen: boolean;
	togglePicker: () => void;
	resetRef: React.LegacyRef<HTMLButtonElement> | null;
	onResetButtonClick: () => void;
	setNotificationContainer: any;
}) {
	function renderHeader() {
		return (
			<ControlHeader
				label={props.label}
				description={props.description}
				labelStyle={props.labelStyle}
				setNotificationContainer={props.setNotificationContainer}
			/>
		);
	}

	function renderTrigger() {
		return (
			<ColorPickerTrigger
				inputValue={
					typeof props.inputValue === "number"
						? colord({ h: props.inputValue, s: 100, l: 50 }).toHex()
						: props.inputValue
				}
				pickerComponent={props.pickerComponent}
				isPickerOpen={props.isPickerOpen}
				resetRef={props.resetRef}
				onToggleButtonClick={props.togglePicker}
				onResetButtonClick={props.onResetButtonClick}
			/>
		);
	}

	switch (props.labelStyle) {
		case "tooltip":
			return (
				<>
					{renderTrigger()}
					{!props.isPickerOpen && (
						<div className="wpbf-label-tooltip">{renderHeader()}</div>
					)}
				</>
			);

		case "top":
			return (
				<>
					{renderHeader()}
					{renderTrigger()}
				</>
			);
	}

	return (
		<>
			<div className="wpbf-control-cols">
				<div className="wpbf-control-left-col">{renderHeader()}</div>
				<div className="wpbf-control-right-col">{renderTrigger()}</div>
			</div>
		</>
	);
}
