import { WpbfSortableControl } from "./sortable-interface";
import _ from "lodash";

declare var wp: {
	customize: WpbfCustomize;
};

wp.customize.controlConstructor["wpbf-sortable"] =
	wp.customize.Control.extend<WpbfSortableControl>({
		ready: function (this: WpbfSortableControl) {
			const control = this;

			// Handle control removal - trigger destroy when control is removed.
			function handleOnRemoved(removedControl: WpbfSortableControl) {
				if (control === removedControl) {
					if (control.destroy) control.destroy();
					control.container?.remove();
					wp.customize.control.unbind("removed", handleOnRemoved);
				}
			}
			wp.customize.control.bind("removed", handleOnRemoved);

			// Initialize sortable.
			this.initSortable?.();
		},

		/**
		 * Initialize the sortable functionality.
		 * Extracted for reuse in reinitialize().
		 */
		initSortable: function (this: WpbfSortableControl): void {
			const control = this;

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

		/**
		 * Re-initialize the control after being destroyed.
		 */
		reinitialize: function (this: WpbfSortableControl): void {
			this.initSortable?.();
		},

		getNewValues: function (this: WpbfSortableControl) {
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

		/**
		 * Handle removal/de-registration of the control.
		 * Cleans up jQuery Sortable instance and event handlers.
		 *
		 * @returns {void}
		 */
		destroy: function (this: WpbfSortableControl): void {
			// Destroy jQuery Sortable on the sortable list.
			const $sortable = this.container?.find("ul.sortable");
			if ($sortable?.data("ui-sortable")) {
				$sortable.sortable("destroy");
			}

			// Unbind all container events.
			this.container?.off();
		},
	});
