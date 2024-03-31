import React from "react";
import Select, { components } from "react-select";
import { WpbfCustomize } from "../../Base/src/interface";
import { SelectControlProps } from "./interface";

declare var wp: {
	customize: WpbfCustomize;
};

function SelectMenu(props: any) {
	const { selectProps } = props;
	const optionSelectedLength = props.getValue().length || 0;

	return (
		<components.Menu {...props}>
			{optionSelectedLength < selectProps.maxSelections ? (
				props.children
			) : (
				<div style={{ padding: 15 }}>
					{selectProps.messages.maxLimitReached}
				</div>
			)}
		</components.Menu>
	);
}

export default function SelectForm(props: SelectControlProps) {
	/**
	 * Pass-on the value to the customizer object to save.
	 */
	const handleChangeComplete = (val: any | [], type: any) => {
		let newValue;

		if ("clear" === type) {
			newValue = "";
		} else {
			if (Array.isArray(val)) {
				newValue = val.map((item) => item.value);
			} else {
				newValue = val.value;
			}
		}

		if (!props.customizerSetting) return;
		wp.customize(props.customizerSetting.id).set(newValue);
	};

	/**
	 * Change the color-scheme using WordPress colors.
	 */
	const theme = (theme: any) => ({
		...theme,
		colors: {
			...theme.colors,
			primary: "#0073aa",
			primary75: "#33b3db",
			primary50: "#99d9ed",
			primary24: "#e5f5fa",
		},
	});

	const customStyles = {
		control: (base: any, state: any) => ({
			...base,
			minHeight: "30px",
		}),
		valueContainer: (base: any) => ({
			...base,
			padding: "0 6px",
		}),
		input: (base: any) => ({
			...base,
			margin: "0px",
		}),
	};

	/**
	 * Allow rendering HTML in select labels.
	 */
	const getLabel = (props: Record<any, any>) => {
		return <div dangerouslySetInnerHTML={{ __html: props.label }}></div>;
	};

	const inputId = props.inputId
		? props.inputId
		: `wpbf-react-select-input--${props.customizerSetting?.id}`;
	const label = props.label ? (
		<label
			className="customize-control-title"
			dangerouslySetInnerHTML={{ __html: props.label }}
			htmlFor={inputId}
		/>
	) : (
		""
	);
	const description = props.description ? (
		<span
			className="description customize-control-description"
			dangerouslySetInnerHTML={{ __html: props.description }}
		/>
	) : (
		""
	);

	return (
		<div>
			{label}
			{description}
			<div
				className="customize-control-notifications-container"
				ref={props.setNotificationContainer}
			></div>
			<Select
				{...props}
				inputId={inputId}
				className="wpbf-react-select-container"
				isMulti={props.isMulti}
				classNamePrefix="wpbf-react-select"
				// @see https://github.com/JedWatson/react-select/issues/888#issuecomment-209376601
				openMenuOnFocus={props.openMenuOnFocus}
				formatOptionLabel={getLabel}
				options={props.options}
				onChange={handleChangeComplete}
				value={props.value}
				isOptionDisabled={props.isOptionDisabled}
				components={{ IndicatorSeparator: () => null, Menu: SelectMenu }}
				theme={theme}
				styles={customStyles}
			/>
		</div>
	);
}
