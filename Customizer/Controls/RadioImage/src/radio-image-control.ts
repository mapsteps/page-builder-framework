import "./radio-image-control.scss";
import { WpbfCustomize } from "../../Base/src/interfaces";

declare var wp: {
  customize: WpbfCustomize;
};

wp.customize.controlConstructor["wpbf-radio-image"] =
  wp.customize.wpbfDynamicControl.extend({});
