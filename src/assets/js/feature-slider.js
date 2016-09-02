var $ = require('jquery');
var slick = require('slick-carousel');

module.exports = function() {
	$('.featured-content-area').slick({
		arrows: false,
		dots: true,
		infinite: true,
		slidesToShow: 3,
		variableWidth: true,
		centerMode: true,
		responsive: [
			{
				breakpoint: 650,
			    settings: {
			      	slidesToShow: 1,
			      	variableWidth: false,
			      	centerMode: false
			    }
			}
		]
	});
}
