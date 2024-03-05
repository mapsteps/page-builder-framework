import React, { useRef, useState } from "react";
import { WpbfCustomizeSetting } from "../../Base/src/interfaces";
import {
	MarginPaddingDimension,
	MarginPaddingDimensionValuePair,
	MarginPaddingValue,
	WpbfCustomizeMarginPaddingControl,
} from "./interface";
import {
	makeJsonStrValueWithoutUnit,
	makeObjValueWithoutUnit,
	makeObjValueWithoutUnitFromJson,
	makeObjValueWithUnit,
	parseSingleValueAsObject,
} from "./utils";

export default function MarginPaddingForm(props: {
	type: string;
	subtype: string;
	label?: string;
	description?: string;
	// setNotificationContainer: (el: HTMLElement) => void;
	setNotificationContainer: any;
	control: WpbfCustomizeMarginPaddingControl;
	customizerSetting: WpbfCustomizeSetting<MarginPaddingValue | string>;
	default?: any;
	defaultArray: MarginPaddingValue;
	valueArray: MarginPaddingValue;
	unit: string;
	saveAsJson: boolean;
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

		const singleValue = parseSingleValueAsObject(e.target.value);
		values[dimension as MarginPaddingDimension] = singleValue.number;

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
		 * This "saveAsJson" option is used to support PBF's old "responsive_padding" control.
		 * That's why the value format is a JSON encoded version of the values (without units).
		 */
		if (props.saveAsJson) {
			const newVal = makeJsonStrValueWithoutUnit(props.dimensions, val);
			props.customizerSetting.set(newVal);
			return;
		}

		/**
		 * This is the default behavior.
		 * The value format is a `MarginPaddingValue` object with units.
		 */
		const newVal = makeObjValueWithUnit(props.dimensions, props.unit, val);
		props.customizerSetting.set(newVal);
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

	function renderDeviceButtons() {
		if (!props.isResponsive || !props.devices) {
			return <></>;
		}

		return (
			<ul className="wpbf-responsive-options">
				{props.devices.map((device, index) => {
					const deviceClassName = `dashicons dashicons-${device === "mobile" ? "smartphone" : device}`;

					return (
						<li className={device}>
							<button
								type="button"
								className={`preview-${device} ${0 === index ? "active" : ""}`}
								data-device={device}
							>
								<i className={deviceClassName}></i>
							</button>
						</li>
					);
				})}
			</ul>
		);
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

				<div className={`wpbf-control-cols ${wrapperClassName}`}>
					<div className="wpbf-control-left-col">
						<div className="wpbf-control-fields">
							{group.map((item) => {
								const inputClassName = `wpbf-control-input wpbf-control-input${device ? `-${device}` : ""}-${item.dimension}`;
								const inputId = `_customize-input-${props.control.id}${device ? `-${device}` : ""}-${item.dimension}`;
								const label = device
									? item.dimension.replace(device + "_", "")
									: item.dimension;

								return (
									<div className="wpbf-control-field">
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
					const wrapperClassName = `wpbf-control-device wpbf-control-${device} ${isActive ? "active" : ""}`;

					return (
						<div className={wrapperClassName}>
							{renderFields(device, makeMappable(device))}
						</div>
					);
				})}
			</>
		);
	}

	const fieldId = `wpbf-control-input-${props.type}-top`;
	const unitRef = useRef(null);
	const wrapperClassName = `wpbf-control-form ${props.isResponsive ? "wpbf-responsive-padding-wrap" : ""}`;

	return (
		<div className={wrapperClassName} tabIndex={1}>
			{(props.label || props.description) && (
				<>
					<label className="wpbf-control-label" htmlFor={fieldId}>
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

					<div
						className="customize-control-notifications-container"
						ref={props.setNotificationContainer}
					/>
				</>
			)}

			{renderDeviceButtons()}
			{renderFieldGroups()}
		</div>
	);
}