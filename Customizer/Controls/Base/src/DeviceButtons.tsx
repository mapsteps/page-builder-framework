import React from "react";

export default function DeviceButtons(props: { devices: string[] }) {
	return (
		<ul className="wpbf-responsive-options">
			{props.devices.map((device, index) => {
				const deviceClassName = `dashicons dashicons-${device === "mobile" ? "smartphone" : device}`;

				return (
					<li className={device}>
						<button
							type="button"
							className={`preview-${device} ${0 === index ? "active" : ""}`}
							data-device={device}
						>
							<i className={deviceClassName}></i>
						</button>
					</li>
				);
			})}
		</ul>
	);
}
