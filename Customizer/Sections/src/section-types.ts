import _ from "lodash";
import {
	WpbfCustomize,
	WpbfCustomizeSection,
} from "../../Controls/Base/src/interface";

export function setupSectionTypes(customizer: WpbfCustomize) {
	customizer.section.each(function (section: WpbfCustomizeSection) {
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
	customizer.sectionConstructor["wpbf-link"] = customizer.Section.extend({
		attachEvents: function () {},
		isContextuallyActive: function () {
			return true;
		},
	});

	setupSectionsReflow(customizer);
}

/**
 * @see https://wordpress.stackexchange.com/a/256103/17078
 */
function setupSectionsReflow(customizer: WpbfCustomize) {
	customizer.bind("pane-contents-reflowed", function () {
		const nestedSections: WpbfCustomizeSection[] = [];

		// Reflow Sections.
		customizer.section.each(function (section: WpbfCustomizeSection) {
			if ("wpbf-nested" !== section.params.type || !section.params.parentId) {
				return;
			}

			nestedSections.push(section);
		});

		nestedSections.sort(customizer.utils.prioritySort).reverse();

		jQuery.each(nestedSections, function (i, nestedSection) {
			if (!nestedSection.headContainer) return;

			const parentContainer = jQuery(
				"#sub-accordion-section-" + nestedSection.params.parentId,
			);

			parentContainer
				.children(".section-meta")
				.after(nestedSection.headContainer);
		});
	});

	// Extend Section.
	const _sectionEmbed = customizer.Section.prototype.embed;

	const _sectionIsContextuallyActive =
		customizer.Section.prototype.isContextuallyActive;

	const _sectionAttachEvents = customizer.Section.prototype.attachEvents;

	customizer.Section = customizer.Section.extend({
		attachEvents: function (this: WpbfCustomizeSection) {
			const section = this;

			if ("wpbf-nested" !== section.params.type || !section.params.parentId) {
				_sectionAttachEvents.call(section);
				return;
			}

			_sectionAttachEvents.call(section);

			section.expanded.bind(function (expanded: boolean) {
				if (!section.params.parentId) return;
				const parent = customizer.section(section.params.parentId);

				if (expanded) {
					parent.contentContainer?.addClass("current-section-parent");
				} else {
					parent.contentContainer?.removeClass("current-section-parent");
				}
			});

			section.container
				?.find(".customize-section-back")
				.off("click keydown")
				.on("click keydown", function (event) {
					if (customizer.utils.isKeydownButNotEnterEvent(event)) {
						return;
					}

					// Keep this AFTER the key filter above
					event.preventDefault();

					if (!section.params.parentId) return;

					if (section.expanded()) {
						// wp.customize.section(section.params.section).expand();
						customizer.section(section.params.parentId).expand(section.params);
					}
				});
		},

		embed: function (this: WpbfCustomizeSection) {
			const section = this;

			if ("wpbf-nested" !== section.params.type || !section.params.parentId) {
				_sectionEmbed.call(section);
				return;
			}

			_sectionEmbed.call(section);

			const parentContainer = jQuery(
				"#sub-accordion-section-" + section.params.parentId,
			);

			if (section.headContainer) {
				parentContainer.append(section.headContainer);
			}
		},

		isContextuallyActive: function (this: WpbfCustomizeSection) {
			const section = this;

			if ("wpbf-nested" !== section.params.type) {
				return _sectionIsContextuallyActive.call(this);
			}

			let activeCount = 0;
			const children = section._children("section", "control");

			customizer.section.each(function (iteratedSection: WpbfCustomizeSection) {
				if (!iteratedSection.params.parentId) return;

				if (iteratedSection.params.parentId !== section.id) {
					return;
				}

				children.push(iteratedSection);
			});

			children.sort(customizer.utils.prioritySort);

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
