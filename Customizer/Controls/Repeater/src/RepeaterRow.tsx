import _ from "lodash";
import { WpbfCustomize } from "../../Base/src/interface";
import jQuery from "jquery";

declare var wp: {
	customize: WpbfCustomize;
};

export default function RepeaterRow(
	this: any,
	rowIndex: number,
	container: any,
	label: string,
	control: any,
) {
	const self = this;

	this.rowIndex = rowIndex;
	this.container = container;
	this.label = label;
	this.header = this.container.find(".repeater-row-header");

	this.header.on("click", function () {
		self.toggleMinimize();
	});

	this.container.on("click", ".repeater-row-remove", function () {
		self.remove();
	});

	this.header.on("mousedown", function () {
		self.container.trigger("row:start-dragging");
	});

	this.container.on(
		"keyup change",
		"input, select, textarea",
		function (e: any) {
			self.container.trigger("row:update", [
				self.rowIndex,
				jQuery(e.target).data("field"),
				e.target,
			]);
		},
	);

	this.setRowIndex = function (rowNum: number) {
		this.rowIndex = rowNum;
		this.container.attr("data-row", rowNum);
		this.container.data("row", rowNum);
		this.updateLabel();
	};

	this.toggleMinimize = function () {
		// Store the previous state.
		this.container.toggleClass("minimized");
		this.header
			.find(".dashicons")
			.toggleClass("dashicons-arrow-up")
			.toggleClass("dashicons-arrow-down");
	};

	this.remove = function () {
		this.container.slideUp(300, function (this: any) {
			jQuery(this).detach();
		});

		this.container.trigger("row:remove", [this.rowIndex]);
	};

	this.updateLabel = function () {
		if ("field" === this.label.type) {
			const rowLabelField = this.container.find(
				'.repeater-field [data-field="' + this.label.field + '"]',
			);

			if (_.isFunction(rowLabelField.val)) {
				let rowLabel = rowLabelField.val();

				if ("" !== rowLabel) {
					if (!_.isUndefined(control.params.fields[this.label.field])) {
						if (!_.isUndefined(control.params.fields[this.label.field].type)) {
							if ("select" === control.params.fields[this.label.field].type) {
								if (
									!_.isUndefined(
										control.params.fields[this.label.field].choices,
									) &&
									!_.isUndefined(
										control.params.fields[this.label.field].choices[
											rowLabelField.val()
										],
									)
								) {
									rowLabel =
										control.params.fields[this.label.field].choices[
											rowLabelField.val()
										];
								}
							} else if (
								"radio" === control.params.fields[this.label.field].type ||
								"radio-image" === control.params.fields[this.label.field].type
							) {
								const rowLabelSelector =
									control.selector +
									' [data-row="' +
									this.rowIndex +
									'"] .repeater-field [data-field="' +
									this.label.field +
									'"]:checked';

								rowLabel = jQuery(rowLabelSelector).val();
							}
						}
					}

					this.header.find(".repeater-row-label").text(rowLabel);
					return;
				}
			}
		}
		this.header
			.find(".repeater-row-label")
			.text(this.label.value + " " + (this.rowIndex + 1));
	};

	this.updateLabel();
}
