import React from "react";

export type ColorPickerSwatchesProps = {
	colors: Array<string | { color: string }>;
	onClick: (color: string) => void;
};

export default function ColorPickerSwatches(
	props: ColorPickerSwatchesProps
): JSX.Element {
	const { colors, onClick } = props;

	return (
		<div className="kirki-color-swatches">
			{colors.map((clr, index) => {
				const color = typeof clr === "string" ? clr : clr.color;

				return (
					<button
						key={index.toString()}
						type="button"
						className="kirki-color-swatch"
						data-kirki-color={color}
						style={{ backgroundColor: color }}
						onClick={() => onClick(color)}
					></button>
				);
			})}
		</div>
	);
}
