import { moveCustomizerControls } from "../../../../assets/js/utils/customizer-util";

export function setupControlsMovement() {
	setupHeaderBuilderControlsMovement();
	setupFooterBuilderControlsMovement();
}

function setupHeaderBuilderControlsMovement() {
	moveCustomizerControls({
		dependency: {
			settingId: "wpbf_enable_header_builder",
			moveForwardWhenValueIs: true,
		},
		sections: [
			{
				from: "wpbf_pre_header_options",
				to: "wpbf_header_builder_desktop_row_1_section",
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
						maintainActiveState: false,
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
						maintainActiveState: false,
					},
					{
						id: "pre_header_bg_color",
						prio: {
							from: undefined,
							to: 200,
						},
						maintainActiveState: false,
					},
					{
						id: "pre_header_font_color",
						prio: {
							from: undefined,
							to: 205,
						},
						maintainActiveState: false,
					},
					{
						id: "pre_header_accent_colors",
						prio: {
							from: undefined,
							to: 210,
						},
						maintainActiveState: false,
					},
					{
						id: "pre_header_font_size",
						prio: {
							from: undefined,
							to: 220,
						},
						maintainActiveState: false,
					},
				],
			},
			{
				from: "wpbf_menu_options",
				to: "wpbf_header_builder_desktop_row_2_section",
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
				to: "wpbf_header_builder_desktop_menu_1_section",
				controlsToMove: [
					{
						id: "menu_padding",
						prio: {
							from: undefined,
							to: 10,
						},
					},
					{
						id: "menu_font_size",
						prio: {
							from: undefined,
							to: 12,
						},
					},
				],
			},
			{
				from: "wpbf_mobile_menu_options",
				to: "wpbf_header_builder_mobile_menu_trigger_section",
				controlsToMove: [
					// Button related controls first (Button Settings group)
					{
						id: "mobile_menu_hamburger_bg_color",
						prio: {
							from: undefined,
							to: 210,
						},
					},
					{
						id: "mobile_menu_hamburger_border_radius",
						prio: {
							from: undefined,
							to: 215,
						},
						label: {
							from: undefined,
							to: "Border Radius",
						},
					},
					// Icon related controls after (Icon Settings group)
					{
						id: "mobile_menu_hamburger_color",
						prio: {
							from: undefined,
							to: 300,
						},
						maintainActiveState: true,
					},
					{
						id: "mobile_menu_hamburger_size",
						prio: {
							from: undefined,
							to: 305,
						},
						maintainActiveState: true,
					},
				],
			},
			{
				from: "wpbf_mobile_menu_options",
				to: "wpbf_header_builder_mobile_offcanvas_section",
				controlsToMove: [
					{
						id: "mobile_menu_item_settings_headline",
						prio: {
							from: undefined,
							to: 5,
						},
					},
					{
						id: "mobile_menu_bg_color",
						prio: {
							from: undefined,
							to: 8,
						},
					},
					{
						id: "mobile_menu_bg_color_alt",
						prio: {
							from: undefined,
							to: 9,
						},
					},
					{
						id: "mobile_menu_font_colors",
						prio: {
							from: undefined,
							to: 10,
						},
					},
					{
						id: "mobile_menu_border_color",
						prio: {
							from: undefined,
							to: 11,
						},
					},
					{
						id: "mobile_menu_submenu_arrow_color",
						prio: {
							from: undefined,
							to: 12,
						},
					},
					{
						id: "mobile_menu_font_size",
						prio: {
							from: undefined,
							to: 13,
						},
					},
				],
			},
			{
				from: "wpbf_mobile_menu_options",
				to: "wpbf_header_builder_mobile_menu_1_section",
				controlsToMove: [
					{
						id: "mobile_menu_padding",
						prio: {
							from: undefined,
							to: 50,
						},
					},
				],
			},
		],
	});
}

function setupFooterBuilderControlsMovement() {
	moveCustomizerControls({
		dependency: {
			settingId: "wpbf_enable_footer_builder",
			moveForwardWhenValueIs: true,
		},
		sections: [
			{
				from: "wpbf_footer_options",
				to: "wpbf_footer_builder_desktop_row_2_section",
				controlsToMove: [
					{
						id: "footer_width",
						label: {
							from: undefined,
							to: "Container Width",
						},
						prio: {
							from: undefined,
							to: 10,
						},
						maintainActiveState: true,
					},
					{
						id: "footer_height",
						label: {
							from: undefined,
							to: "Vertical Padding",
						},
						prio: {
							from: undefined,
							to: 15,
						},
						maintainActiveState: true,
					},
					{
						id: "footer_bg_color",
						prio: {
							from: undefined,
							to: 200,
						},
						maintainActiveState: true,
					},
					{
						id: "footer_font_color",
						prio: {
							from: undefined,
							to: 205,
						},
						maintainActiveState: true,
					},
					{
						id: "footer_accent_color",
						prio: {
							from: undefined,
							to: 210,
						},
						maintainActiveState: true,
					},
					{
						id: "footer_accent_color_alt",
						prio: {
							from: undefined,
							to: 215,
						},
						maintainActiveState: true,
					},
					{
						id: "footer_font_size",
						prio: {
							from: undefined,
							to: 220,
						},
						maintainActiveState: true,
					},
				],
			},
		],
	});
}
