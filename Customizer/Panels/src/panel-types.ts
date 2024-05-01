import { WpbfCustomizePanel } from "../../Controls/Base/src/interface";
import _ from "lodash";

declare var wp: {
	customize: WpbfCustomize;
};

/**
 * Setting up customizer panels.
 *
 * @see https://wordpress.stackexchange.com/a/256103/17078
 */
function setupPanels() {
	wp.customize.bind("pane-contents-reflowed", function () {
		const nestedPanels: WpbfCustomizePanel[] = [];

		// Reflow Panels.
		wp.customize.panel.each(function (panel: WpbfCustomizePanel) {
			if ("wpbf-nested" !== panel.params.type || !panel.params.parentId) {
				return;
			}

			nestedPanels.push(panel);
		});

		nestedPanels.sort(wp.customize.utils.prioritySort).reverse();

		jQuery.each(nestedPanels, function (i, nestedPanel) {
			const parentContainer = jQuery(
				"#sub-accordion-panel-" + nestedPanel.params.parentId,
			);

			parentContainer.children(".panel-meta").after(nestedPanel.headContainer);
		});
	});

	// Extend Panel.
	const _panelEmbed = wp.customize.Panel.prototype.embed;

	const _panelIsContextuallyActive =
		wp.customize.Panel.prototype.isContextuallyActive;

	const _panelAttachEvents = wp.customize.Panel.prototype.attachEvents;

	wp.customize.Panel = wp.customize.Panel.extend({
		attachEvents: function (this: WpbfCustomizePanel) {
			const panel = this;

			if ("wpbf-nested" !== panel.params.type || !panel.params.parentId) {
				_panelAttachEvents.call(panel);
				return;
			}

			_panelAttachEvents.call(panel);

			panel.expanded.bind(function (expanded) {
				if (!panel.params.parentId) return;

				if (expanded) {
					wp.customize
						.panel(panel.params.parentId)
						.contentContainer?.addClass("current-panel-parent");
				} else {
					wp.customize
						.panel(panel.params.parentId)
						.contentContainer?.removeClass("current-panel-parent");
				}
			});

			panel.container
				?.find(".customize-panel-back")
				.off("click keydown")
				.on("click keydown", function (event) {
					if (wp.customize.utils.isKeydownButNotEnterEvent(event)) {
						return;
					}

					// Keep this AFTER the key filter above
					event.preventDefault();

					if (!panel.params.parentId) return;

					if (panel.expanded()) {
						wp.customize.panel(panel.params.parentId).expand(panel.params);
					}
				});
		},

		embed: function (this: WpbfCustomizePanel) {
			const panel = this;

			if ("wpbf-nested" !== panel.params.type || !panel.params.parentId) {
				_panelEmbed.call(panel);
				return;
			}

			_panelEmbed.call(panel);
			const parentContainer = jQuery(
				"#sub-accordion-panel-" + panel.params.parentId,
			);
			parentContainer.append(panel.headContainer);
		},

		isContextuallyActive: function (this: WpbfCustomizePanel) {
			const panel = this;
			let activeCount = 0;

			if ("wpbf-nested" !== panel.params.type) {
				return _panelIsContextuallyActive.call(panel);
			}

			const children = panel._children("panel", "section");

			wp.customize.panel.each(function (child: WpbfCustomizePanel) {
				if (!child.params.parentId || child.params.parentId !== panel.id) {
					return;
				}

				children.push(child);
			});

			children.sort(wp.customize.utils.prioritySort);

			_(children).each(function (child) {
				if (child.active() && child.isContextuallyActive()) {
					activeCount += 1;
				}
			});

			return 0 !== activeCount;
		},
	});
}

setupPanels();
