import React from "react";
import ControlLabel from "./ControlLabel";

export default function ControlHeader(props: {
	label: string;
	description: string;
	labelStyle?: string;
	setNotificationContainer?: any;
}) {
	return (
		<>
			<ControlLabel
				label={props.label}
				description={props.description}
				labelStyle={props.labelStyle}
			/>

			<div
				className="customize-control-notifications-container"
				ref={props.setNotificationContainer}
			/>
		</>
	);
}
