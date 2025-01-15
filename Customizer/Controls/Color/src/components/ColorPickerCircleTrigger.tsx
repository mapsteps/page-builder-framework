import React from "react";
import { colorBgImgData } from "../utils/misc";

export default function ColorPickerCirleTrigger(props: {
	color: string;
	isPopupOpen: boolean;
	tooltip?: JSX.Element | string;
	resetRef?: React.MutableRefObject<HTMLButtonElement | null>;
	onResetButtonClick?: () => void;
	onToggleButtonClick?: () => void;
}) {
	const {
		isPopupOpen,
		tooltip,
		resetRef,
		onResetButtonClick,
		onToggleButtonClick,
	} = props;

	const triggerButtonBgImage = `url("${colorBgImgData}")`;

	function hasResetButton() {
		return resetRef && onResetButtonClick;
	}

	return (
		<>
			{hasResetButton() && (
				<button
					type="button"
					ref={resetRef}
					className={`wpbf-control-reset${isPopupOpen ? " is-shown" : ""}`}
					onClick={onResetButtonClick}
				>
					<i className="dashicons dashicons-image-rotate"></i>
				</button>
			)}

			<div className="wpbf-trigger-circle-wrapper">
				{tooltip && <div className="wpbf-label-tooltip">{tooltip}</div>}

				<button
					type="button"
					className="wpbf-trigger-circle"
					onClick={onToggleButtonClick}
					style={{
						backgroundImage: triggerButtonBgImage,
					}}
				>
					<div
						className="wpbf-color-preview"
						style={{
							backgroundColor: props.color ? props.color : "transparent",
						}}
					></div>
				</button>
			</div>
		</>
	);
}
