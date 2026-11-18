import { WpbfCustomizeControl, WpbfCustomizeControlParams } from "../../Base/src/interface";

export type WpbfCustomizeImageSrc = {
	id: number;
	url: string;
	width: number;
	height: number;
};

// The setting value, depending on `saveAs`: the image URL, its attachment id, or all of WpbfCustomizeImageSrc.
export type WpbfCustomizeImageControlValue = number | string | WpbfCustomizeImageSrc;

export interface WpbfCustomizeImageControlParams extends WpbfCustomizeControlParams<WpbfCustomizeImageControlValue> {
	labels: Record<string, string>;
	saveAs: "url" | "id" | "array";
	valueSrc: WpbfCustomizeImageSrc;
	defaultSrc: WpbfCustomizeImageSrc;
}

export interface WpbfCustomizeImageControl
	extends WpbfCustomizeControl<WpbfCustomizeImageControlValue, WpbfCustomizeImageControlParams> {}
