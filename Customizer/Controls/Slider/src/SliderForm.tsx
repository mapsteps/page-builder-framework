import React, { ChangeEvent, MouseEvent, useRef } from "react";
import { WpbfCustomizeSetting } from "../../Base/src/interface";
import { WpbfCustomizeSliderControl } from "./interface";

export default function SliderForm(props: {
	control: WpbfCustomizeSliderControl;
	customizerSetting?: WpbfCustomizeSetting<string | number>;
	setNotificationContainer?: any;
	label?: string;
	description?: string;
	default?: string | number;
	value?: string | number;
	min: number;
	max: number;
	step: number;
}) {
	let trigger = "";

	const sliderRef: React.MutableRefObject<HTMLInputElement | null> =
		useRef(null);
	const valueRef: React.MutableRefObject<HTMLDivElement | null> = useRef(null);

	props.control.updateComponentState = (value) => {
		const val = String(value);

		if ("slider" === trigger) {
			if (valueRef && valueRef.current) {
				valueRef.current.textContent = val;
			}
		} else if ("input" === trigger) {
			if (sliderRef && sliderRef.current) {
				sliderRef.current.value = val;
			}
		} else if ("reset" === trigger) {
			if (valueRef && valueRef.current) {
				valueRef.current.textContent = val;
			}

			if (sliderRef && sliderRef.current) {
				sliderRef.current.value = val;
			}
		}
	};

	function parseValue(value: string | number | undefined) {
		const safeValue = "undefined" === typeof value ? 0 : value;
		const numericValue =
			typeof safeValue === "string" ? parseFloat(safeValue) : safeValue;

		if (isNaN(numericValue)) {
			return props.min;
		}

		const parsedValue = numericValue < props.min ? props.min : numericValue;

		return parsedValue > props.max ? props.max : parsedValue;
	}

	function handleInputChange(e: ChangeEvent<HTMLInputElement>) {
		const target = e.target;
		trigger = "range" === target.type ? "slider" : "input";

		const value = parseValue(target.value);

		if ("input" === trigger) target.value = value.toString();
		props.customizerSetting?.set(value);
	}

	function handleResetButtonClick(_e: MouseEvent) {
		const defaultExists =
			"undefined" !== typeof props.default && "" !== props.default;

		if (defaultExists) {
			const defaultValue = parseValue(props.default);

			if (sliderRef && sliderRef.current) {
				sliderRef.current.value = defaultValue.toString();
			}

			if (valueRef && valueRef.current) {
				valueRef.current.textContent = defaultValue.toString();
			}
		} else {
			const valueExists =
				"undefined" !== typeof props.value && "" !== props.value;

			if (valueExists) {
				const value = parseValue(props.value);

				if (sliderRef && sliderRef.current) {
					sliderRef.current.value = value.toString();
				}

				if (valueRef && valueRef.current) {
					valueRef.current.textContent = value.toString();
				}
			} else {
				if (sliderRef && sliderRef.current) {
					sliderRef.current.value = props.min.toString();
				}

				if (valueRef && valueRef.current) {
					valueRef.current.textContent = "";
				}
			}
		}

		trigger = "reset";
		const renderedValue = parseValue(sliderRef.current?.value);

		if (sliderRef && sliderRef.current) {
			props.customizerSetting?.set(renderedValue);
		}
	}

	// Preparing for the template.
	const fieldId = `wpbf-control-input-${props.customizerSetting?.id}`;
	const value = parseValue(props.value);

	return (
		<div className="wpbf-control-form" tabIndex={1}>
			<label className="wpbf-control-label" htmlFor={fieldId}>
				<span className="customize-control-title">{props.label}</span>
				<span
					className="customize-control-description description"
					dangerouslySetInnerHTML={{ __html: props.description ?? "" }}
				/>
			</label>

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
						defaultValue={value}
						min={props.min}
						max={props.max}
						step={props.step}
						className="wpbf-control-slider"
						onChange={handleInputChange}
					/>
				</div>
				<div className="wpbf-control-right-col">
					<div className="wpbf-control-value" ref={valueRef}>
						{value}
					</div>
				</div>
			</div>
		</div>
	);
}
