
(function ($) {

// var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

var htmlHeight   = $(document).height();
var navbarHeight = $('.navbar-fixed-top').height();

$('.swiper-container').height(htmlHeight - navbarHeight);

var options = {
  loop: true,
  autoplay: 5000,
  duration: 900
};

var slider = new Swiper('.swiper-container', options);

})(jQuery);