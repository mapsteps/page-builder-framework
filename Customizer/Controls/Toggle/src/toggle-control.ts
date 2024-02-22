import "./toggle-control.scss";
import { WpbfCustomize, WpbfCustomizeControl } from "../../Base/src/interfaces";

declare var wp: {
  customize: WpbfCustomize;
};

let wpbfCheckboxScript = {
  initWpbfControl: function (control: WpbfCustomizeControl) {
    control.container.on("change", "input", function () {
      control.setting.set(jQuery(this).is(":checked"));
    });
  },
};

wp.customize.controlConstructor["wpbf-checkbox"] =
  wp.customize.kirkiDynamicControl.extend(wpbfCheckboxScript);

wp.customize.controlConstructor["wpbf-toggle"] =
  wp.customize.kirkiDynamicControl.extend(wpbfCheckboxScript);
