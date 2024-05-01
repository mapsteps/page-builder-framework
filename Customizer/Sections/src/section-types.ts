import {
	WpbfCustomize,
	WpbfCustomizeSection,
} from "../../Controls/Base/src/interface";
import "./section-types.scss";
import _ from "lodash";

declare var wp: {
	customize: WpbfCustomize;
};

wp.customize.bind("ready", setupSections);

function setupSections() {
	wp.customize.section.each(function (section: WpbfCustomizeSection) {
		const panel = jQuery("#sub-accordion-section-" + section.id);
		const sectionItem = jQuery("#accordion-section-" + section.id);

		// Check if the section is expanded.
		if (sectionItem.hasClass("control-section-wpbf-expanded")) {
			// Move element.
			panel.appendTo(sectionItem);
		}
	});

	/**
	 * See https://github.com/justintadlock/trt-customizer-pro
	 */
	wp.customize.sectionConstructor["wpbf-link"] = wp.customize.Section.extend({
		attachEvents: function () {},
		isContextuallyActive: function () {
			return true;
		},
	});

	setupSectionsReflow();
}

/**
 * @see https://wordpress.stackexchange.com/a/256103/17078
 */
function setupSectionsReflow() {
	wp.customize.bind("pane-contents-reflowed", function () {
		const nestedSections: any[] = [];

		// Reflow Sections.
		wp.customize.section.each(function (section: WpbfCustomizeSection) {
			if (
				"wpbf-nested" !== section.params.type ||
				_.isUndefined(section.params.parentId)
			) {
				return;
			}

			nestedSections.push(section);
		});

		nestedSections.sort(wp.customize.utils.prioritySort).reverse();

		jQuery.each(nestedSections, function (i, nestedSection) {
			const parentContainer = jQuery(
				"#sub-accordion-section-" + nestedSection.params.section,
			);

			parentContainer
				.children(".section-meta")
				.after(nestedSection.headContainer);
		});
	});

	// Extend Section.
	const _sectionEmbed = wp.customize.Section.prototype.embed;

	const _sectionIsContextuallyActive =
		wp.customize.Section.prototype.isContextuallyActive;

	const _sectionAttachEvents = wp.customize.Section.prototype.attachEvents;

	wp.customize.Section = wp.customize.Section.extend({
		attachEvents: function (this: WpbfCustomizeSection) {
			const section = this;

			if ("wpbf-nested" !== section.params.type || !section.params.parentId) {
				_sectionAttachEvents.call(section);
				return;
			}

			_sectionAttachEvents.call(section);

			section.expanded.bind(function (expanded: boolean) {
				if (!section.params.parentId) return;
				const parent = wp.customize.section(section.params.parentId);

				if (expanded) {
					parent.contentContainer?.addClass("current-section-parent");
				} else {
					parent.contentContainer?.removeClass("current-section-parent");
				}
			});

			section.container
				?.find(".customize-section-back")
				.off("click keydown")
				.on("click keydown", function (event: any) {
					if (wp.customize.utils.isKeydownButNotEnterEvent(event)) {
						return;
					}

					// Keep this AFTER the key filter above
					event.preventDefault();

					if (!section.params.parentId) return;

					if (section.expanded()) {
						// wp.customize.section(section.params.section).expand();
						wp.customize
							.section(section.params.parentId)
							.expand(section.params);
					}
				});
		},

		embed: function (this: WpbfCustomizeSection) {
			const section = this;

			if (
				"wpbf-nested" !== this.params.type ||
				_.isUndefined(this.params.parentId)
			) {
				_sectionEmbed.call(section);
				return;
			}

			_sectionEmbed.call(section);

			const parentContainer = jQuery(
				"#sub-accordion-section-" + this.params.parentId,
			);

			if (section.headContainer) {
				parentContainer.append(section.headContainer);
			}
		},

		isContextuallyActive: function (this: WpbfCustomizeSection) {
			const section = this;

			if ("wpbf-nested" !== this.params.type) {
				return _sectionIsContextuallyActive.call(this);
			}

			let activeCount = 0;
			const children = this._children("section", "control");

			wp.customize.section.each(function (childSection: WpbfCustomizeSection) {
				if (!childSection.params.parentId) return;

				if (childSection.params.parentId !== section.id) {
					return;
				}

				children.push(childSection);
			});

			children.sort(wp.customize.utils.prioritySort);

			_(children).each(function (child) {
				if ("undefined" !== typeof child.isContextuallyActive) {
					if (child.active() && child.isContextuallyActive()) {
						activeCount += 1;
					}
				} else {
					if (child.active()) {
						activeCount += 1;
					}
				}
			});

			return 0 !== activeCount;
		},
	});
}
