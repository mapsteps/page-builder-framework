import React from "react";

export default function DeviceButtons(props: { devices: string[] }) {
	return (
		<div className="wpbf-device-buttons">
			{props.devices.map((device, index) => {
				const deviceClassName = `dashicons dashicons-${device === "mobile" ? "smartphone" : device}`;

				return (
					<button
						type="button"
						className={`wpbf-device-button wpbf-device-button-${device} ${0 === index ? " is-active" : ""}`}
						data-wpbf-device={device}
						key={index}
					>
						<i className={deviceClassName}></i>
					</button>
				);
			})}
		</div>
	);
}
