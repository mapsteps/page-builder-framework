import {
	listenToCustomizerValueChange,
	writeCSS,
	parseTemplateTags,
	listenToBuilderResponsiveControl,
	listenToBuilderMulticolorControl,
} from "../customizer-util";

export default function headerBuilderButtonsSetup() {
	const headerBuilderButtonKeys = [
		"desktop_button_1",
		"desktop_button_2",
		"mobile_button_1",
		"mobile_button_2",
	];

	headerBuilderButtonKeys.forEach((buttonKey) => {
		const controlIdPrefix = `wpbf_header_builder_${buttonKey}`;

		listenToCustomizerValueChange<boolean>(
			controlIdPrefix + "_new_tab",
			function (settingId, value) {
				const link = document.querySelector(`.wpbf-button.${controlIdPrefix}`);
				if (!(link instanceof HTMLAnchorElement)) return;

				if (value) {
					link.target = "_blank";
				} else {
					link.removeAttribute("target");
				}
			},
		);

		listenToCustomizerValueChange<string>(
			controlIdPrefix + "_text",
			function (settingId, value) {
				const link = document.querySelector(`.wpbf-button.${controlIdPrefix}`);
				if (!(link instanceof HTMLAnchorElement)) return;
				link.innerHTML = parseTemplateTags(value);
			},
		);

		listenToCustomizerValueChange<string>(
			controlIdPrefix + "_url",
			function (settingId, value) {
				const link = document.querySelector(`.wpbf-button.${controlIdPrefix}`);
				if (!(link instanceof HTMLAnchorElement)) return;
				link.href = parseTemplateTags(value);
			},
		);

		listenToCustomizerValueChange<string[]>(
			controlIdPrefix + "_rel",
			function (settingId, value) {
				const link = document.querySelector(`.wpbf-button.${controlIdPrefix}`);
				if (!(link instanceof HTMLAnchorElement)) return;

				if (Array.isArray(value) && value.length) {
					link.rel = value.join(" ");
				} else {
					link.removeAttribute("rel");
				}
			},
		);

		listenToCustomizerValueChange<string | number>(
			controlIdPrefix + "_size",
			function (settingId, value) {
				const link = document.querySelector(`.wpbf-button.${controlIdPrefix}`);
				if (!(link instanceof HTMLAnchorElement)) return;

				link.classList.remove("wpbf-button-small");
				link.classList.remove("wpbf-button-large");

				if ("small" === value) {
					link.classList.add("wpbf-button-small");
				} else if ("large" === value) {
					link.classList.add("wpbf-button-large");
				}
			},
		);

		// Listen to the header builder's border radius control.
		listenToBuilderResponsiveControl({
			controlId: `${controlIdPrefix}_border_radius`,
			cssSelector: `.wpbf-button.${controlIdPrefix}`,
			cssProps: "border-radius",
			useValueSuffix: true,
		});

		// Listen to the header builder's border width control.
		listenToBuilderResponsiveControl({
			controlId: `${controlIdPrefix}_border_width`,
			cssSelector: `.wpbf-button.${controlIdPrefix}`,
			cssProps: "border-width",
			useValueSuffix: true,
		});

		// Listen to the header builder's border style control.
		listenToCustomizerValueChange<string>(
			`${controlIdPrefix}_border_style`,
			function (settingId, value) {
				writeCSS(settingId, {
					selector: `.wpbf-button.${controlIdPrefix}`,
					props: { "border-style": value },
				});
			},
		);

		// Listen to the header builder's border color control.
		listenToBuilderMulticolorControl({
			controlId: `${controlIdPrefix}_border_color`,
			cssSelector: `.wpbf-button.${controlIdPrefix}`,
			cssProps: "border-color",
		});

		// Listen to the header builder's background color control.
		listenToBuilderMulticolorControl({
			controlId: `${controlIdPrefix}_bg_color`,
			cssSelector: `.wpbf-button.${controlIdPrefix}`,
			cssProps: "background-color",
		});

		// Listen to the header builder's text color control.
		listenToBuilderMulticolorControl({
			controlId: `${controlIdPrefix}_text_color`,
			cssSelector: `.wpbf-button.${controlIdPrefix}`,
			cssProps: "color",
		});
	});
}
