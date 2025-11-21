import {
	listenToCustomizerValueChange,
	writeCSS,
	maybeAppendSuffix,
	toStringColor,
} from "../customizer-util";
import { WpbfColorControlValue } from "../../../../Customizer/Controls/Color/src/color-interface";

export default function eddSetup() {
	/* Easy Digital Downloads - Menu Item */

	// Desktop color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"edd_menu_item_desktop_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".wpbf-menu .wpbf-edd-menu-item .wpbf-edd-menu-item-count",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Mobile color.
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"edd_menu_item_mobile_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector:
					".wpbf-mobile-nav-wrapper .wpbf-edd-menu-item .wpbf-edd-menu-item-count",
				props: { "background-color": toStringColor(value) },
			});
		},
	);

	// Button border radius.
	listenToCustomizerValueChange<string | number>(
		"button_border_radius",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: ".edd-submit",
				props: { "border-radius": maybeAppendSuffix(value) },
			});
		},
	);
}
