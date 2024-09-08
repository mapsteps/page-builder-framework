import "./toggle-control.scss";
import { WpbfCustomizeCheckboxControl } from "./interface";

(() => {
	if (!window.wp.customize) return;

	window.wp.customize.controlConstructor["wpbf-checkbox"] =
		window.wp.customize.wpbfDynamicControl.extend<WpbfCustomizeCheckboxControl>(
			{
				initWpbfControl: function (
					this: WpbfCustomizeCheckboxControl,
					ctrl?: WpbfCustomizeCheckboxControl,
				) {
					const control = ctrl || this;

					control.container.on("change", "input", function () {
						control.setting?.set(jQuery(this).is(":checked"));
					});
				},
			},
		);

	window.wp.customize.controlConstructor["wpbf-toggle"] =
		window.wp.customize.wpbfDynamicControl.extend<WpbfCustomizeCheckboxControl>(
			{
				initWpbfControl: function (
					this: WpbfCustomizeCheckboxControl,
					ctrl?: WpbfCustomizeCheckboxControl,
				) {
					const control = ctrl || this;

					control.container.on("change", "input", function () {
						control.setting?.set(jQuery(this).is(":checked"));
					});
				},
			},
		);
})();
