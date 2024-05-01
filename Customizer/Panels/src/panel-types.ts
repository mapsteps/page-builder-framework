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
		const panels: WpbfCustomizePanel[] = [];

		// Reflow Panels.
		wp.customize.panel.each(function (panel: WpbfCustomizePanel) {
			if (
				"wpbf-nested" !== panel.params.type ||
				_.isUndefined(panel.params.id)
			) {
				return;
			}

			panels.push(panel);
		});

		panels.sort(wp.customize.utils.prioritySort).reverse();

		jQuery.each(panels, function (i, panel) {
			const parentContainer = jQuery("#sub-accordion-panel-" + panel.params.id);

			parentContainer.children(".panel-meta").after(panel.headContainer);
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

			if ("wpbf-nested" !== this.params.type || _.isUndefined(this.params.id)) {
				_panelAttachEvents.call(this);
				return;
			}

			_panelAttachEvents.call(this);

			panel.expanded.bind(function (expanded) {
				if (expanded) {
					wp.customize
						.panel(panel.params.id)
						.contentContainer?.addClass("current-panel-parent");
				} else {
					wp.customize
						.panel(panel.params.id)
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
					event.preventDefault(); // Keep this AFTER the key filter above

					if (panel.expanded()) {
						wp.customize.panel(panel.params.id).expand(panel.params);
					}
				});
		},

		embed: function (this: WpbfCustomizePanel) {
			const panel = this;

			if ("wpbf-nested" !== this.params.type || _.isUndefined(this.params.id)) {
				_panelEmbed.call(this);
				return;
			}

			_panelEmbed.call(this);
			const parentContainer = jQuery("#sub-accordion-panel-" + this.params.id);
			parentContainer.append(panel.headContainer);
		},

		isContextuallyActive: function (this: WpbfCustomizePanel) {
			const panel = this;
			let activeCount = 0;

			if ("wpbf-nested" !== this.params.type) {
				return _panelIsContextuallyActive.call(this);
			}

			const children = this._children("panel", "section");

			wp.customize.panel.each(function (child: WpbfCustomizePanel) {
				if (
					!child.params.parentId ||
					child.params.parentId !== panel.id
				) {
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
