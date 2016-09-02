var $ = require('jquery');
var featuredSlider = require('./feature-slider');
var stickyIngredients = require('./sticky-ingredients');
var mobileMenus = require('./mobile-menus');

(function (window, document, $) {
  'use strict';

  var isMobile = false;

  if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
  	$('body').addClass('isMobile');
  	isMobile = true;
  } else {
  	$('body').addClass('isDesktop');
  }

  var $searchBtn = $('input.search-submit');
  var searchOpen = false;

  if (isMobile) {
  	$searchBtn.on('click', function(e) {
  		e.preventDefault();
  		if (searchOpen) {
  			console.log('submit search');
  		}
  		searchOpen = !searchOpen;
  	})
  }
  
  mobileMenus();
  featuredSlider();
  stickyIngredients();

})(window, document, $);