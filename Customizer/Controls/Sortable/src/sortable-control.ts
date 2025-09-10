import "./sortable-control.scss";

import { WpbfCustomize } from "../../Base/src/interface";
import { WpbfCustomizeSortableControl } from "./interface";
import _ from "lodash";

declare var wp: {
	customize: WpbfCustomize;
};

wp.customize.controlConstructor["wpbf-sortable"] =
	wp.customize.Control.extend<WpbfCustomizeSortableControl>({
		ready: function (this: WpbfCustomizeSortableControl) {
			const control = this;

			// Init sortable.
			jQuery(control.container.find("ul.sortable").first())
				.sortable({
					// Update value when we stop sorting.
					update: function () {
						if (control.setting) {
							control.setting.set(control.getNewValues!());
						}
					},
				})
				.disableSelection()
				.find("li")
				.each(function () {
					// Enable/disable options when we click on the eye of Thundera.
					jQuery(this)
						.find("i.visibility")
						.on("click", function () {
							jQuery(this)
								.toggleClass("dashicons-visibility-faint")
								.parents("li:eq(0)")
								.toggleClass("invisible");
						});
				})
				.on("click", function () {
					// Update value on click.
					control.setting?.set(control.getNewValues!());
				});
		},

		getNewValues: function (this: WpbfCustomizeSortableControl) {
			const control = this;
			const items = control.container.find("li");
			const newVal: any[] = [];

			_.each(items, function (item) {
				if (!item.classList.contains("invisible")) {
					newVal.push(item.dataset.value);
				}
			});

			return newVal;
		},
	});
