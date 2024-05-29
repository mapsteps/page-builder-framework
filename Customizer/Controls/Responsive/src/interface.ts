export type NumberUnitPair = {
	// The `number` prop can be an empty string.
	number: number | "";
	unit: string;
	hasTrailingDotBeforeUnit?: boolean;
};

export type DevicesValue = {
	[device: string]: number | string;
};
