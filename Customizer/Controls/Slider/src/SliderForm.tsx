import React, {ChangeEvent, useRef} from "react";

export default function SliderForm(props: {
	default?: any;
	value?: any;
	label?: any;
	description?: any;
	setNotificationContainer?: any;
	control?: any;
	customizerSetting?: any;
	choices?: any;
}) {
	const {control, customizerSetting, choices} = props;

	let trigger = "";

	const sliderRef: React.MutableRefObject<HTMLInputElement | null> = useRef(null);
	const valueRef: React.MutableRefObject<HTMLDivElement | null> = useRef(null);

	control.updateComponentState = (val: string) => {
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

	function handleChange(e: ChangeEvent) {
		const target = e.target as HTMLInputElement;
		trigger = "range" === target.type ? "slider" : "input";

		let value = target.value;

		if (value < choices.min) value = choices.min;

		if (value > choices.max) value = choices.max;

		if ("input" === trigger) target.value = value;
		customizerSetting.set(value);
	}

	function handleReset(_e: React.MouseEvent) {
		if ("" !== props.default && "undefined" !== typeof props.default) {
			if (sliderRef && sliderRef.current) {
				sliderRef.current.value = props.default;
			}

			if (valueRef && valueRef.current) {
				valueRef.current.textContent = props.default;
			}
		} else {
			if ("" !== props.value) {
				if (sliderRef && sliderRef.current) {
					sliderRef.current.value = props.value;
				}

				if (valueRef && valueRef.current) {
					valueRef.current.textContent = props.value;
				}
			} else {
				if (sliderRef && sliderRef.current) {
					sliderRef.current.value = choices.min;
				}

				if (valueRef && valueRef.current) {
					valueRef.current.textContent = "";
				}
			}
		}

		trigger = "reset";

		if (sliderRef && sliderRef.current) {
			customizerSetting.set(sliderRef.current.value);
		}
	}

	// Preparing for the template.
	const fieldId = `wpbf-control-input-${customizerSetting.id}`;
	const value = "" !== props.value ? props.value : 0;

	return (
		<div className="wpbf-control-form" tabIndex={1}>
			<label className="wpbf-control-label" htmlFor={fieldId}>
				<span className="customize-control-title">{props.label}</span>
				<span
					className="customize-control-description description"
					dangerouslySetInnerHTML={{__html: props.description}}
				/>
			</label>

			<div
				className="customize-control-notifications-container"
				ref={props.setNotificationContainer}
			></div>

			<button
				type="button"
				className="wpbf-control-reset"
				onClick={handleReset}
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
						min={choices.min}
						max={choices.max}
						step={choices.step}
						className="wpbf-control-slider"
						onChange={handleChange}
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
};
