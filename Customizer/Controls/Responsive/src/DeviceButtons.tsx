import { previewDevice } from "../../Base/src/react-base";

/**
 * The device buttons of a responsive control: the active one is the device the preview shows (usePreviewedDevice);
 * a click shows the preview on that device, which switches every responsive control along with it.
 *
 * @param props.devices The control's devices.
 * @param props.active The active device.
 * @param props.icons Dashicons class per device (default: desktop, tablet, smartphone).
 */
export default function DeviceButtons(props: {
	devices: string[];
	active: string;
	icons?: Record<string, string>;
}) {
	return (
		<div className="wpbf-device-buttons">
			{props.devices.map((device, index) => {
				const icon = props.icons
					? (props.icons[device] ?? "dashicons-marker")
					: `dashicons-${device === "mobile" ? "smartphone" : device}`;
				const isActive = device === props.active;
				const className = `wpbf-device-button wpbf-device-button-${device}${isActive ? " is-active" : ""}`;

				return (
					<button
						type="button"
						className={className}
						data-wpbf-device={device}
						key={index}
						onClick={() => previewDevice(device)}
					>
						<i className={`dashicons ${icon}`}></i>
					</button>
				);
			})}
		</div>
	);
}
