import _ from "lodash";
import { WpbfCustomize } from "../../Base/src/interface";
import jQuery from "jquery";
import {
	WpbfCustomizeRepeaterControl,
	WpbfRepeaterRow,
} from "./repeater-interface";

declare var wp: {
	customize: WpbfCustomize;
};

export default class RepeaterRow implements WpbfRepeaterRow {
	rowIndex: number;
	container: JQuery<HTMLElement>;
	label: Record<string, string>;
	header: JQuery<HTMLElement>;
	control: WpbfCustomizeRepeaterControl;

	constructor(
		rowIndex: number,
		container: JQuery<HTMLElement>,
		label: Record<string, string>,
		control: WpbfCustomizeRepeaterControl,
	) {
		this.rowIndex = rowIndex;
		this.container = container;
		this.label = label;
		this.header = this.container.find(".repeater-row-header");
		this.control = control;

		this.header.on("click", () => this.toggleMinimize());

		this.container.on("click", ".repeater-row-remove", () => this.remove());

		this.header.on("mousedown", () =>
			this.container.trigger("row:start-dragging"),
		);

		this.container.on(
			"keyup change",
			"input, select, textarea",
			(e: JQuery.TriggeredEvent) =>
				this.container.trigger("row:update", [
					this.rowIndex,
					jQuery(e.target).data("field"),
					e.target,
				]),
		);

		this.setRowIndex(this.rowIndex);
	}

	setRowIndex = (rowNum: number): void => {
		this.rowIndex = rowNum;
		this.container.attr("data-row", rowNum);
		this.container.data("row", rowNum);
		this.updateLabel();
	};

	toggleMinimize = (): void => {
		this.container.toggleClass("minimized");
		this.header
			.find(".dashicons")
			.toggleClass("dashicons-arrow-up dashicons-arrow-down");
	};

	remove = (): void => {
		this.container.slideUp(300, () => {
			this.container.detach();
		});
		this.container.trigger("row:remove", [this.rowIndex]);
	};

	updateLabel = (): void => {
		if ("field" === this.label.type) {
			const rowLabelField = this.container[0].querySelector(
				`.repeater-field [data-field="${this.label.field}"]`,
			);

			if (
				rowLabelField &&
				rowLabelField instanceof HTMLInputElement &&
				typeof rowLabelField.value === "string"
			) {
				let rowLabel: string = rowLabelField.value;

				if (rowLabel !== "") {
					if (
						this.control.params.fields[this.label.field] &&
						this.control.params.fields[this.label.field].type
					) {
						if (
							this.control.params.fields[this.label.field].type === "select" &&
							this.control.params.fields[this.label.field].choices &&
							this.control.params.fields[this.label.field].choices[rowLabel]
						) {
							rowLabel =
								this.control.params.fields[this.label.field].choices[rowLabel];
						} else if (
							(this.control.params.fields[this.label.field].type === "radio" ||
								this.control.params.fields[this.label.field].type ===
									"radio-image") &&
							this.rowIndex >= 0
						) {
							const rowLabelRadioField = this.container.find(
								`${this.control.selector} [data-row="${this.rowIndex}"] .repeater-field [data-field="${this.label.field}"]:checked`,
							)[0] as HTMLInputElement;

							if (rowLabelRadioField) {
								rowLabel = rowLabelRadioField.value;
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
			.text(`${this.label.value} ${this.rowIndex + 1}`);
	};
}
