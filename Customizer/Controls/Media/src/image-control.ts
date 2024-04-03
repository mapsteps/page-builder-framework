import _ from "lodash";
import { WpbfCustomize } from "../../Base/src/interface";
import i18n from "@wordpress/i18n/build-types/default-i18n";
import { WpbfCustomizeImageControl } from "./image-interface";

declare var wp: {
	customize: WpbfCustomize;
	media: any;
	i18n: typeof i18n;
};

wp.customize.controlConstructor["wpbf-image"] =
	wp.customize.wpbfDynamicControl.extend({
		initWpbfControl: function (
			this: WpbfCustomizeImageControl,
			ctrl?: WpbfCustomizeImageControl,
		) {
			const control = ctrl || this;
			const params = control.params;

			const saveAs = params.saveAs;
			const defaultSrc = params.defaultSrc;
			const valueSrc = params.valueSrc;

			const box = control.container[0].querySelector(".attachment-media-view");

			const preview: HTMLElement | null =
				box?.querySelector(".thumbnail") ?? null;

			const selectButton: HTMLButtonElement | null =
				box?.querySelector(".button-add-media") ?? null;

			const changeButton: HTMLButtonElement | null =
				box?.querySelector(".change-button") ?? null;

			const removeButton: HTMLButtonElement | null =
				box?.querySelector(".remove-button") ?? null;

			const defaultButton: HTMLButtonElement | null =
				box?.querySelector(".default-button") ?? null;

			handleButtonsDisplay();

			let previewUrl = valueSrc.url;

			if (preview && previewUrl) {
				preview.innerHTML =
					'<img class="attachment-thumb" src="' + previewUrl + '" alt="" />';
			}

			selectButton?.addEventListener("click", openMediaLibrary);
			changeButton?.addEventListener("click", openMediaLibrary);
			removeButton?.addEventListener("click", removeImage);
			defaultButton?.addEventListener("click", useDefaultValue);

			function openMediaLibrary() {
				const selectedImage = wp
					.media({ multiple: false })
					.open()
					.on("select", function () {
						// This will return the selected image from the "Media Uploader", the result is an object.
						const uploadedImage = selectedImage
							.state()
							.get("selection")
							.first();

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
							control.setting?.set(valueSrc);
						} else if ("id" === saveAs) {
							control.setting?.set(valueSrc.id);
						} else if ("url" === saveAs) {
							control.setting?.set(valueSrc.url);
						}

						if (preview) {
							preview.innerHTML =
								'<img class="attachment-thumb" src="' +
								previewUrl +
								'" alt="" />';
						}

						handleButtonsDisplay();
					});
			}

			function removeImage() {
				emptyValue();

				if ("array" === saveAs) {
					control.setting?.set(valueSrc);
				} else if ("id" === saveAs) {
					control.setting?.set(0);
				} else if ("url" === saveAs) {
					control.setting?.set("");
				}

				if (preview) {
					preview.innerHTML = wp.i18n.__("No image selected", "wpbf");
				}

				handleButtonsDisplay();
			}

			function useDefaultValue() {
				control.setting?.set(defaultSrc);

				if (preview) {
					preview.innerHTML =
						'<img class="attachment-thumb" src="' +
						control.params.default +
						'" alt="" />';
				}

				handleButtonsDisplay();
			}

			function emptyValue() {
				valueSrc.id = 0;
				valueSrc.url = "";
				valueSrc.width = 0;
				valueSrc.height = 0;
			}

			function handleButtonsDisplay() {
				if (valueSrc.url) {
					if (preview) preview.classList.remove("hidden");
					if (removeButton) removeButton.classList.remove("hidden");
					if (selectButton) selectButton.classList.add("hidden");
					if (changeButton) changeButton.classList.remove("hidden");
				} else {
					if (preview) preview.classList.add("hidden");
					if (removeButton) removeButton.classList.add("hidden");
					if (selectButton) selectButton.classList.remove("hidden");
					if (changeButton) changeButton.classList.add("hidden");
				}

				if (valueSrc.id === defaultSrc.id) {
					if (defaultButton) defaultButton.classList.add("hidden");
				} else {
					if (defaultButton) defaultButton.classList.remove("hidden");
				}
			}
		},
	});
