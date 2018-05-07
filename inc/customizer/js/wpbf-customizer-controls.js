jQuery(document).ready(function($) {

	$('.wpbf-control-desktop').addClass('active');
		
	$('.wpbf-responsive-options .preview-desktop').click(function() {
		$('.wp-full-overlay').removeClass('preview-mobile');
		$('.wp-full-overlay').removeClass('preview-tablet');
		$('.wp-full-overlay').addClass('preview-desktop');
		$('.wpbf-responsive-options button').removeClass('active');
		$(this).addClass('active');
		$('.wpbf-control-mobile, .wpbf-control-tablet').removeClass('active');
		$('.wpbf-control-desktop').addClass('active');
	});

	$('.wpbf-responsive-options .preview-tablet').click(function() {
		$('.wp-full-overlay').removeClass('preview-desktop');
		$('.wp-full-overlay').removeClass('preview-mobile');
		$('.wp-full-overlay').addClass('preview-tablet');
		$('.wpbf-responsive-options button').removeClass('active');
		$(this).addClass('active');
		$('.wpbf-control-desktop, .wpbf-control-mobile').removeClass('active');
		$('.wpbf-control-tablet').addClass('active');
	});

	$('.wpbf-responsive-options .preview-mobile').click(function() {
		$('.wp-full-overlay').removeClass('preview-desktop');
		$('.wp-full-overlay').removeClass('preview-tablet');
		$('.wp-full-overlay').addClass('preview-mobile');
		$('.wpbf-responsive-options button').removeClass('active');
		$(this).addClass('active');
		$('.wpbf-control-desktop, .wpbf-control-tablet').removeClass('active');
		$('.wpbf-control-mobile').addClass('active');
	});

});