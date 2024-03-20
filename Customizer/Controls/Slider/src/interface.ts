import {
	WpbfCustomizeControl,
	WpbfCustomizeSetting,
} from "../../Base/src/interfaces";
import { DevicesValue } from "../../Responsive/src/interface";

export interface WpbfCustomizeInputSliderControl extends WpbfCustomizeControl {
	setting: WpbfCustomizeSetting<string | number>;
	updateComponentState?: (val: string | number) => void;
}

export interface WpbfCustomizeResponsiveInputSliderControl
	extends WpbfCustomizeControl {
	setting: WpbfCustomizeSetting<string | DevicesValue>;
	updateComponentState?: (val: string | DevicesValue) => void;
}
