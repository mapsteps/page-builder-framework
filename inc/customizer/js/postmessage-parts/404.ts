import { listenToCustomizerValueChange } from "../customizer-util";

export default function fourZeroFourSetup($: JQueryStatic) {
	listenToCustomizerValueChange<string>(
		"404_headline",
		function (settingId, value) {
			$(".wpbf-404-content .entry-title").text(value);
		},
	);

	listenToCustomizerValueChange<string>(
		"404_text",
		function (settingId, value) {
			$(".wpbf-404-content p").text(value);
		},
	);
}
