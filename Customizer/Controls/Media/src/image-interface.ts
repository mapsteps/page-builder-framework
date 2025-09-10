import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/base-interface";

export type WpbfCustomizeImageSrc = {
	id: number;
	url: string;
	width: number;
	height: number;
};

export type WpbfImageControlValue = number | string | WpbfCustomizeImageSrc;

export interface WpbfImageControlParams
	extends WpbfCustomizeControlParams<WpbfImageControlValue> {
	labels: Record<string, string>;
	saveAs: string;
	valueSrc: WpbfCustomizeImageSrc;
	defaultSrc: WpbfCustomizeImageSrc;
}

export interface WpbfImageControl
	extends WpbfCustomizeControl<WpbfImageControlValue, WpbfImageControlParams> {}
