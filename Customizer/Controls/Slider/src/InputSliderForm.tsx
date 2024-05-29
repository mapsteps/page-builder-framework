import React, { ChangeEvent, MouseEvent, useRef } from "react";
import { WpbfCustomizeSetting } from "../../Base/src/interface";
import {
	makeStringValue,
	makeValueForInput,
	makeValueForSlider,
} from "./slider-util";
import { WpbfCustomizeInputSliderControl } from "./interface";
import {
	limitNumber,
	makeLimitedNumberUnitPair,
} from "../../Generic/src/number-util";

export default function InputSliderForm(props: {
	control: WpbfCustomizeInputSliderControl;
	customizerSetting?: WpbfCustomizeSetting<string | number>;
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

	props.control.updateComponentState = (val) => {
		if ("slider" === trigger) {
			setInputRefValue(makeValueForInput(val, props.min, props.max));
		} else if ("input" === trigger) {
			setSliderRefValue(makeValueForSlider(val, props.min, props.max));
		} else if ("reset" === trigger) {
			setSliderRefValue(val);
			setInputRefValue(val);
		}
	};

	function handleInputChange(e: ChangeEvent<HTMLInputElement>) {
		trigger = "input";

		props.customizerSetting?.set(
			makeValueForInput(e.target.value, props.min, props.max),
		);
	}

	const sliderRef = useRef<HTMLInputElement | null>(null);
	const inputRef = useRef<HTMLInputElement | null>(null);

	function handleSliderChange(e: ChangeEvent<HTMLInputElement>) {
		trigger = "slider";

		const value = parseFloat(e.target.value);
		const limitedValue = limitNumber(value, props.min, props.max);

		if (!inputRef || !inputRef.current) return;

		// Since range field doesn't have unit, we're going to get the unit from the input field.
		const numberValuePair = makeLimitedNumberUnitPair(
			inputRef.current.value,
			props.min,
			props.max,
		);

		const valueForInput = String(limitedValue) + numberValuePair.unit;
		props.customizerSetting?.set(valueForInput);
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
		props.customizerSetting?.set(sliderRef.current.value);
	}

	// Preparing for the template.
	const fieldId = `wpbf-control-input-${props.customizerSetting?.id}`;
	const sliderValue = makeValueForSlider(props.value, props.min, props.max);
	const inputValue = makeValueForInput(props.value, props.min, props.max);

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
