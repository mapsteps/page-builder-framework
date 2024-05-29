export type NumberUnitPair = {
	// The `number` prop can be an empty string.
	number: number | "";
	unit: string;
};

export type DevicesValue = {
	[device: string]: number | string;
};
