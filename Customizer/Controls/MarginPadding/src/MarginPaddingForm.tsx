import React, { useRef, useState } from "react";
import { WpbfCustomizeSetting } from "../../Base/src/interfaces";
import {
	MarginPaddingDimension,
	MarginPaddingSingleValueObject,
	MarginPaddingValues,
	MarginPaddingValuesWithoutUnit,
	MarginPaddingValuesWithUnit,
	WpbfCustomizeMarginPaddingControl,
} from "./interface";

export default function MarginPaddingForm(props: {
	type: string;
	subtype: string;
	label?: string;
	description?: string;
	// setNotificationContainer: (el: HTMLElement) => void;
	setNotificationContainer: any;
	control: WpbfCustomizeMarginPaddingControl;
	customizerSetting: WpbfCustomizeSetting<any>;
	default?: any;
	defaultArray: MarginPaddingValues;
	valueArray: MarginPaddingValues;
	unit: string;
	dimensions: string[];
	devices?: string[] | undefined;
	isResponsive: boolean;
}) {
	const [inputValues, setInputValues] = useState(() => {
		return props.valueArray;
	});

	function parseSingleValueAsObject(
		value: string | number,
	): MarginPaddingSingleValueObject {
		let unit = "";
		let number: number = 0;

		if ("" !== value) {
			value = "string" !== typeof value ? value.toString() : value;
			value = value.trim();
			const negativeSign = -1 < value.indexOf("-") ? "-" : "";
			value = value.replace(negativeSign, "");

			let numeric = "";

			if ("" !== value) {
				unit = value.replace(/\d+/g, "");
				numeric = value.replace(unit, "");
				numeric = negativeSign + numeric.trim();

				number = parseFloat(numeric);
			}
		}

		return {
			unit: unit,
			number: number,
		};
	}

	function getValuesForInput(
		values: MarginPaddingValues,
	): MarginPaddingValuesWithoutUnit {
		// We allow empty string.
		const newValues: Record<string, number | string> = {};

		for (const dimension in props.dimensions) {
			if (props.dimensions.hasOwnProperty(dimension)) {
				newValues[dimension] = props.dimensions[dimension];
			}
		}

		for (const position in values) {
			if (!props.dimensions.includes(position)) {
				continue;
			}

			if (!values.hasOwnProperty(position)) continue;
			if (!newValues.hasOwnProperty(position)) continue;

			const positionValue = values[position];

			if ("" !== positionValue) {
				const singleValue = parseSingleValueAsObject(positionValue);
				newValues[position as MarginPaddingDimension] = singleValue.number;
			}
		}

		return newValues as MarginPaddingValuesWithoutUnit;
	}

	function getValuesForCustomizer(
		values: MarginPaddingValues,
	): MarginPaddingValuesWithUnit {
		// We allow empty string.
		const newValues: MarginPaddingValuesWithUnit = {
			top: "",
			right: "",
			bottom: "",
			left: "",
		};

		for (const position in values) {
			if (!props.dimensions.includes(position)) {
				continue;
			}

			if (!newValues.hasOwnProperty(position)) continue;

			const positionValue = values[position as MarginPaddingDimension];

			if ("" !== positionValue) {
				const singleValue = parseSingleValueAsObject(positionValue);
				newValues[position as MarginPaddingDimension] =
					singleValue.number + props.unit;
			}
		}

		return newValues;
	}

	props.control.updateComponentState = (val) => {
		setInputValues(getValuesForInput(val));
	};

	function handleChange(e: React.ChangeEvent, position: string) {
		if (!props.dimensions.includes(position)) {
			return;
		}

		if (!e.target) return;
		if (!(e.target instanceof HTMLInputElement)) return;

		let values = { ...inputValues };
		values[position as MarginPaddingDimension] = e.target.value;

		props.customizerSetting.set(getValuesForCustomizer(values));
	}

	function handleReset(_e: React.MouseEvent) {
		const values =
			"" !== props.default && "undefined" !== typeof props.default
				? props.defaultArray
				: props.valueArray;

		props.customizerSetting.set(getValuesForCustomizer(values));
	}

	// Preparing for the template.
	const fieldId = `wpbf-control-input-${props.type}-top`;
	const unitRef = useRef(null);

	function makeMappable(device?: string) {
		const items: {
			position: MarginPaddingDimension;
			value: string | number;
		}[] = [];

		for (const position in inputValues) {
			if (!inputValues.hasOwnProperty(position)) {
				continue;
			}

			if (!device) {
				items.push({
					position: position as MarginPaddingDimension,
					value: inputValues[position as MarginPaddingDimension],
				});

				continue;
			}

			const hasDeviceStr = position.includes(device + "_");
			if (!hasDeviceStr) continue;

			const positionWithoutDevice = position.replace(device + "_", "");

			items.push({
				position: positionWithoutDevice as MarginPaddingDimension,
				value: inputValues[position as MarginPaddingDimension],
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
		wrapperClassName: string,
		group: {
			position: MarginPaddingDimension;
			value: string | number;
		}[],
	) {
		return (
			<div className={`wpbf-control-cols ${wrapperClassName}`}>
				<div className="wpbf-control-left-col">
					<div className="wpbf-control-fields">
						{group.map((item) => {
							const inputClassName = `wpbf-control-input wpbf-control-input-${item.position}`;
							const inputId = `wpbf-control-input-${props.type}-${item.position}`;

							return (
								<div className="wpbf-control-field">
									<input
										id={inputId}
										type="number"
										value={item.value || 0 === item.value ? item.value : ""}
										className={inputClassName}
										onChange={(e) => handleChange(e, item.position)}
									/>
									<label className="wpbf-control-sublabel" htmlFor={inputId}>
										{item.position}
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
		);
	}

	function renderFieldGroups() {
		if (!props.isResponsive || !props.devices) {
			return renderFields("", makeMappable());
		}

		return (
			<>
				{props.devices.map((device, index) => {
					const isActive = 0 === index;
					const wrapperClassName = `wpbf-control-device wpbf-control-${device} ${isActive ? "active" : ""}`;

					return (
						<div className={wrapperClassName}>
							{renderFields("", makeMappable(device))}
						</div>
					);
				})}
			</>
		);
	}

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

			<button
				type="button"
				className="wpbf-control-reset"
				onClick={handleReset}
			>
				<i className="dashicons dashicons-image-rotate"></i>
			</button>

			{renderFieldGroups()}
		</div>
	);
}
