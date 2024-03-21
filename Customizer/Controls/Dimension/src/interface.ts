import { WpbfCustomizeControl } from "../../Base/src/interface";

export interface WpbfCustomizeDimensionControl extends WpbfCustomizeControl {
	wpbfNotifications: VoidFunction;
	allowUnitless: boolean;
	validateCssValue: (value: string | number) => boolean;
}
