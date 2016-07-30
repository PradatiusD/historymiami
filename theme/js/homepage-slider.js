
(function ($) {

// var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

var viewPortHeight = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
var navbarHeight   = $('.navbar-fixed-top').height();

var sliderHeight = viewPortHeight - navbarHeight;

$('.swiper-container').height(sliderHeight);

var options = {
  loop: true,
  autoplay: 5000,
  duration: 900
};

var slider = new Swiper('.swiper-container', options);

})(jQuery);