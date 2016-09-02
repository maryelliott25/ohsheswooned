var $ = require('jquery');

module.exports = function() {
	var $mobileNav = $('.mobile-main-navigation'),
		$mobileNavBtn = $('.mobile-nav-btn'),
		$mobileIng = $('.mobile-ingredients'),
		$mobileIngBtn = $('.mobile-ing-btn'),
		$siteWrap = $('.site-wrap');

	var navOpen = false,
		ingOpen = false;

	var toggleMenu = function() {
		$siteWrap.toggleClass('toggled');
	};

	$mobileNavBtn.click(function() {
		if(!navOpen & !ingOpen) {
			$mobileNav.addClass('toggled');
			$mobileNavBtn.addClass('toggled');
			$mobileIngBtn.addClass('toggled');
			toggleMenu();
			navOpen = true;
		} else if (!navOpen & ingOpen) {
			$mobileNav.addClass('toggled');
			$mobileIng.removeClass('toggled');
			navOpen = true;
			ingOpen = false;
		} else if (navOpen) {
			$mobileNav.removeClass('toggled');
			$mobileNavBtn.removeClass('toggled');
			$mobileIngBtn.removeClass('toggled');
			toggleMenu();
			navOpen = false;
		}
	});

	$mobileIngBtn.click(function() {
		if(!navOpen & !ingOpen) {
			$mobileIng.addClass('toggled');
			$mobileIngBtn.addClass('toggled');
			$mobileNavBtn.addClass('toggled');
			toggleMenu();
			ingOpen = true;
		} else if (!ingOpen & navOpen) {
			$mobileNav.removeClass('toggled');
			$mobileIng.addClass('toggled');
			ingOpen = true;
			navOpen = false;
		} else if (ingOpen) {
			$mobileIng.removeClass('toggled');
			$mobileNavBtn.removeClass('toggled');
			$mobileIngBtn.removeClass('toggled');
			toggleMenu();
			ingOpen = false;
		}
	});

	$mobileIng.click(function() {
		$mobileIng.toggleClass('toggled');
	});

	window.onresize = function() {
		if($(window).width() > 600) {
			$mobileNav.removeClass('toggled');
		}
	};
}