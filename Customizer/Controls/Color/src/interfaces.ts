export type RgbColor = {
	r: number;
	g: number;
	b: number;
};

export type RgbaColor = RgbColor & {
	a: number;
};

export type HslColor = {
	h: number;
	s: number;
	l: number;
};

export type HslaColor = HslColor & {
	a: number;
};

export type HsvColor = {
	h: number;
	s: number;
	v: number;
};

export type HsvaColor = HsvColor & {
	a: number;
};

export type ColorObject =
	| RgbColor
	| RgbaColor
	| HslColor
	| HslaColor
	| HsvColor
	| HsvaColor;
