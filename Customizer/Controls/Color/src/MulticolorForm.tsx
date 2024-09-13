import React from "react";
import ColorForm from "./ColorForm";
import ControlHeader from "./components/ControlHeader";
import {
	WpbfCustomizeMulticolorControlValue,
	WpbfCustomizeMulticolorControl,
	ColorControlLabelStyle,
} from "./color-interface";

export default function MulticolorForm(props: {
	control: WpbfCustomizeMulticolorControl;
	container: HTMLElement;
	choices: Record<string, string>;
	keys: string[];
	label: string;
	description: string;
	useHueMode: boolean;
	pickerComponent: string;
	labelStyle: ColorControlLabelStyle;
	colorSwatches: Array<string | { color: string } | undefined>;
	value: WpbfCustomizeMulticolorControlValue;
	default: WpbfCustomizeMulticolorControlValue;
	setNotificationContainer: any;
	formComponent?: string;
	onChange?: (value: WpbfCustomizeMulticolorControlValue) => void;
	onReset?: () => void;
}) {
	const {
		control,
		container,
		useHueMode,
		pickerComponent,
		formComponent,
		label,
		description,
	} = props;

	// This function will be called when this control's customizer value is changed.
	control.updateColorPickers = function (value) {
		//
	};

	function handleReset() {
		props.onReset?.();
	}

	function renderForms() {
		return props.keys.map((key) => {
			return (
				<ColorForm
					control={control}
					container={container}
					label={props.label}
					description={props.description}
					useHueMode={useHueMode}
					formComponent={formComponent}
					pickerComponent={pickerComponent}
					labelStyle="tooltip"
					colorSwatches={props.colorSwatches}
					value={props.value[key]}
					default={props.default[key]}
					setNotificationContainer={props.setNotificationContainer}
				/>
			);
		});
	}

	return (
		<>
			<div className="wpbf-multicolor">
				<ControlHeader
					label={label}
					description={description}
					labelStyle="none"
					pickerComponent={pickerComponent}
					useHueMode={useHueMode}
					onResetButtonClick={handleReset}
					setNotificationContainer={props.setNotificationContainer}
				/>

				{renderForms()}
			</div>
		</>
	);
}
