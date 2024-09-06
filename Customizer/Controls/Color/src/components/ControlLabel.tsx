import React from "react";

export default function ControlLabel(props: {
	label: string;
	description: string;
	labelStyle?: string;
}) {
	if (!props.label && !props.description) {
		return <></>;
	}

	return (
		<label className="wpbf-control-label">
			{props.label ? (
				<span
					className="customize-control-title"
					dangerouslySetInnerHTML={{ __html: props.label }}
				/>
			) : (
				""
			)}

			{props.description ? (
				<span
					className="description customize-control-description"
					dangerouslySetInnerHTML={{ __html: props.description }}
				></span>
			) : (
				""
			)}
		</label>
	);
}
