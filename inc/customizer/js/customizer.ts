import { setupControlsMovement } from "../../../assets/js/utils/customizer-util";
import setupBuilderControl from "./parts/setup-builder-control";

window.wp.customize?.bind("ready", () => {
	setTimeout(() => {
		if (!window.wp.customize) return;
		setupCustomizer();
	}, 25);
});

/**
 * Setup customizer.
 */
function setupCustomizer() {
	init();

	function init() {
		setupLogoContainerWidth();
		setupBuilderControl();
		listenToHeaderBuilderToggle();
	}

	function setupLogoContainerWidth() {
		jQuery("#customize-control-menu_logo_container_width")
			.on("mousedown", function () {
				jQuery("iframe")
					.contents()
					.find(".wpbf-navigation .wpbf-1-4")
					.css("border-right", "3px solid #0085ba");
			})
			.on("mouseup", function () {
				jQuery("iframe")
					.contents()
					.find(".wpbf-navigation .wpbf-1-4")
					.css("border-right", "none");
			});

		jQuery("#customize-control-mobile_menu_logo_container_width")
			.on("mousedown", function () {
				jQuery("iframe")
					.contents()
					.find(".wpbf-navigation .wpbf-2-3")
					.css("border-right", "3px solid #0085ba");
			})
			.on("mouseup", function () {
				jQuery("iframe")
					.contents()
					.find(".wpbf-navigation .wpbf-2-3")
					.css("border-right", "none");
			});
	}

	function listenToHeaderBuilderToggle() {
		setupControlsMovement({
			dependency: {
				settingId: "wpbf_enable_header_builder",
				moveForwardWhenValueIs: true,
			},
			sections: [
				{
					from: "wpbf_pre_header_options",
					to: "wpbf_header_builder_row_1_section",
					controlsToMove: [
						{
							id: "pre_header_width",
							label: {
								from: undefined,
								to: "Container Width",
							},
							prio: {
								from: undefined,
								to: 10,
							},
						},
						{
							id: "pre_header_height",
							label: {
								from: undefined,
								to: "Vertical Padding",
							},
							prio: {
								from: undefined,
								to: 15,
							},
						},
						{
							id: "pre_header_bg_color",
							prio: {
								from: undefined,
								to: 200,
							},
						},
						{
							id: "pre_header_font_color",
							prio: {
								from: undefined,
								to: 205,
							},
						},
						{
							id: "pre_header_accent_colors",
							prio: {
								from: undefined,
								to: 210,
							},
						},
						{
							id: "pre_header_font_size",
							prio: {
								from: undefined,
								to: 220,
							},
						},
					],
				},
				{
					from: "wpbf_menu_options",
					to: "wpbf_header_builder_row_2_section",
					controlsToMove: [
						{
							id: "menu_width",
							label: {
								from: undefined,
								to: "Container Width",
							},
							prio: {
								from: undefined,
								to: 10,
							},
						},
						{
							id: "menu_height",
							label: {
								from: undefined,
								to: "Vertical Padding",
							},
							prio: {
								from: undefined,
								to: 15,
							},
						},
					],
				},
				{
					from: "wpbf_menu_options",
					to: "wpbf_header_builder_row_2_section",
					controlsToMove: [
						{
							id: "menu_bg_color",
							prio: {
								from: undefined,
								to: 200,
							},
						},
						{
							id: "menu_font_colors",
							prio: {
								from: undefined,
								to: 205,
							},
						},
						{
							id: "menu_font_size",
							prio: {
								from: undefined,
								to: 210,
							},
						},
					],
				},
			],
		});
	}
}
