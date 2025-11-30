import { ChangeEvent, MouseEvent, useState, useEffect } from "react";
import DeviceButtons from "../../Responsive/src/DeviceButtons";
import {
	makeDevicesValue,
	makeValueForInput,
	makeValueForSlider,
} from "./slider-util";
import { DevicesValue } from "../../Responsive/src/responsive-interface";
import { encodeJsonOrDefault } from "../../Generic/src/string-util";
import { makeLimitedNumberUnitPair } from "../../Generic/src/number-util";

declare var wp: { customize: WpbfCustomize };

export default function ResponsiveInputSliderForm(props: {
	id: string;
	overrideUpdateComponentStateFn?: (
		fn: (val: string | DevicesValue) => void,
	) => void;
	updateCustomizerSetting?: (val: string | DevicesValue) => void;
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

	// Track the active device based on wp.customize.previewedDevice
	const [activeDevice, setActiveDevice] = useState(
		typeof wp !== "undefined" && wp.customize?.previewedDevice?.get()
			? wp.customize.previewedDevice.get()
			: props.devices[0],
	);

	// Listen to preview device changes
	useEffect(() => {
		if (typeof wp === "undefined" || !wp.customize?.previewedDevice) {
			return;
		}

		const callback = (device: string) => {
			if (props.devices.includes(device)) {
				setActiveDevice(device);
			}
		};

		wp.customize.previewedDevice.bind(callback);

		return () => {
			wp.customize.previewedDevice.unbind(callback);
		};
	}, [props.devices]);

	/**
	 * This function will be called when the value from the customizer setting changes.
	 * This can be from either it's own control or from another control that is linked to it.
	 *
	 * @param {string|DevicesValue} val - The value from customizer setting.
	 */
	function updateComponentState(val: string | DevicesValue) {
		const devicesValue = makeDevicesValue(
			props.devices,
			val,
			props.min,
			props.max,
		);

		setActualValue(devicesValue);
	}

	props.overrideUpdateComponentStateFn?.(updateComponentState);

	function updateCustomizerSetting(val: DevicesValue) {
		const valueToSave = props.saveAsJson
			? encodeJsonOrDefault<DevicesValue>(val)
			: val;

		props.updateCustomizerSetting?.(valueToSave);
	}

	function handleInputChange(e: ChangeEvent<HTMLInputElement>, device: string) {
		const devicesValue = actualValue;

		if (!devicesValue.hasOwnProperty(device)) {
			return;
		}

		const fieldValue = makeValueForInput(e.target.value, props.min, props.max);
		devicesValue[device] = fieldValue;

		updateCustomizerSetting(devicesValue);
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

		// Since range field doesn't have unit, we're going to get the unit from the input field.
		const numberUnitPair = makeLimitedNumberUnitPair(
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

		updateCustomizerSetting(devicesValue);
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

		updateCustomizerSetting(devicesValue);
	}

	return (
		<>
			<header className="wpbf-control-header">
				{props.label && (
					<label
						className="customize-control-title"
						htmlFor={`wpbf-control-input-${props.id}`}
					>
						<span className="customize-control-title">{props.label}</span>
					</label>
				)}

				<DeviceButtons devices={props.devices} />
			</header>

			{props.description && (
				<span
					className="customize-control-description description"
					dangerouslySetInnerHTML={{ __html: props.description }}
				/>
			)}

			<div
				className="customize-control-notifications-container"
				ref={props.setNotificationContainer}
			></div>

			<div className="wpbf-control-form">
				{props.devices.map((device, deviceIndex) => {
					const isActive = device === activeDevice;

					return (
						<div
							className={`wpbf-control-device wpbf-control-${device} ${isActive ? "is-active" : ""}`}
							data-wpbf-device={device}
							key={deviceIndex}
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
												id={`wpbf-control-input-${props.id}-${device}`}
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
		</>
	);
}
