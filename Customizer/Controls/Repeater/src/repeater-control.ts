import "./repeater-control.scss";

import { WpbfCustomize } from "../../Base/src/interface";
import {
	RepeaterImageSelectOptions,
	WpbfCustomizeRepeaterControl,
	WpbfRepeaterRow,
} from "./repeater-interface";
import RepeaterRow from "./repeater-row";
import _ from "lodash";

declare var wp: {
	customize: WpbfCustomize;
	media: any;
};

wp.customize.controlConstructor["wpbf-repeater"] =
	wp.customize.Control.extend<WpbfCustomizeRepeaterControl>({
		// When we're finished loading continue processing
		ready: function (this: WpbfCustomizeRepeaterControl): void {
			this.initWpbfControl?.();
		},

		rows: [],

		currentIndex: 0,

		repeaterFieldsContainer: undefined,

		settingField: undefined,

		repeaterTemplate: undefined,

		initWpbfControl: function (
			this: WpbfCustomizeRepeaterControl,
			ctrl?: WpbfCustomizeRepeaterControl,
		) {
			const control = ctrl || this;

			// The current value set in Control Class (set in Kirki_Customize_Repeater_Control::to_json() function)
			const settingValueFromParams = control.params.value;

			// The hidden field that keeps the data saved (though we never update it)
			control.settingField = control.container
				.find("[data-customize-setting-link]")
				.first();

			// Set the field value for the first time, we'll fill it up later
			control.setValue?.([], false);

			// The DIV that holds all the rows
			control.repeaterFieldsContainer = control.container
				.find(".repeater-fields")
				.first();

			// Set number of rows to 0
			control.currentIndex = 0;

			// Save the rows objects
			control.rows = [];

			// Default limit.
			let limit: number | boolean = false;

			if ("number" === typeof control.params.limit) {
				limit = 0 >= control.params.limit ? false : control.params.limit;
			}

			let theNewRow;

			control.container?.on("click", "button.repeater-add", (e) => {
				e.preventDefault();

				if (
					!limit ||
					("number" === typeof control.currentIndex &&
						control.currentIndex < limit)
				) {
					theNewRow = control.addRow?.();
					theNewRow?.toggleMinimize();
					control.initColorPicker?.();
					if (theNewRow) control.initSelect?.(theNewRow);
				} else {
					jQuery(control.selector + " .limit").addClass("highlight");
				}
			});

			control.container?.on("click", ".repeater-row-remove", function () {
				if ("number" === typeof control.currentIndex) {
					control.currentIndex--;
				}

				if (
					!limit ||
					("number" === typeof control.currentIndex &&
						control.currentIndex < limit)
				) {
					jQuery(control.selector + " .limit").removeClass("highlight");
				}
			});

			control.container?.on(
				"click keypress",
				".repeater-field-image .upload-button,.repeater-field-cropped_image .upload-button,.repeater-field-upload .upload-button",
				function (e: JQuery.TriggeredEvent) {
					e.preventDefault();
					control.$thisButton = jQuery(this);
					control.openFrame?.(e);
				},
			);

			control.container?.on(
				"click keypress",
				".repeater-field-image .remove-button,.repeater-field-cropped_image .remove-button",
				function (e: JQuery.TriggeredEvent) {
					e.preventDefault();
					control.$thisButton = jQuery(this);
					control.removeImage?.(e);
				},
			);

			control.container?.on(
				"click keypress",
				".repeater-field-upload .remove-button",
				function (e: JQuery.TriggeredEvent) {
					e.preventDefault();
					control.$thisButton = jQuery(this);
					control.removeFile?.(e);
				},
			);

			/**
			 * Function that loads the Mustache template
			 */
			control.repeaterTemplate = _.memoize(function () {
				/*
				 * Underscore's default ERB-style templates are incompatible with PHP
				 * when asp_tags is enabled, so WordPress uses Mustache-inspired templating syntax.
				 *
				 * @see trac ticket #22344.
				 */
				const options = {
					evaluate: /<#([\s\S]+?)#>/g,
					interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
					escape: /\{\{([^\}]+?)\}\}(?!\})/g,
					variable: "data",
				};

				return function (data: any) {
					const compiled = _.template(
						control.container
							.find(".customize-control-repeater-content")
							.first()
							.html(),
						options,
					);

					return compiled(data);
				};
			});

			/**
			 * When we load the control, the fields have not been filled up.
			 * This is the first time that we create all the rows.
			 */
			if (settingValueFromParams.length) {
				let i = 0;

				for (i = 0; i < settingValueFromParams.length; i++) {
					theNewRow = control.addRow?.(settingValueFromParams[i]);
					control.initColorPicker?.();

					if (theNewRow) {
						control.initSelect?.(theNewRow, settingValueFromParams[i]);
					}
				}
			}

			control.repeaterFieldsContainer?.sortable({
				handle: ".repeater-row-header",
				update: function () {
					control.sort?.();
				},
			});
		},

		/**
		 * Open the media modal.
		 *
		 * @param {JQuery.TriggeredEvent} event - The JS event.
		 * @returns {void}
		 */
		openFrame: function (event: JQuery.TriggeredEvent): void {
			if (wp.customize.utils.isKeydownButNotEnterEvent(event)) {
				return;
			}

			if (
				this.$thisButton
					?.closest(".repeater-field")
					.hasClass("repeater-field-cropped_image")
			) {
				this.initCropperFrame?.();
			} else {
				this.initFrame?.();
			}

			this.frame.open();
		},

		initFrame: function (): void {
			const libMediaType = this.getMimeType();

			this.frame = wp.media({
				states: [
					new wp.media.controller.Library({
						library: wp.media.query({ type: libMediaType }),
						multiple: false,
						date: false,
					}),
				],
			});

			// When a file is selected, run a callback.
			this.frame.on("select", this.onSelect, this);
		},

		/**
		 * Create a media modal select frame, and store it so the instance can be reused when needed.
		 * This is mostly a copy/paste of Core api.CroppedImageControl in /wp-admin/js/customize-control.js
		 */
		initCropperFrame: function (this: WpbfCustomizeRepeaterControl): void {
			// We get the field id from which this was called.
			const currentFieldId = this.$thisButton
				?.siblings("input.hidden-field")
				.attr("data-field");
			const attrs = ["width", "height", "flex_width", "flex_height"]; // A list of attributes to look for
			const libMediaType = this.getMimeType();

			// Make sure we got it
			if (_.isString(currentFieldId) && "" !== currentFieldId) {
				// Make fields is defined and only do the hack for cropped_image
				if (
					_.isObject(this.params.fields[currentFieldId]) &&
					"cropped_image" === this.params.fields[currentFieldId].type
				) {
					// Iterate over the list of attributes.
					for (const attr of attrs) {
						// If the attribute exists in the field
						if (undefined !== this.params.fields[currentFieldId][attr]) {
							// Set the attribute in the main object
							this.params[attr] = this.params.fields[currentFieldId][attr];
						}
					}
				}
			}

			this.frame = wp.media({
				button: {
					text: "Select and Crop",
					close: false,
				},
				states: [
					new wp.media.controller.Library({
						library: wp.media.query({ type: libMediaType }),
						multiple: false,
						date: false,
						suggestedWidth: this.params.width,
						suggestedHeight: this.params.height,
					}),
					new wp.media.controller.CustomizeImageCropper({
						imgSelectOptions: this.calculateImageSelectOptions,
						control: this,
					}),
				],
			});

			this.frame.on("select", this.onSelectForCrop, this);
			this.frame.on("cropped", this.onCropped, this);
			this.frame.on("skippedcrop", this.onSkippedCrop, this);
		},

		onSelect: function (): void {
			const attachment = this.frame.state().get("selection").first().toJSON();

			if (
				this.$thisButton
					?.closest(".repeater-field")
					.hasClass("repeater-field-upload")
			) {
				this.setFileInRepeaterField?.(attachment);
			} else {
				this.setImageInRepeaterField?.(attachment);
			}
		},

		/**
		 * After an image is selected in the media modal, switch to the cropper
		 * state if the image isn't the right size.
		 */

		onSelectForCrop: function (this: WpbfCustomizeRepeaterControl) {
			const attachment = this.frame.state().get("selection").first().toJSON();

			if (
				this.params.width === attachment.width &&
				this.params.height === attachment.height &&
				!this.params.flex_width &&
				!this.params.flex_height
			) {
				this.setImageInRepeaterField?.(attachment);
			} else {
				this.frame.setState("cropper");
			}
		},

		/**
		 * After the image has been cropped, apply the cropped image data to the setting.
		 *
		 * @param {object} croppedImage Cropped attachment data.
		 * @returns {void}
		 */
		onCropped: function (croppedImage: object): void {
			this.setImageInRepeaterField?.(croppedImage);
		},

		/**
		 * Returns a set of options, computed from the attached image data and
		 * control-specific data, to be fed to the imgAreaSelect plugin in
		 * wp.media.view.Cropper.
		 *
		 * @param {wp.media.model.Attachment} attachment - The attachment from the WP API.
		 * @param {wp.media.controller.Cropper} controller - Media controller.
		 * @returns {object} - Options.
		 */
		calculateImageSelectOptions: function (
			this: WpbfCustomizeRepeaterControl,
			attachment: any,
			controller: any,
		): object {
			const control = controller.get("control");
			const flexWidth = !!parseInt(control.params.flex_width, 10);
			const flexHeight = !!parseInt(control.params.flex_height, 10);
			const realWidth = attachment.get("width");
			const realHeight = attachment.get("height");
			let xInit = parseInt(control.params.width, 10);
			let yInit = parseInt(control.params.height, 10);
			const ratio = xInit / yInit;
			const xImg = realWidth;
			const yImg = realHeight;
			let x1;
			let y1;

			controller.set(
				"canSkipCrop",
				!control.mustBeCropped(
					flexWidth,
					flexHeight,
					xInit,
					yInit,
					realWidth,
					realHeight,
				),
			);

			if (xImg / yImg > ratio) {
				yInit = yImg;
				xInit = yInit * ratio;
			} else {
				xInit = xImg;
				yInit = xInit / ratio;
			}

			x1 = (xImg - xInit) / 2;
			y1 = (yImg - yInit) / 2;

			const imgSelectOptions: RepeaterImageSelectOptions = {
				handles: true,
				keys: true,
				instance: true,
				persistent: true,
				imageWidth: realWidth,
				imageHeight: realHeight,
				aspectRatio: "",
				maxHeight: false,
				maxWidth: false,
				x1: x1,
				y1: y1,
				x2: xInit + x1,
				y2: yInit + y1,
			};

			if (false === flexHeight && false === flexWidth) {
				imgSelectOptions.aspectRatio = xInit + ":" + yInit;
			}

			if (false === flexHeight) {
				imgSelectOptions.maxHeight = yInit;
			}

			if (false === flexWidth) {
				imgSelectOptions.maxWidth = xInit;
			}

			return imgSelectOptions;
		},

		/**
		 * Return whether the image must be cropped, based on required dimensions.
		 *
		 * @param {bool} flexW - The flex-width.
		 * @param {bool} flexH - The flex-height.
		 * @param {int}  dstW - Initial point distance in the X axis.
		 * @param {int}  dstH - Initial point distance in the Y axis.
		 * @param {int}  imgW - Width.
		 * @param {int}  imgH - Height.
		 *
		 * @returns {bool} - Whether the image must be cropped or not based on required dimensions.
		 */
		mustBeCropped: function (
			flexW: boolean,
			flexH: boolean,
			dstW: number,
			dstH: number,
			imgW: number,
			imgH: number,
		): boolean {
			return !(
				(true === flexW && true === flexH) ||
				(true === flexW && dstH === imgH) ||
				(true === flexH && dstW === imgW) ||
				(dstW === imgW && dstH === imgH) ||
				imgW <= dstW
			);
		},

		/**
		 * If cropping was skipped, apply the image data directly to the setting.
		 *
		 * @returns {void}
		 */
		onSkippedCrop: function (): void {
			const attachment = this.frame.state().get("selection").first().toJSON();
			this.setImageInRepeaterField?.(attachment);
		},

		/**
		 * Updates the setting and re-renders the control UI.
		 *
		 * @param {Record<string, any>} attachment - The attachment object.
		 * @returns {void}
		 */
		setImageInRepeaterField: function (attachment: Record<string, any>): void {
			const $targetDiv = this.$thisButton?.closest(
				".repeater-field-image,.repeater-field-cropped_image",
			);

			$targetDiv
				?.find(".wpbf-image-attachment")
				.html('<img src="' + attachment.url + '">')
				.hide()
				.slideDown("slow");

			$targetDiv?.find(".hidden-field").val(attachment.id);
			this.$thisButton?.text(this.$thisButton.data("alt-label"));
			$targetDiv?.find(".remove-button").show();

			//This will activate the save button
			$targetDiv?.find("input, textarea, select").trigger("change");
			this.frame.close();
		},

		/**
		 * Updates the setting and re-renders the control UI.
		 *
		 * @param {Record<string, any>} attachment - The attachment object.
		 * @returns {void}
		 */
		setFileInRepeaterField: function (attachment: Record<string, any>): void {
			const $targetDiv = this.$thisButton?.closest(".repeater-field-upload");

			$targetDiv
				?.find(".wpbf-file-attachment")
				.html(
					'<span class="file"><span class="dashicons dashicons-media-default"></span> ' +
						attachment.filename +
						"</span>",
				)
				.hide()
				.slideDown("slow");

			$targetDiv?.find(".hidden-field").val(attachment.id);
			this.$thisButton?.text(this.$thisButton.data("alt-label"));
			$targetDiv?.find(".upload-button").show();
			$targetDiv?.find(".remove-button").show();

			// This will activate the save button.
			$targetDiv?.find("input, textarea, select").trigger("change");
			this.frame.close();
		},

		getMimeType: function (this: WpbfCustomizeRepeaterControl) {
			// We get the field id from which this was called
			const currentFieldId = this.$thisButton
				?.siblings("input.hidden-field")
				.attr("data-field");

			// Make sure we got it
			if (_.isString(currentFieldId) && "" !== currentFieldId) {
				// Make fields is defined and only do the hack for cropped_image
				if (
					_.isObject(this.params.fields[currentFieldId]) &&
					"upload" === this.params.fields[currentFieldId].type
				) {
					// If the attribute exists in the field
					if (undefined !== this.params.fields[currentFieldId].mime_type) {
						// Set the attribute in the main object
						return this.params.fields[currentFieldId].mime_type;
					}
				}
			}

			return "image";
		},

		removeImage: function (event) {
			if (wp.customize.utils.isKeydownButNotEnterEvent(event)) {
				return;
			}

			const $targetDiv = this.$thisButton?.closest(
				".repeater-field-image,.repeater-field-cropped_image,.repeater-field-upload",
			);
			const $uploadButton = $targetDiv?.find(".upload-button");

			$targetDiv?.find(".wpbf-image-attachment").slideUp("fast", function () {
				jQuery(this).show().html(jQuery(this).data("placeholder"));
			});
			$targetDiv?.find(".hidden-field").val("");
			$uploadButton?.text($uploadButton.data("label"));
			this.$thisButton?.hide();

			$targetDiv?.find("input, textarea, select").trigger("change");
		},

		removeFile: function (event) {
			if (wp.customize.utils.isKeydownButNotEnterEvent(event)) {
				return;
			}

			const $targetDiv = this.$thisButton?.closest(".repeater-field-upload");
			const $uploadButton = $targetDiv?.find(".upload-button");

			$targetDiv?.find(".wpbf-file-attachment").slideUp("fast", function () {
				jQuery(this).show().html(jQuery(this).data("placeholder"));
			});
			$targetDiv?.find(".hidden-field").val("");
			$uploadButton?.text($uploadButton.data("label"));
			this.$thisButton?.hide();

			$targetDiv?.find("input, textarea, select").trigger("change");
		},

		/**
		 * Get the current value of the setting
		 *
		 * @returns {Record<string, any>[]} - Returns the value.
		 */
		getValue: function (): Record<string, any>[] {
			/**
			 * The setting value returned via PHP will be associative array
			 * because we handle it via PHP in `RepeaterSetting` class.
			 *
			 * TS type equivalent of that assoc-array is Record<string, any>.
			 *
			 * But the control.setting.get() in JS will return string
			 * because it will be taken from the linked (hidden) setting field.
			 */
			const hiddenFieldValue = this.setting?.get();

			const stringValue =
				hiddenFieldValue === undefined || "string" !== typeof hiddenFieldValue
					? ""
					: hiddenFieldValue;

			// The setting is saved in JSON.
			return JSON.parse(decodeURI(stringValue));
		},

		/**
		 * Set a new value for the setting
		 *
		 * @param {Record<string, any>} newValue - The new value.
		 * @param {bool} refresh - If we want to refresh the previewer or not
		 * @param {bool} filtering - If we want to filter or not.
		 *
		 * @returns {void}
		 */
		setValue: function (
			this: WpbfCustomizeRepeaterControl,
			newValue: Record<string, any>,
			refresh?: boolean,
			filtering?: boolean,
		): void {
			// We need to filter the values after the first load to remove data requrired for diplay but that we don't want to save in DB
			const filteredValue = newValue;
			const filter: string[] = [];

			if (filtering) {
				for (const fieldId in this.params.fields) {
					if (
						this.params.fields.hasOwnProperty(fieldId) &&
						this.params.fields[fieldId].type &&
						["image", "cropped_image", "upload"].includes(
							this.params.fields[fieldId].type,
						)
					) {
						filter.push(fieldId);
					}
				}

				jQuery.each(newValue, function (key: string, value: any) {
					jQuery.each(filter, function (idx: number, field: string) {
						if (undefined !== value[field] && undefined !== value[field].id) {
							filteredValue[key][field] = value[field].id;
						}
					});
				});
			}

			this.setting?.set(encodeURI(JSON.stringify(filteredValue)));

			if (refresh) {
				// Trigger the change event on the hidden field so
				// previewer refresh the website on Customizer
				this.settingField?.trigger("change");
			}
		},

		/**
		 * Add a new row to repeater settings based on the structure.
		 *
		 * @param {Record<string, Record<string, any>>} data - (Optional) object of field => value pairs (undefined if you want to get the default values)
		 * @returns {WpbfRepeaterRow|undefined} - Returns the new row.
		 */
		addRow: function (
			this: WpbfCustomizeRepeaterControl,
			data?: Record<string, Record<string, any>>,
		): WpbfRepeaterRow | undefined {
			const control = this;

			// Get the current setting value.
			const settingValue = this.getValue?.();

			// Saves the new setting data.
			const newRowSetting: Record<string, any> = {};

			// The template for the new row (defined on Kirki_Customize_Repeater_Control::render_content() ).
			let template = control.repeaterTemplate?.();

			if (template) {
				/**
				 * Data to pass to the template.
				 *
				 * The control structure is going to define the new fields.
				 * We need to clone control.params.fields.
				 * Assigning it could result in a reference assignment.
				 */
				let templateData = jQuery.extend(true, {}, control.params.fields);

				// But if we have passed data, we'll use the data values instead
				if (data) {
					let fieldId;

					for (fieldId in data) {
						if (
							data.hasOwnProperty(fieldId) &&
							templateData.hasOwnProperty(fieldId)
						) {
							templateData[fieldId].default = data[fieldId];
						}
					}
				}

				// ? I don't know if this is necessary. Furthermore, it has type error.
				// templateData.index = this.currentIndex;

				// Append the template content
				template = template(templateData);

				// Create a new row object and append the element
				const newRow: WpbfRepeaterRow = new RepeaterRow(
					control.currentIndex ?? 0,
					jQuery(template).appendTo(control.repeaterFieldsContainer!),
					control.params.rowLabel!,
					control,
				);

				newRow.container.on(
					"row:remove",
					function (e: JQuery.TriggeredEvent, rowIndex: number) {
						control.deleteRow?.(rowIndex);
					},
				);

				newRow.container.on(
					"row:update",
					function (
						e: JQuery.TriggeredEvent,
						rowIndex: number,
						fieldName: string,
						element: HTMLInputElement | HTMLTextAreaElement,
					) {
						control.updateField?.call(control, e, rowIndex, fieldName, element);
						newRow.updateLabel?.();
					},
				);

				// Add the row to rows collection
				if (undefined !== this.currentIndex && undefined !== this.rows) {
					this.rows[this.currentIndex] = newRow;
				}

				let fieldId;

				for (fieldId in templateData) {
					if (templateData.hasOwnProperty(fieldId)) {
						newRowSetting[fieldId] = templateData[fieldId].default;
					}
				}

				if (undefined !== settingValue) {
					if (undefined !== this.currentIndex) {
						settingValue[this.currentIndex] = newRowSetting;
					}

					this.setValue?.(settingValue, true);
				}

				if (undefined !== this.currentIndex) this.currentIndex++;

				return newRow;
			}

			return undefined;
		},

		sort: function (): void {
			const control = this;

			if (!control.getValue) {
				return;
			}

			const $rows = this.repeaterFieldsContainer?.find(".repeater-row");
			const newOrder: any[] = [];
			const settings = control.getValue();
			const newRows: WpbfRepeaterRow[] = [];
			const newSettings: any[] = [];

			$rows?.each(function (i: number, element: HTMLElement) {
				newOrder.push(jQuery(element).data("row"));
			});

			jQuery.each(newOrder, function (newPosition, oldPosition) {
				if (control.rows) {
					newRows[newPosition] = control.rows[oldPosition];
				}

				newRows[newPosition].setRowIndex(newPosition);

				newSettings[newPosition] = settings[oldPosition];
			});

			control.rows = newRows;
			control.setValue?.(newSettings);
		},

		/**
		 * Delete a row in the repeater setting
		 *
		 * @param {number} index - Position of the row in the complete Setting Array
		 * @returns {void}
		 */
		deleteRow: function (index: number): void {
			if (undefined === this.rows) return;
			if (!this.getValue) return;

			const currentSettings = this.getValue();

			if (currentSettings[index]) {
				// Find the row
				const row = this.rows[index];

				if (row) {
					// Remove the row settings
					delete currentSettings[index];

					// Remove the row from the rows collection
					delete this.rows[index];

					// Update the new setting values
					this.setValue?.(currentSettings, true);
				}
			}

			// Remap the row numbers
			for (let prop in this.rows) {
				if (this.rows.hasOwnProperty(prop) && this.rows[prop]) {
					this.rows[prop].updateLabel();
				}
			}
		},

		/**
		 * Update a single field inside a row.
		 * Triggered when a field has changed
		 *
		 * @param {JQuery.TriggeredEvent} e - Event object
		 * @param {number} rowIndex - The row's index as an integer.
		 * @param {string} fieldId - The field ID.
		 * @param {HTMLInputElement | HTMLTextAreaElement} element - The element's identifier, or jQuery object of the element.
		 * @returns {void}
		 */
		updateField: function (
			this: WpbfCustomizeRepeaterControl,
			e: JQuery.TriggeredEvent,
			rowIndex: number,
			fieldId: string,
			element: HTMLInputElement | HTMLTextAreaElement,
		): void {
			if (!this.getValue) {
				return;
			}

			if (undefined === this.rows || !this.rows[rowIndex]) {
				return;
			}

			if (!this.params.fields[fieldId]) {
				return;
			}

			const type = this.params.fields[fieldId].type;
			const row = this.rows[rowIndex];
			const currentSettings = this.getValue();

			const $el = jQuery(element);

			if (undefined === currentSettings[row.rowIndex][fieldId]) {
				return;
			}

			if ("checkbox" === type) {
				currentSettings[row.rowIndex][fieldId] = $el.is(":checked");
			} else {
				// Update the settings
				currentSettings[row.rowIndex][fieldId] = $el.val();
			}

			this.setValue?.(currentSettings, true);
		},

		/**
		 * Init the color picker on color fields
		 * Called after AddRow
		 *
		 * @returns {void}
		 */
		initColorPicker: function (this: WpbfCustomizeRepeaterControl): void {
			const control = this;
			const colorPicker = control.container?.find(".wpbf-classic-color-picker");
			const fieldId = colorPicker?.data("field");
			const options: Record<string, any> = {};

			// We check if the color palette parameter is defined.
			if (
				undefined !== fieldId &&
				undefined !== control.params.fields[fieldId] &&
				undefined !== control.params.fields[fieldId].palettes &&
				_.isObject(control.params.fields[fieldId].palettes)
			) {
				options.palettes = control.params.fields[fieldId].palettes;
			}

			// When the color picker value is changed we update the value of the field
			options.change = (event: any, ui: any) => {
				if (!control.getValue) return;

				const currentPicker = jQuery(event.target);
				const row = currentPicker.closest(".repeater-row");
				const rowIndex = row.data("row");
				const currentSettings = control.getValue();
				const value =
					ui.color._alpha < 1 ? ui.color.to_s() : ui.color.toString();

				currentSettings[rowIndex][currentPicker.data("field")] = value;
				control.setValue?.(currentSettings, true);

				/**
				 * By default if the alpha is 1, the input will be rgb.
				 * We setTimeout to 50ms to prevent race value set.
				 */
				setTimeout(function () {
					event.target.value = value;
				}, 50);
			};

			// Init the color picker
			if (colorPicker && colorPicker.length > 0) {
				(colorPicker as any).wpColorPicker(options);
			}
		},

		/**
		 * Init the dropdown-pages field.
		 * Called after AddRow
		 *
		 * @param {WpbfRepeaterRow} theNewRow the row that was added to the repeater
		 * @param {Record<string, any>} data the data for the row if we're initializing a pre-existing row
		 *
		 * @returns {void}
		 */
		initSelect: function (
			this: WpbfCustomizeRepeaterControl,
			theNewRow: WpbfRepeaterRow,
			data?: Record<string, any>,
		): void {
			const control = this;
			const dropdown = theNewRow.container.find(".repeater-field select");

			if (0 === dropdown.length) {
				return;
			}

			const dataField = dropdown.data("field");

			data = data || {};
			data[dataField] = data[dataField] || "";

			jQuery(dropdown).val(data[dataField] || jQuery(dropdown).val());

			this.container.on("change", ".repeater-field select", function (event) {
				if (!control.getValue) return;

				const currentDropdown = jQuery(event.target);
				const row = currentDropdown.closest(".repeater-row");
				const rowIndex = row.data("row");
				const currentSettings = control.getValue();

				currentSettings[rowIndex][currentDropdown.data("field")] =
					jQuery(this).val();
				control.setValue?.(currentSettings);
			});
		},
	});
