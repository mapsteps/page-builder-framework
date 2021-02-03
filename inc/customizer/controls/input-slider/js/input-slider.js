jQuery(document).ready(function ($) {

	// Slider Custom Control
	$('.wpbf-input-slider-control').each(function () {
		var sliderValue = $(this).find('.customize-control-slider-value').val();
		var sliderNumber = sliderValue.match(/\d+/);
		var newSlider = $(this).find('.slider');
		var sliderMinValue = parseFloat(newSlider.attr('slider-min-value'));
		var sliderMaxValue = parseFloat(newSlider.attr('slider-max-value'));
		var sliderStepValue = parseFloat(newSlider.attr('slider-step-value'));

		newSlider.slider({
			value: sliderNumber,
			min: sliderMinValue,
			max: sliderMaxValue,
			step: sliderStepValue,
			change: function (e, ui) {
				// Only executed after the sliding stopped.
				this.parentNode.querySelector('.customize-control-slider-value').dispatchEvent(new Event('change'));
				this.parentNode.querySelector('.customize-control-slider-value').dispatchEvent(new Event('keyup'));
			}
		});
	});

	// Change the value of the input field as the slider is moved
	$('.slider').on('slide', function (event, ui) {
		var sliderValue = $(this).parent().find('.customize-control-slider-value').val();
		var sliderSuffix = sliderValue.replace(/\d+/g, '');

		this.parentNode.querySelector('.customize-control-slider-value').value = ui.value + sliderSuffix;
		this.parentNode.querySelector('.customize-control-slider-value').dispatchEvent(new Event('change'));
		this.parentNode.querySelector('.customize-control-slider-value').dispatchEvent(new Event('keyup'));
	});

	// Reset slider and input field back to the default value
	$('.slider-reset').on('click', function () {
		var resetValue = $(this).attr('slider-reset-value');
		var sliderNumber = resetValue.match(/\d+/);
		$(this).parent().find('.customize-control-slider-value').val(resetValue);
		$(this).parent().find('.slider').slider('value', sliderNumber);
	});

	// Update slider if the input field loses focus as it's most likely changed
	$('.customize-control-slider-value').blur(function () {
		var resetValue = $(this).val();
		var sliderNumber = resetValue.match(/\d+/);
		var sliderSuffix = resetValue.replace(/\d+/g, '');
		var slider = $(this).parent().find('.slider');
		var sliderMinValue = parseInt(slider.attr('slider-min-value'));
		var sliderMaxValue = parseInt(slider.attr('slider-max-value'));

		// Make sure our manual input value doesn't exceed the minimum & maxmium values
		if (sliderNumber < sliderMinValue) {
			sliderNumber = sliderMinValue;
			$(this).val(sliderNumber + sliderSuffix);
		}
		if (sliderNumber > sliderMaxValue) {
			sliderNumber = sliderMaxValue;
			$(this).val(sliderNumber + sliderSuffix);
		}
		$(this).parent().find('.slider').slider('value', sliderNumber);
	});

});
