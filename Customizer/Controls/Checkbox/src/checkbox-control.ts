import "./toggle-control.scss";
import {
	WpbfCustomize,
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "../../Base/src/interface";

declare var wp: {
	customize: WpbfCustomize;
};

wp.customize.controlConstructor["wpbf-checkbox"] =
	wp.customize.wpbfDynamicControl.extend<
		WpbfCustomizeControl<boolean, WpbfCustomizeControlParams<boolean>>
	>({
		initWpbfControl: function (
			control: WpbfCustomizeControl<
				boolean,
				WpbfCustomizeControlParams<boolean>
			>,
		) {
			control = control || this;
			control.container.on("change", "input", function () {
				control.setting.set(jQuery(this).is(":checked"));
			});
		},
	});

wp.customize.controlConstructor["wpbf-toggle"] =
	wp.customize.wpbfDynamicControl.extend<
		WpbfCustomizeControl<boolean, WpbfCustomizeControlParams<boolean>>
	>({
		initWpbfControl: function (
			control: WpbfCustomizeControl<
				boolean,
				WpbfCustomizeControlParams<boolean>
			>,
		) {
			control = control || this;
			control.container.on("change", "input", function () {
				control.setting.set(jQuery(this).is(":checked"));
			});
		},
	});
