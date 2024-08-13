import React from "react";
import { WpbfCustomizeBuilderControl } from "./builder-interface";
import { WpbfCustomizeSetting } from "../../Base/src/interface";

export function HeaderBuilderForm(props: {
	control: WpbfCustomizeBuilderControl;
	customizerSetting?: WpbfCustomizeSetting<Record<string, any>>;
	setNotificationContainer: any;
	label: string;
	description: string;
	default: Record<string, any>;
	value: Record<string, any>;
}) {
	// This function will be called when this control's customizer value is changed.
	props.control.updateComponentState = (value: any) => {
		console.log("updateComponentState", value);
	};

	return (
		<>
			<header className="wpbf-control-header">
				{props.label && (
					<label
						className="customize-control-title"
						htmlFor={"_customize-input-" + props.control.id}
					>
						<span className="customize-control-title">{props.label}</span>
					</label>
				)}

				{props.description && (
					<div className="customize-control-description">
						{props.description}
					</div>
				)}
			</header>

			<div
				className="customize-control-notifications-container"
				ref={props.setNotificationContainer}
			></div>

			<div className="wpbf-control-form">Builder to be developed.</div>
		</>
	);
}
