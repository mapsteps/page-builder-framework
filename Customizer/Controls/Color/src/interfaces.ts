import { HslColor, HsvColor, RgbColor } from "colord";
import { WpbfCustomizeControl } from "../../Base/src/interfaces";
import {
  WpbfCustomizeSelectOptionGroup,
  WpbfCustomizeSelectOptionObject,
} from "../../Select/src/interfaces";
import { Control_Params } from "wordpress__customize-browser/Control";

export interface WpbfCustomizeControlParams extends Control_Params {
  mode: string;
  labelStyle: string;
  formComponent: string;
  colorSwatches: string[];
}

export interface WpbfCustomizeColorControl extends WpbfCustomizeControl {
  params: WpbfCustomizeControlParams;
  formatOptions: () =>
    | string[]
    | WpbfCustomizeSelectOptionObject[]
    | WpbfCustomizeSelectOptionGroup[];
  getFormattedOptions: () => any[];
  getOptionProps: (value: any) => any[];
}

export type ColorMode =
  | "rgb"
  | "rgba"
  | "hsl"
  | "hsla"
  | "hsv"
  | "hsva"
  | "hex"
  | "";

export type RgbOrRgbaColor = RgbColor & { a?: number };

export type HslOrHslaColor = HslColor & { a?: number };

export type HsvOrHsvaColor = HsvColor & { a?: number };
