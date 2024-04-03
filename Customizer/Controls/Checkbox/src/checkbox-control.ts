import "./toggle-control.scss";
import { WpbfCustomize } from "../../Base/src/interface";
import { WpbfCustomizeCheckboxControl } from "./interface";

declare var wp: {
	customize: WpbfCustomize;
};

wp.customize.controlConstructor["wpbf-checkbox"] =
	wp.customize.wpbfDynamicControl.extend<WpbfCustomizeCheckboxControl>({
		initWpbfControl: function (
			this: WpbfCustomizeCheckboxControl,
			ctrl?: WpbfCustomizeCheckboxControl,
		) {
			const control = ctrl || this;

			control.container.on("change", "input", function () {
				control.setting?.set(jQuery(this).is(":checked"));
			});
		},
	});

wp.customize.controlConstructor["wpbf-toggle"] =
	wp.customize.wpbfDynamicControl.extend<WpbfCustomizeCheckboxControl>({
		initWpbfControl: function (
			this: WpbfCustomizeCheckboxControl,
			ctrl?: WpbfCustomizeCheckboxControl,
		) {
			const control = ctrl || this;

			control.container.on("change", "input", function () {
				control.setting?.set(jQuery(this).is(":checked"));
			});
		},
	});
