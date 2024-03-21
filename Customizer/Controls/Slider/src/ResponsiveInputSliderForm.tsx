import React, { ChangeEvent, MouseEvent, useState } from "react";
import { WpbfCustomizeSetting } from "../../Base/src/interface";
import { WpbfCustomizeResponsiveInputSliderControl } from "./interface";
import DeviceButtons from "../../Responsive/src/DeviceButtons";
import {
	makeDevicesValue,
	makeNumberUnitPair,
	makeValueForInput,
	makeValueForSlider,
} from "./slider-util";
import { DevicesValue } from "../../Responsive/src/interface";
import { encodeJsonOrDefault } from "../../Generic/src/string-util";

export default function ResponsiveInputSliderForm(props: {
	control: WpbfCustomizeResponsiveInputSliderControl;
	customizerSetting: WpbfCustomizeSetting<string | DevicesValue>;
	setNotificationContainer: any;
	saveAsJson: boolean;
	devices: string[];
	label: string | undefined;
	description: string | undefined;
	min: number;
	max: number;
	step: number;
	default: string | DevicesValue;
	value: string | DevicesValue;
}) {
	const defaultValue = makeDevicesValue(
		props.devices,
		props.default,
		props.min,
		props.max,
	);

	const [actualValue, setActualValue] = useState(
		makeDevicesValue(props.devices, props.value, props.min, props.max),
	);

	/**
	 * This function will be called when the value from the customizer setting changes.
	 * This can be from either it's own control or from another control that is linked to it.
	 *
	 * @param {string|DevicesValue} val - The value from customizer setting.
	 */
	props.control.updateComponentState = (val: string | DevicesValue) => {
		const devicesValue = makeDevicesValue(
			props.devices,
			val,
			props.min,
			props.max,
		);

		setActualValue(devicesValue);
	};

	function saveToCustomizerSetting(val: DevicesValue) {
		props.customizerSetting.set(
			props.saveAsJson ? encodeJsonOrDefault<DevicesValue>(val) : val,
		);
	}

	function handleInputChange(e: ChangeEvent<HTMLInputElement>, device: string) {
		const devicesValue = actualValue;

		if (!devicesValue.hasOwnProperty(device)) {
			return;
		}

		const fieldValue = makeValueForInput(e.target.value, props.min, props.max);
		devicesValue[device] = fieldValue;

		saveToCustomizerSetting(devicesValue);
	}

	function handleSliderChange(
		e: ChangeEvent<HTMLInputElement>,
		device: string,
	) {
		const devicesValue = actualValue;

		if (!devicesValue.hasOwnProperty(device)) {
			return;
		}

		const fieldValue = makeValueForSlider(e.target.value, props.min, props.max);
		const existingValue = devicesValue[device];

		if (existingValue === fieldValue) {
			return;
		}

		const numberUnitPair = makeNumberUnitPair(
			existingValue,
			props.min,
			props.max,
		);

		if (numberUnitPair.number === fieldValue) {
			return;
		}

		devicesValue[device] = numberUnitPair.unit
			? fieldValue + numberUnitPair.unit
			: fieldValue;

		saveToCustomizerSetting(devicesValue);
	}

	function handleResetButtonClick(
		e: MouseEvent<HTMLButtonElement>,
		device: string,
	) {
		const devicesValue = actualValue;

		if (
			!devicesValue.hasOwnProperty(device) ||
			!defaultValue.hasOwnProperty(device)
		) {
			return;
		}

		devicesValue[device] = defaultValue[device];

		saveToCustomizerSetting(devicesValue);
	}

	return (
		<div
			className="wpbf-control-form wpbf-responsive-padding-wrap"
			tabIndex={1}
		>
			{props.label || props.description ? (
				<label
					className="wpbf-control-label"
					htmlFor={`wpbf-control-input-${props.customizerSetting.id}`}
				>
					{props.label && (
						<span className="customize-control-title">{props.label}</span>
					)}

					{props.description && (
						<span
							className="customize-control-description description"
							dangerouslySetInnerHTML={{ __html: props.description }}
						/>
					)}
				</label>
			) : null}

			<div
				className="customize-control-notifications-container"
				ref={props.setNotificationContainer}
			></div>

			<DeviceButtons devices={props.devices} />

			{props.devices.map((device, deviceIndex) => {
				const isActive = 0 === deviceIndex;

				return (
					<div
						className={`wpbf-control-device wpbf-control-${device} ${isActive ? "active" : ""}`}
					>
						{actualValue.hasOwnProperty(device) && (
							<>
								<button
									type="button"
									className="wpbf-control-reset"
									onClick={(e) => handleResetButtonClick(e, device)}
								>
									<i className="dashicons dashicons-image-rotate"></i>
								</button>

								<div className="wpbf-control-cols">
									<div className="wpbf-control-left-col">
										<input
											type="range"
											id={`wpbf-control-input-${props.customizerSetting.id}-${device}`}
											value={makeValueForSlider(
												actualValue[device],
												props.min,
												props.max,
											)}
											min={props.min}
											max={props.max}
											step={props.step}
											className="wpbf-control-input-slider wpbf-pro-control-input-slider"
											onChange={(e) => handleSliderChange(e, device)}
										/>
									</div>
									<div className="wpbf-control-right-col">
										<input
											type="text"
											value={makeValueForInput(
												actualValue[device],
												props.min,
												props.max,
											)}
											className="wpbf-control-input"
											onChange={(e) => handleInputChange(e, device)}
										/>
									</div>
								</div>
							</>
						)}
					</div>
				);
			})}
		</div>
	);
}