import React from "react";

export default function ColorPickerSwatches(props: {
	colors: Array<string | { color: string } | undefined>;
	onClick: (color: string) => void;
}) {
	const { colors, onClick } = props;

	return (
		<div className="wpbf-color-swatches">
			{colors.map((clr, index) => {
				const color =
					typeof clr === "string" ? clr : clr && clr.color ? clr.color : "";

				return (
					<button
						key={index.toString()}
						type="button"
						className="wpbf-color-swatch"
						data-wpbf-color={color}
						style={{ backgroundColor: color }}
						onClick={() => onClick(color)}
					></button>
				);
			})}
		</div>
	);
}
