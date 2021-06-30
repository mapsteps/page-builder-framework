/**
 * Script to run on posts list screen.
 *
 * Global object used:
 * - jQuery
 * - inlineEditPost
 */
(function ($) {
	function init() {
		var layoutCheckbox = document.querySelector('#wpbf_layout-hide');
		if (layoutCheckbox) layoutCheckbox.parentNode.style.display = 'none';

		insertPresetValues();
		$(document).on("click", ".inline-edit-save .save", updatePresetValues);
	}

	/**
	 * Insert preset values to our quick edit's custom fields.
	 *
	 * @see https://applerinquest.com/how-to-add-custom-fields-to-quick-edit-in-wordpress/
	 * @see https://developer.wordpress.org/reference/hooks/quick_edit_custom_box/
	 */
	function insertPresetValues() {
		if (!inlineEditPost) return;

		var originalInlineEdit = inlineEditPost.edit;

		inlineEditPost.edit = function (id) {
			// Call the original WP edit function.
			originalInlineEdit.apply(this, arguments);

			var postId = 0;

			if (typeof id == "object") {
				postId = parseInt(this.getId(id));
			}

			if (!postId) return;

			var editRow = document.querySelector("#edit-" + postId);
			if (!editRow) return;

			var postRow = document.querySelector("#post-" + postId);
			if (!postRow) return;

			var preset = postRow.querySelector(".wpbf-quick-edit-preset-values");
			if (!preset) return;

			var fields = editRow.querySelectorAll(
				".wpbf-quick-edit-use-preset"
			);

			fields.forEach(function (field) {
				var label = field.parentNode.parentNode.querySelector("label");
				var presetName = field.dataset.wpbfPresetName;
				var presetValue = preset.getAttribute("data-wpbf-" + presetName);
				var fieldId =
					"wpbf-quick-edit-post-" +
					postId +
					"-" +
					presetName +
					"-" +
					field.value.replace(/ /g, "-");

				field.id = fieldId;
				label.htmlFor = fieldId;

				if ("checkbox" === field.type) {
					presetValue = presetValue.split(",");

					if (presetValue.includes(field.value)) {
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

			var nonceFields = editRow.querySelectorAll(
				".wpbf-quick-edit-nonce-field"
			);

			nonceFields.forEach(function (nonceField) {
				var attrName = nonceField.name.replace(/_/g, "-");
				attrName = attrName.replace("[]", "");
				var nonceValue = preset.getAttribute("data-" + attrName);

				nonceField.value = nonceValue;
			});
		};
	}

	function updatePresetValues() {
		var $editRow = $(this).closest('.inline-edit-row-page');
		if (!$editRow.length) return;

		var postId = $editRow[0].id;
		postId = postId.replace('edit-', '');
		if (!postId) return;

		var postRow = document.querySelector("#post-" + postId);
		if (!postRow) return;

		var preset = postRow.querySelector(".wpbf-quick-edit-preset-values");
		if (!preset) return;

		var fieldsArea = $editRow[0].querySelectorAll(
			".wpbf-quick-edit-fields-area"
		);

		fieldsArea.forEach(function (fieldArea) {
			var presetName = fieldArea.dataset.wpbfFieldsGroupName;
			var presetType = fieldsArea.dataset.wpbfFieldsGroupType;

			if (!presetName || !presetType) return;

			var fields;
			var values;

			if ('checkbox' === presetType) {
				fields = document.querySelectorAll(".wpbf-quick-edit-use-preset:checked");
				values = [];

				fields.forEach(function (field) {
					values.push(field.value);
				});

				values = values.join(',');
			} else {
				fields = document.querySelector(".wpbf-quick-edit-use-preset:checked");
				values = field ? field.value : value;
			}

			preset.setAttribute('data-wpbf-' + presetName, values);
		});
	}

	init();
})(jQuery);
