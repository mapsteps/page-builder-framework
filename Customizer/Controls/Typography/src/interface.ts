export type GoogleFontEntity = {
	family: string;
	category: string;
	variants: string[];
};

export type GoogleFontsOrderEntity = {
	alpha: string[];
	popularity: string[];
	trending: string[];
};

export type GoogleFontsCollection = {
	items: GoogleFontEntity[];
	order: GoogleFontsOrderEntity;
};

export type ValueLabelPair = {
	value: string;
	label: string;
};

export type FontVariantsCollection = {
	standard: ValueLabelPair[];
	complete: ValueLabelPair[];
};

export type WpbfCustomizeTypographyControlValue = {
	"font-family"?: string;
	variant?: string;
	"font-size"?: string | number;
	"line-height"?: string;
	"letter-spacing"?: string;
	color?: string;
	"text-align"?: string;
	"text-transform"?: string;
};
