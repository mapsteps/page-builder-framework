(function ($) {
	var customWidthFieldWrapper = document.querySelector('.wpbf-layout-custom-width-field-wrapper');

	function init() {
		$('.wpbf-layout-option').on('change', onLayoutTypeChange);
	}

	function onLayoutTypeChange() {
		if (document.querySelector('#layout-custom-width').checked) {
			customWidthFieldWrapper.classList.remove('wpbf-is-hidden');
		} else {
			customWidthFieldWrapper.classList.add('wpbf-is-hidden');
		}
	}

	init();
})(jQuery);