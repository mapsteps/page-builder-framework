import "./toggle-control.scss";
import { WpbfCustomize, WpbfCustomizeControl } from "../../Base/src/interfaces";

declare var wp: {
	customize: WpbfCustomize;
};

const wpbfCheckboxScript = {
	initWpbfControl: function (control: WpbfCustomizeControl) {
		control = control || this;
		control.container.on("change", "input", function () {
			control.setting.set(jQuery(this).is(":checked"));
		});
	},
};

wp.customize.controlConstructor["wpbf-checkbox"] =
	wp.customize.wpbfDynamicControl.extend(wpbfCheckboxScript);

wp.customize.controlConstructor["wpbf-toggle"] =
	wp.customize.wpbfDynamicControl.extend(wpbfCheckboxScript);
