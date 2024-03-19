init();

function init() {
	const layoutCheckbox = document.querySelector("#wpbf_layout-hide");

	if (layoutCheckbox) {
		const checkboxParent = layoutCheckbox.parentNode;

		if (checkboxParent && checkboxParent instanceof HTMLElement) {
			checkboxParent.style.display = "none";
		}
	}

	insertPresetValues();
	jQuery(document).on("click", ".inline-edit-save .save", updatePresetValues);
}

/**
 * Insert preset values to our quick edit's custom fields.
 *
 * @see https://applerinquest.com/how-to-add-custom-fields-to-quick-edit-in-wordpress/
 * @see https://developer.wordpress.org/reference/hooks/quick_edit_custom_box/
 */
function insertPresetValues() {
	// @ts-ignore
	if (!window.inlineEditPost) return;

	// @ts-ignore
	const originalInlineEdit = window.inlineEditPost.edit;

	// @ts-ignore
	window.inlineEditPost.edit = quickEditScript;

	/**
	 * Custom script for quick edit in post list table in admin area.
	 *
	 * @param {string|number|Object} id The post ID.
	 * @this {any}
	 */
	function quickEditScript(id) {
		// Call the original WP edit function.
		originalInlineEdit.apply(this, arguments);

		let postId = 0;

		if (typeof id == "object") {
			postId = parseInt(this.getId(id));
		}

		if (!postId) return;

		const editRow = document.querySelector("#edit-" + postId);
		if (!editRow) return;

		const postRow = document.querySelector("#post-" + postId);
		if (!postRow) return;

		const preset = postRow.querySelector(".wpbf-quick-edit-preset-values");
		if (!preset) return;

		const fields = editRow.querySelectorAll(".wpbf-quick-edit-use-preset");

		fields.forEach(function (field) {
			if (!(field instanceof HTMLInputElement)) return;

			const fieldParent = field.parentNode?.parentNode;
			const label = fieldParent ? fieldParent.querySelector("label") : null;
			const presetName = field.dataset.wpbfPresetName;
			const presetValue = preset.getAttribute("data-wpbf-" + presetName);
			const fieldId =
				"wpbf-quick-edit-post-" +
				postId +
				"-" +
				presetName +
				"-" +
				field.value.replace(/ /g, "-");

			field.id = fieldId;
			if (label) label.htmlFor = fieldId;

			if ("checkbox" === field.type) {
				/**
				 * @type {string[]}
				 */
				const presetValues = presetValue ? presetValue.split(",") : [];

				if (presetValues.includes(field.value)) {
					field.checked = true;
				} else {
					field.checked = false;
				}
			} else if ("radio" === field.type) {
				// Think about numeric value, that's why we don't use strict comparison here.
				if (presetValue == field.value) {
					field.checked = true;
				} else {
					field.checked = false;
				}
			}
		});

		const nonceFields = editRow.querySelectorAll(
			".wpbf-quick-edit-nonce-field",
		);

		nonceFields.forEach(function (nonceField) {
			if (!(nonceField instanceof HTMLInputElement)) return;
			let attrName = nonceField.name.replace(/_/g, "-");
			attrName = attrName.replace("[]", "");
			const nonceValue = preset.getAttribute("data-" + attrName);

			if (nonceValue) nonceField.value = nonceValue;
		});
	}
}

/**
 * Update preset values when saving quick edit.
 *
 * @this {HTMLElement}
 */
function updatePresetValues() {
	const $editRow = $(this).closest(".inline-edit-row-page");
	if (!$editRow.length) return;

	let postId = $editRow[0].id;
	postId = postId.replace("edit-", "");
	if (!postId) return;

	const postRow = document.querySelector("#post-" + postId);
	if (!postRow) return;

	const preset = postRow.querySelector(".wpbf-quick-edit-preset-values");
	if (!preset) return;

	const fieldsArea = $editRow[0].querySelectorAll(
		".wpbf-quick-edit-fields-area",
	);

	fieldsArea.forEach(function (fieldArea) {
		if (!(fieldArea instanceof HTMLElement)) return;

		const presetName = fieldArea.dataset.wpbfFieldsGroupName;
		const presetType = fieldArea.dataset.wpbfFieldsGroupType;

		if (!presetName || !presetType) return;

		/**
		 * Values formatted in comma separated string.
		 *
		 * @type {string}
		 */
		let valuesStr = "";

		if ("checkbox" === presetType) {
			const fields = document.querySelectorAll(
				".wpbf-quick-edit-use-preset:checked",
			);

			/**
			 * @type {string[]}
			 */
			const values = [];

			fields.forEach(function (field) {
				if (!(field instanceof HTMLInputElement)) return;
				values.push(field.value);
			});

			valuesStr = values.join(",");
		} else {
			const field = document.querySelector(
				".wpbf-quick-edit-use-preset:checked",
			);

			if (field instanceof HTMLInputElement) {
				valuesStr = field.value;
			}
		}

		preset.setAttribute("data-wpbf-" + presetName, valuesStr);
	});
}
