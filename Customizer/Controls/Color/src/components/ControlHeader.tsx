import React from "react";
import ColorPickerTrigger from "./ColorPickerTrigger";
import ControlLabel from "./ControlLabel";
import { colord } from "colord";
import { isNumeric } from "../utils/misc";
import { ColorControlLabelStyle } from "../color-interface";

export default function ControlHeader(props: {
	label: string;
	description: string;
	labelStyle: ColorControlLabelStyle;
	pickerComponent: string;
	useHueMode: boolean;
	inputValue?: string | number;
	isPickerOpen?: boolean;
	togglePicker?: () => void;
	resetRef?: React.LegacyRef<HTMLButtonElement> | null;
	onResetButtonClick: () => void;
	setNotificationContainer?: any;
}) {
	const {
		label,
		description,
		isPickerOpen,
		labelStyle,
		inputValue,
		setNotificationContainer,
	} = props;

	function renderHeader() {
		return (
			<ControlLabel
				label={label}
				description={description}
				setNotificationContainer={setNotificationContainer}
			/>
		);
	}

	function renderTrigger() {
		if (
			typeof inputValue === "undefined" ||
			typeof isPickerOpen === "undefined"
		) {
			return <></>;
		}

		let color = inputValue;

		if (props.useHueMode) {
			color = isNumeric(inputValue) ? Number(inputValue) : 0;
			color = colord({ h: color, s: 100, l: 50 }).toHex();
		}

		color = String(color);

		return (
			<ColorPickerTrigger
				color={color}
				isPickerOpen={isPickerOpen}
				resetRef={props.resetRef}
				onToggleButtonClick={props.togglePicker}
				onResetButtonClick={props.onResetButtonClick}
			/>
		);
	}

	switch (labelStyle) {
		case "tooltip":
			return (
				<>
					{renderTrigger()}
					{!isPickerOpen && (
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

		case "none":
			return renderTrigger();
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
