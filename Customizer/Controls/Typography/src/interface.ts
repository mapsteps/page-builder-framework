export type FontProperties = [
	"font-family",
	"variant",
	"font-size",
	"line-height",
	"letter-spacing",
	"color",
	"text-alignment",
	"text-transform",
];

export type FontProperty =
	| "font-family"
	| "variant"
	| "font-size"
	| "line-height"
	| "letter-spacing"
	| "color"
	| "text-alignment"
	| "text-transform";

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
	items: Record<string, GoogleFontEntity>;
	order: GoogleFontsOrderEntity;
};

export type LabelValuePair = {
	label: string;
	value: string;
};

export type FontVariantsCollection = {
	standard: LabelValuePair[];
	complete: LabelValuePair[];
};

export type WpbfCustomizeTypographyControlValue = {
	"font-family"?: string;
	variant?: string;
	"font-style"?: string;
	"font-weight"?: string | number;
	"font-size"?: string | number;
	"line-height"?: string;
	"letter-spacing"?: string;
	color?: string;
	"text-align"?: string;
	"text-transform"?: string;
	random?: number|string;
};
