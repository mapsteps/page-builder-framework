export default function ControlLabel(props: {
	label: string;
	description: string;
	setNotificationContainer?: any;
}) {
	const { label, description, setNotificationContainer } = props;

	return (
		<>
			{label || description ? (
				<label className="wpbf-control-label">
					{label && (
						<span
							className="customize-control-title"
							dangerouslySetInnerHTML={{ __html: label }}
						/>
					)}

					{description && (
						<span
							className="description customize-control-description"
							dangerouslySetInnerHTML={{ __html: description }}
						></span>
					)}
				</label>
			) : (
				""
			)}

			<div
				className="customize-control-notifications-container"
				ref={setNotificationContainer}
			/>
		</>
	);
}
