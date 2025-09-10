import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/interface";

export type WpbfCustomizeImageSrc = {
	id: number;
	url: string;
	width: number;
	height: number;
};

export type WpbfCustomizeImageControlValue =
	| number
	| string
	| WpbfCustomizeImageSrc;

export interface WpbfCustomizeImageControlParams
	extends WpbfCustomizeControlParams<WpbfCustomizeImageControlValue> {
	labels: Record<string, string>;
	saveAs: string;
	valueSrc: WpbfCustomizeImageSrc;
	defaultSrc: WpbfCustomizeImageSrc;
}

export interface WpbfCustomizeImageControl
	extends WpbfCustomizeControl<
		WpbfCustomizeImageControlValue,
		WpbfCustomizeImageControlParams
	> {}
