var $ = require('jquery');

module.exports = function() {
	var $recipePage = $('.single-recipe');
	var $ingredientsWrapper = $recipePage.find('.desktop-ingredients');
	var $ingredients = $ingredientsWrapper.find('.ingredients');
	var $content = $('.entry-content');
	var $window = $(window);
	var diff = 200;

	var stick = function() {
		if ($window.width() > 600) {
			var windowTop = $window.scrollTop();
			var ingredientsTop = $ingredientsWrapper.offset().top;
			var difference = ingredientsTop - windowTop;

			var contentPos = $content.height() + $content.offset().top - $ingredients.height() - diff - 25;
			var diffBottom = contentPos - $(window).scrollTop();
			if (difference <= 200) {
				$ingredients.addClass('is-sticky');
				if (diffBottom < 0) {
					$ingredients.addClass('is-bottom');
				} else {
					$ingredients.removeClass('is-bottom');
				}
			} else {
				$ingredients.removeClass('is-sticky');
			}
		} else { $ingredients.removeClass('is-sticky is-bottom'); }
					
	}

	if ($recipePage.length) {
		stick();

		window.addEventListener('scroll', function() {
			stick();
		});

		window.addEventListener('resize', function() {
			stick();
		});

		window.addEventListener('orientationchange', function() {
			stick();
		});
	}
	
}