import "./margin-padding-control.scss";
import MarginPaddingControl from "./MarginPaddingControl";

if (window.wp.customize) {
	window.wp.customize.controlConstructor["wpbf-margin-padding"] =
		MarginPaddingControl(window.wp.customize);

	window.wp.customize.controlConstructor["wpbf-responsive-margin-padding"] =
		MarginPaddingControl(window.wp.customize);
}
