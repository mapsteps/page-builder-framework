import React, { ChangeEvent, MouseEvent, useRef } from "react";
import {
	WpbfCustomizeControl,
	WpbfCustomizeSetting,
} from "../../Base/src/interfaces";
import { ValueObject } from "./interface";

export default function InputSliderForm(props: {
	control: WpbfCustomizeControl;
	customizerSetting: WpbfCustomizeSetting<string | number>;
	setNotificationContainer: any;
	label: string | undefined;
	description: string | undefined;
	min: number;
	max: number;
	step: number;
	default: string | number;
	value: string | number;
}) {
	let trigger = "";

	function validateValue(value: number) {
		if (value < props.min) value = props.min;
		if (value > props.max) value = props.max;

		return value;
	}

	function getValueObject(val: string | number): ValueObject {
		const value = "string" === typeof val ? val : val.toString();

		if (!value) {
			return {
				number: "",
				unit: "",
			};
		}

		const valueUnit = value.replace(/\d+/g, "");
		const valueNumeric = valueUnit ? value.replace(valueUnit, "") : value;

		if (!valueNumeric) {
			return {
				number: "",
				unit: valueUnit,
			};
		}

		const floatValue = parseFloat(valueNumeric.trim());

		if (isNaN(floatValue)) {
			return {
				number: "",
				unit: valueUnit,
			};
		}

		const valueNumber = validateValue(floatValue);

		return {
			number: valueNumber,
			unit: valueUnit,
		};
	}

	function makeValueForInput(value: string | number) {
		const valueObject = getValueObject(value);
		return valueObject.number + valueObject.unit;
	}

	function makeValueForSlider(value: string | number) {
		return getValueObject(value).number;
	}

	props.control.updateComponentState = (val) => {
		if ("slider" === trigger) {
			setInputRefValue(makeValueForInput(val));
		} else if ("input" === trigger) {
			setSliderRefValue(makeValueForSlider(val));
		} else if ("reset" === trigger) {
			setSliderRefValue(val);
			setInputRefValue(val);
		}
	};

	function handleInputChange(e: ChangeEvent<HTMLInputElement>) {
		trigger = "input";
		props.customizerSetting.set(makeValueForInput(e.target.value));
	}

	const sliderRef = useRef<HTMLInputElement | null>(null);
	const inputRef = useRef<HTMLInputElement | null>(null);

	function handleSliderChange(e: ChangeEvent<HTMLInputElement>) {
		trigger = "slider";

		let value = parseFloat(e.target.value);
		value = validateValue(value);

		if (!inputRef || !inputRef.current) return;

		const inputValueObj = getValueObject(inputRef.current.value); // We're going to use the unit.
		const valueForInput = value + inputValueObj.unit;

		props.customizerSetting.set(valueForInput);
	}

	function makeStringValue(value: string | number) {
		return "string" === typeof value ? value : value.toString();
	}

	function setInputRefValue(value: string | number) {
		if (!inputRef || !inputRef.current) return;
		inputRef.current.value = makeStringValue(value);
	}

	function setSliderRefValue(value: string | number) {
		if (!sliderRef || !sliderRef.current) return;
		sliderRef.current.value = makeStringValue(value);
	}

	function handleResetButtonClick(e: MouseEvent) {
		if ("" !== props.default && "undefined" !== typeof props.default) {
			setSliderRefValue(props.default);
			setInputRefValue(props.default);
		} else {
			if ("" !== props.value) {
				setSliderRefValue(props.value);
				setInputRefValue(props.value);
			} else {
				setSliderRefValue(props.min);
				setInputRefValue("");
			}
		}

		trigger = "reset";

		if (!sliderRef || !sliderRef.current) return;
		props.customizerSetting.set(sliderRef.current.value);
	}

	// Preparing for the template.
	const fieldId = `wpbf-control-input-${props.customizerSetting.id}`;
	const sliderValue = makeValueForSlider(props.value);
	const inputValue = makeValueForInput(props.value);

	return (
		<div className="wpbf-control-form" tabIndex={1}>
			{props.label || props.description ? (
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
			) : null}

			<div
				className="customize-control-notifications-container"
				ref={props.setNotificationContainer}
			></div>

			<button
				type="button"
				className="wpbf-control-reset"
				onClick={handleResetButtonClick}
			>
				<i className="dashicons dashicons-image-rotate"></i>
			</button>

			<div className="wpbf-control-cols">
				<div className="wpbf-control-left-col">
					<input
						ref={sliderRef}
						type="range"
						id={fieldId}
						defaultValue={sliderValue}
						min={props.min}
						max={props.max}
						step={props.step}
						className="wpbf-control-input-slider wpbf-pro-control-input-slider"
						onChange={handleSliderChange}
					/>
				</div>
				<div className="wpbf-control-right-col">
					<input
						ref={inputRef}
						type="text"
						defaultValue={inputValue}
						className="wpbf-control-input"
						onChange={handleInputChange}
					/>
				</div>
			</div>
		</div>
	);
}
