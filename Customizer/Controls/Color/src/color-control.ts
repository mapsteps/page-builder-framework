import "./color-control.scss";
import ColorControl from './ColorControl';
import {WpbfCustomize} from "../../Base/src/interfaces";

declare var wp: {
	customize: WpbfCustomize;
};

// Register control type with Customizer.
wp.customize.controlConstructor['wpbf-color'] = ColorControl;