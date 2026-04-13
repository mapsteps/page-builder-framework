init();

function init() {
	const layoutOptions = document.querySelectorAll(".wpbf-layout-option");

	layoutOptions.forEach(function (layoutOption) {
		layoutOption.addEventListener("change", onLayoutTypeChange);
	});
}

function onLayoutTypeChange() {
	const customWidthFieldWrapper = document.querySelector(
		".wpbf-layout-custom-width-field-wrapper",
	);
	if (!customWidthFieldWrapper) return;

	const layout = document.querySelector("#layout-custom-width");

	if (layout instanceof HTMLInputElement && layout.checked) {
		customWidthFieldWrapper.classList.remove("wpbf-is-hidden");
	} else {
		customWidthFieldWrapper.classList.add("wpbf-is-hidden");
	}
}
