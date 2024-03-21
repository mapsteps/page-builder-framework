import {
	WpbfCustomize,
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "./interface";
import _ from "lodash";

declare var wp: {
	customize: WpbfCustomize;
};

declare var wpbfCustomizerTooltips: {
	id: string;
	content: string;
}[];

export function setupTooltips() {
	wp.customize.bind("ready", wpbfSetupTooltips);
}

function wpbfSetupTooltips() {
	let sectionNames: string[] = [];

	wp.customize.control.each(function (
		control: WpbfCustomizeControl<any, WpbfCustomizeControlParams<any>>,
	) {
		if (!sectionNames.includes(control.section())) {
			sectionNames.push(control.section());
		}

		wp.customize.section(control.section(), function (section) {
			if (
				section.expanded() ||
				wp.customize.settings.autofocus.control === control.id
			) {
				wpbfInjectTooltip(control);
			} else {
				section.expanded.bind(function (expanded) {
					if (expanded) {
						wpbfInjectTooltip(control);
					}
				});
			}
		});
	});

	const tooltipStyleTag = document.createElement("style");
	const sidebarOverlay = document.querySelector(
		".wp-full-overlay-sidebar-content",
	);

	tooltipStyleTag.classList.add("wpbf-tooltip-inline-styles");
	document.head.appendChild(tooltipStyleTag);

	sectionNames.forEach(function (sectionName) {
		if (!sidebarOverlay) return;

		wp.customize.section(sectionName, function (section) {
			section.expanded.bind(function (expanded) {
				if (expanded) {
					if (
						section.contentContainer &&
						section.contentContainer[0].scrollHeight >
							sidebarOverlay.clientHeight
					) {
						tooltipStyleTag.innerHTML =
							".wpbf-tooltip-wrapper span.tooltip-content {min-width: 258px;}";
					} else {
						tooltipStyleTag.innerHTML = "";
					}
				}
			});
		});
	});
}

function wpbfInjectTooltip(
	control: WpbfCustomizeControl<any, WpbfCustomizeControlParams<any>>,
) {
	_.each(wpbfCustomizerTooltips, function (tooltip) {
		if (tooltip.id !== control.id) {
			return;
		}

		if (control.container.find(".tooltip-content").length) return;

		const target = document.querySelector(
			"#customize-control-" + tooltip.id + " .customize-control-title",
		);

		if (!target) return;
		target.classList.add("wpbf-tooltip-wrapper");

		// Build the tooltip trigger.
		const trigger = document.createElement("span");
		trigger.classList.add("tooltip-trigger");
		trigger.innerHTML = '<span class="dashicons dashicons-editor-help"></span>';

		// Build the tooltip content.
		const content = document.createElement("span");
		content.classList.add("tooltip-content");
		content.innerHTML = tooltip.content;

		// Append the trigger & content next to the control's title.
		target.appendChild(trigger);
		target.appendChild(content);
	});
}
