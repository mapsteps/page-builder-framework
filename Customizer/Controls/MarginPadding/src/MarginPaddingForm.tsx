import React, { useRef, useState } from "react";
import { WpbfCustomizeSetting } from "../../Base/src/interface";
import {
	MarginPaddingDimension,
	MarginPaddingDimensionValuePair,
	MarginPaddingValue,
	WpbfCustomizeMarginPaddingControl,
} from "./interface";
import {
	makeObjValueWithoutUnit,
	makeObjValueWithoutUnitFromJson,
	makeObjValueWithUnit,
} from "./margin-padding-util";
import DeviceButtons from "../../Responsive/src/DeviceButtons";
import { encodeJsonOrDefault } from "../../Generic/src/string-util";

export default function MarginPaddingForm(props: {
	type: string;
	subtype: string;
	label?: string;
	description?: string;
	// setNotificationContainer: (el: HTMLElement) => void;
	setNotificationContainer: any;
	control: WpbfCustomizeMarginPaddingControl;
	customizerSetting?: WpbfCustomizeSetting<MarginPaddingValue | string>;
	default?: any;
	defaultArray: MarginPaddingValue;
	valueArray: MarginPaddingValue;
	unit: string;
	saveAsJson: boolean;
	dontSaveUnit: boolean;
	dimensions: string[];
	devices?: string[] | undefined;
	isResponsive: boolean;
}) {
	const [inputValues, setInputValues] = useState(() => {
		return props.valueArray;
	});

	const defaultDefined =
		"" !== props.default && "undefined" !== typeof props.default;

	props.control.updateComponentState = (val) => {
		const newVal =
			typeof val === "string"
				? makeObjValueWithoutUnitFromJson(props.dimensions, val)
				: makeObjValueWithoutUnit(props.dimensions, val);

		setInputValues(newVal);
	};

	function handleInputChange(
		e: React.ChangeEvent<HTMLInputElement>,
		dimension: string,
	) {
		if (!props.dimensions.includes(dimension)) {
			return;
		}

		if (!e.target) return;

		const values = { ...inputValues };
		if (!values.hasOwnProperty(dimension)) return;

		/**
		 * On input change, the value comes from a number field.
		 * That means we can just use its value without the need to parse it.
		 */
		values[dimension as MarginPaddingDimension] = e.target.value;

		setInputValues(values);
		saveToCustomizerSetting(values);
	}

	function handleResetButtonClick(
		_e: React.MouseEvent<HTMLButtonElement>,
		device?: string,
	) {
		const defaultValues = defaultDefined
			? props.defaultArray
			: props.valueArray;

		if (!device) {
			saveToCustomizerSetting(defaultValues);
			return;
		}

		const existingValues = { ...inputValues };

		for (const dimension in existingValues) {
			if (!existingValues.hasOwnProperty(dimension)) {
				continue;
			}

			const hasDeviceStr = dimension.includes(device + "_");
			if (!hasDeviceStr) continue;

			if (!defaultValues.hasOwnProperty(dimension)) {
				continue;
			}

			existingValues[dimension as MarginPaddingDimension] =
				defaultValues[dimension as MarginPaddingDimension];
		}

		saveToCustomizerSetting(existingValues);
	}

	function saveToCustomizerSetting(val: MarginPaddingValue) {
		/**
		 * The "dontSaveUnit" option is used to support PBF's old "responsive_padding" control.
		 */
		const newVal = props.dontSaveUnit
			? makeObjValueWithoutUnit(props.dimensions, val)
			: makeObjValueWithUnit(props.dimensions, props.unit, val);

		/**
		 * The "saveAsJson" option is used to support PBF's old "responsive_padding" control.
		 */
		if (props.saveAsJson) {
			props.customizerSetting?.set(
				encodeJsonOrDefault<MarginPaddingValue>(val),
			);
			return;
		}

		props.customizerSetting?.set(newVal);
	}

	function makeMappable(device?: string) {
		const items: MarginPaddingDimensionValuePair[] = [];

		for (const dimension in inputValues) {
			if (!inputValues.hasOwnProperty(dimension)) {
				continue;
			}

			if (!device) {
				items.push({
					dimension: dimension as MarginPaddingDimension,
					value: inputValues[dimension as MarginPaddingDimension],
				});

				continue;
			}

			const hasDeviceStr = dimension.includes(device + "_");
			if (!hasDeviceStr) continue;

			items.push({
				dimension: dimension as MarginPaddingDimension,
				value: inputValues[dimension as MarginPaddingDimension],
			});
		}

		return items;
	}

	function renderFields(
		device: string,
		group: MarginPaddingDimensionValuePair[],
	) {
		return (
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
						<div className="wpbf-control-fields">
							{group.map((item, i) => {
								const inputClassName = `wpbf-control-input wpbf-control-input${device ? `-${device}` : ""}-${item.dimension}`;
								const inputId = `_customize-input-${props.control.id}${device ? `-${device}` : ""}-${item.dimension}`;
								const label = device
									? item.dimension.replace(device + "_", "")
									: item.dimension;

								return (
									<div className="wpbf-control-field" key={i}>
										<input
											id={inputId}
											type="number"
											value={item.value || 0 === item.value ? item.value : ""}
											className={inputClassName}
											onChange={(e) => handleInputChange(e, item.dimension)}
										/>
										<label className="wpbf-control-sublabel" htmlFor={inputId}>
											{label}
										</label>
									</div>
								);
							})}
						</div>
					</div>
					<div className="wpbf-control-right-col">
						<span ref={unitRef} className="wpbf-control-unit">
							{props.unit}
						</span>
					</div>
				</div>
			</>
		);
	}

	function renderFieldGroups() {
		if (!props.isResponsive || !props.devices || !props.devices.length) {
			return renderFields("", makeMappable());
		}

		return (
			<>
				{props.devices.map((device, index) => {
					const isActive = 0 === index;

					return (
						<div
							className={`wpbf-control-device wpbf-control-${device} ${isActive ? "is-active" : ""}`}
							data-wpbf-device={device}
							key={index}
						>
							{renderFields(device, makeMappable(device))}
						</div>
					);
				})}
			</>
		);
	}

	function renderDeviceButtons() {
		if (!props.isResponsive || !props.devices || !props.devices.length) {
			return <></>;
		}

		return <DeviceButtons devices={props.devices} />;
	}

	const unitRef = useRef(null);

	return (
		<>
			<header className="wpbf-control-header">
				{props.label && (
					<label
						className="customize-control-title"
						htmlFor={`wpbf-control-input-${props.type}-top`}
					>
						<span className="customize-control-title">{props.label}</span>
					</label>
				)}

				{renderDeviceButtons()}
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
			/>

			<div className="wpbf-control-form">{renderFieldGroups()}</div>
		</>
	);
}
