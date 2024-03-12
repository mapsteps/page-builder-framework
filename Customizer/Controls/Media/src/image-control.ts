import _, { remove } from "lodash";
import { WpbfCustomize, WpbfCustomizeControl } from "../../Base/src/interfaces";

declare var wp: {
	customize: WpbfCustomize;
	media: any;
};

wp.customize.controlConstructor["wpbf-image"] =
	wp.customize.kirkiDynamicControl.extend({
		initWpbfControl: function (control: WpbfCustomizeControl) {
			control = control || (this as WpbfCustomizeControl);
			const params = control.params;

			const saveAs = params.saveAs;
			const defaultSrc = params.defaultSrc;
			const valueSrc = params.valueSrc;

			const preview = control.container.find(".placeholder, .thumbnail");

			const removeButton: HTMLButtonElement | null =
				control.container[0].querySelector(".image-upload-remove-button");
			const defaultButton: HTMLButtonElement | null =
				control.container[0].querySelector(".image-default-button");

			if (valueSrc.id) {
				// If value is not empty, hide the "default" button.
				if (defaultButton) defaultButton.style.display = "none";
			} else {
				// If value is empty, hide the "remove" button.
				if (removeButton) removeButton.style.display = "none";
			}

			if (valueSrc.url === defaultSrc.url) {
				// If value is default, hide the default button.
				if (defaultButton) defaultButton.style.display = "none";
			}

			let previewUrl = valueSrc.url;

			if (previewUrl) {
				preview
					.removeClass()
					.addClass("thumbnail thumbnail-image")
					.html('<img src="' + previewUrl + '" alt="" />');
			}

			control.container.on("click", ".image-upload-button", function (e) {
				e.preventDefault();

				wp.media({ multiple: false })
					.open()
					.on("select", function () {
						// This will return the selected image from the "Media Uploader", the result is an object.
						const uploadedImage = image.state().get("selection").first();
						const jsonImg = uploadedImage.toJSON();

						valueSrc.id = jsonImg.id;
						valueSrc.url = jsonImg.url;
						valueSrc.width = jsonImg.width;
						valueSrc.height = jsonImg.height;

						previewUrl = jsonImg.url;

						if (!_.isUndefined(jsonImg.sizes)) {
							valueSrc.url = jsonImg.sizes.full.url;
							previewUrl = jsonImg.sizes.full.url;

							if (!_.isUndefined(jsonImg.sizes.medium)) {
								previewUrl = jsonImg.sizes.medium.url;
							} else if (!_.isUndefined(jsonImg.sizes.thumbnail)) {
								previewUrl = jsonImg.sizes.thumbnail.url;
							}
						}

						if ("array" === saveAs) {
							control.setting.set(valueSrc);
						} else if ("id" === saveAs) {
							control.setting.set(valueSrc.id);
						} else {
							control.setting.set(valueSrc.url);
						}

						if (preview.length) {
							preview
								.removeClass()
								.addClass("thumbnail thumbnail-image")
								.html('<img src="' + previewUrl + '" alt="" />');
						}

						if (removeButton) removeButton.style.display = "inline-block";
						if (defaultButton) defaultButton.style.display = "none";
					});
			});

			control.container.on(
				"click",
				".image-upload-remove-button",
				function (e) {
					e.preventDefault();

					control.setting.set("");

					if (preview.length) {
						preview
							.removeClass()
							.addClass("placeholder")
							.html(wp.i18n.__("No image selected", "kirki"));
					}
					if (removeButton.length) {
						removeButton.hide();
						if (jQuery(defaultButton).hasClass("button")) {
							defaultButton.show();
						}
					}
				},
			);

			control.container.on("click", ".image-default-button", function (e) {
				e.preventDefault();
				control.setting.set(defaultSrc);

				if (preview.length) {
					preview
						.removeClass()
						.addClass("thumbnail thumbnail-image")
						.html('<img src="' + control.params.default + '" alt="" />');
				}

				if (removeButton) removeButton.style.display = 'inline-block';
				if (defaultButton) defaultButton.style.display = 'none';
			});
		},
	});
