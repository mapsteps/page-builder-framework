import {
	listenToCustomizerValueChange,
	writeCSS,
	toStringColor,
} from "../customizer-util";
import { WpbfColorControlValue } from "../../../../Customizer/Controls/Color/src/color-interface";

export default function typographySetup() {
	listenToCustomizerValueChange<WpbfColorControlValue>(
		"page_font_color",
		function (settingId, value) {
			writeCSS(settingId, {
				selector: "body",
				props: { color: toStringColor(value) },
			});
		},
	);
}
